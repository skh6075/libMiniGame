<?php


namespace skh6075\MiniGameAPI\game;

use pocketmine\Server;
use pocketmine\Player;

use skh6075\MiniGameAPI\MiniGameAPI;
use skh6075\MiniGameAPI\team\TeamFactory;
use skh6075\MiniGameAPI\event\JoinGameRoomEvent;
use skh6075\MiniGameAPI\event\QuitGameRoomEvent;

use function in_array;
use function count;
use function array_search;

abstract class GameRoom{

    private $name;
    
    private $member = [];
    
    private $gamemode = 0;
    
    /** @var TeamFactory */
    private $teamFactory;
    
    
    protected $minPlayer = 0;
    protected $maxPlayer = 1;
    
    
    public function __construct (string $name, int $minPlayer = 0, int $maxPlayer = 1, ?TeamFactory $teamFactory = null) {
        $this->name = $name;
        $this->minPlayer = $minPlayer;
        $this->maxPlayer = $maxPlayer;
        $this->teamFactory = $teamFactory;
    }
    
    final public function getName (): string{
        return $this->name;
    }
    
    final public function getMinPlayer (): int{
        return $this->minPlayer;
    }
    
    final public function getMaxPlayer (): int{
        return $this->maxPlayer;
    }
    
    final public function getTeamFactory (): ?TeamFactory{
        return $this->teamFactory;
    }
    
    final public function getGamemode (): int{
        return $this->gamemode;
    }
    
    public function setGamemode (int $mode): void{
        $this->gamemode = $mode;
    }
    
    final public function isMember ($player): bool{
        return in_array (MiniGameAPI::convertName ($player), $this->member);
    }
    
    public function addMember ($player): bool{
        if (!$this->isMember ($player)) {
            if (count ($this->member) < $this->getMaxPlayer ()) {
                $this->member [] = MiniGameAPI::convertName ($player);
            }
            return true;
        }
        return false;
    }
    
    public function deleteMember ($player): bool{
        if ($this->isMember ($player)) {
            unset ($this->member [array_search (MiniGameAPI::convertName ($player), $this->member)]);
            return true;
        }
        return false;
    }
    
    final public function resetMember (): void{
        $this->member = [];
    }
    
    public function startGame (): void{
    }
    
    public function endGame (string $winner): void{
    }
    
    /**
     * @return Player[]
     */
    public function getMemberPlayers (): array{
        $res = [];
        foreach ($this->member as $name) {
            if (($player = Server::getInstance ()->getPlayer ($name)) !== null)
                $res [] = $player;
        }
        return $res;
    }
    
    public function broadcastMessage (string $msg): void{
        foreach ($this->getMemberPlayers () as $player) {
            $player->sendMessage ($msg);
        }
    }
    
    public function broadcastPopup (string $popup): void{
        foreach ($this->getMemberPlayers () as $player) {
            $player->addActionBarMessage ($popup);
        }
    }
}
