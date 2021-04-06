<?php

namespace skh6075\minigame;

use pocketmine\player\Player;
use pocketmine\Server;
use skh6075\minigame\event\PlayerJoinGameRoomEvent;
use skh6075\minigame\event\PlayerQuitGameRoomEvent;
use skh6075\minigame\event\RegisterGameRoomEvent;
use skh6075\minigame\inventory\PlayerInventory;
use skh6075\minigame\task\GameStartCheckTask;
use skh6075\minigame\team\TeamFactory;

class MiniGameRoom{

    private string $name;

    protected int $minPlayer;

    protected int $maxPlayer;

    protected int $gamemode = 0;

    /** @var string[] */
    private array $players = [];

    private ?TeamFactory $teamFactory;

    public function __construct(string $name, int $minPlayer, int $maxPlayer, ?TeamFactory $teamFactory = null) {
        $this->name = $name;
        $this->minPlayer = $minPlayer;
        $this->maxPlayer = $maxPlayer;
        $this->teamFactory = $teamFactory;

        (new RegisterGameRoomEvent($this))->call();
    }

    final public function getName(): string{
        return $this->name;
    }

    final public function getMinPlayer(): int{
        return $this->minPlayer;
    }

    final public function getMaxPlayer(): int{
        return $this->maxPlayer;
    }

    final public function canJoinPlayer(): bool{
        return $this->maxPlayer > count($this->players);
    }

    final public function getPlayers(): array{
        return $this->players;
    }

    /** @return Player[] */
    final public function getPlayersToPlayer(): array{
        return array_map(function (string $name): Player{ return Server::getInstance()->getPlayerExact($name); }, $this->players);
    }

    final public function isJoinedPlayer(Player $player): bool{
        return array_search($player->getName(), $this->players) !== null;
    }

    public function addJoinPlayer(Player $player): bool{
        if ($this->canJoinPlayer() and !$this->isJoinedPlayer($player)) {
            $ev = new PlayerJoinGameRoomEvent($player, $this);
            $ev->call();
            if (!$ev->isCancelled()) {
                $this->players[] = $player->getName();
                if ($this->minPlayer <= count($this->players)) {
                    MiniGameHandler::getRegistrant()->getScheduler()->scheduleRepeatingTask(new GameStartCheckTask($this, $this->getDefaultGameStartLeftTime()), 20);
                }

                return true;
            }
        }

        return false;
    }

    public function deleteJoinPlayer(Player $player): void{
        if ($this->isJoinedPlayer($player)) {
            unset($this->players[array_search($player->getName(), $this->players)]);
            (new PlayerQuitGameRoomEvent($player, $this))->call();
        }
    }

    final public function getGamemode(): int{
        return $this->gamemode;
    }

    public function setGamemode(int $gamemode): void{
        $this->gamemode = $gamemode;
    }

    public function getTeamFactory(): ?TeamFactory{
        return $this->teamFactory;
    }

    public function getDefaultGameStartLeftTime(): int{
        return 130;
    }

    public function getWaitingPopupMessage(): array{
        $arr = [
            "§r§f= = = [ §a" . $this->getName() . "§f Game Room ] = = =",
            "§r§f - Left Time: %leftTime%"
        ];
        if ($this->minPlayer > count($this->players)) {
            $arr[] = "§r§f - Need Player: " . ($this->minPlayer - count($this->players)) . " Count.";
        }

        return $arr;
    }

    public function onGameStart(): void{
        foreach ($this->getPlayersToPlayer() as $player) {
            PlayerInventory::getInstance()->savePlayerInventory($player, true);
        }
    }

    public function onGameEnd(int $winner): void{
        foreach ($this->getPlayersToPlayer() as $player) {
            PlayerInventory::getInstance()->sendSavePlayerInventory($player);
        }
    }
}