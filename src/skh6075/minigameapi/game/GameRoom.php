<?php

namespace skh6075\minigameapi\game;

use pocketmine\Player;
use pocketmine\Server;
use skh6075\minigameapi\game\team\TeamFactory;
use function in_array;
use function array_map;
use function array_filter;
use function array_search;
use function count;

abstract class GameRoom{

    protected string $name;

    protected array $member = [];

    protected int $gamemode = 0;

    protected ?TeamFactory $teamFactory = null;

    protected int $minPlayer = 0;

    protected int $maxPlayer = 1;

    protected int $gameTime = -1;


    public function __construct(string $name, int $minPlayer, int $maxPlayer, ?TeamFactory $teamFactory = null) {
        $this->name = $name;
        $this->minPlayer = $minPlayer;
        $this->maxPlayer = $maxPlayer;
        $this->teamFactory = $teamFactory;
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

    final public function getMembers(): array{
        return $this->member;
    }

    /**
     * @return Player[]
     */
    final public function getMemberToPlayers(): array{
        return array_filter(array_map(function (string $name): ?Player{
            return Server::getInstance()->getPlayer($name);
        }, $this->member), function ($player) {
            return $player instanceof Player;
        }, ARRAY_FILTER_USE_KEY);
    }

    final public function isMember(Player $player): bool{
        return in_array($player->getLowerCaseName(), $this->member);
    }

    final public function resetMember(): void{
        $this->member = [];
    }

    public function addMember(Player $player): bool{
        if (!$this->isMember($player) and count($this->member) < $this->maxPlayer) {
            $this->member[] = $player->getLowerCaseName();
            return true;
        }
        return false;
    }

    public function deleteMember(Player $player, bool $isRunning = false): bool{
        if ($this->isMember($player)) {
            if ($isRunning and $this->gamemode === 0) {
                unset($this->member[array_search($player->getLowerCaseName(), $this->member)]);
                return true;
            }
        }
        return false;
    }

    final public function getGamemode(): int{
        return $this->gamemode;
    }

    public function setGamemode(int $gamemode = 0): void{
        $this->gamemode = $gamemode;
    }

    final public function getTeamFactory(): ?TeamFactory{
        return $this->teamFactory;
    }

    final public function getGameTime(): int{
        return $this->gameTime;
    }

    final public function setGameTime(int $time): void{
        $this->gameTime = $time;
    }

    abstract public function startGame(): void;
    abstract public function endGame(string $winner): void;
}