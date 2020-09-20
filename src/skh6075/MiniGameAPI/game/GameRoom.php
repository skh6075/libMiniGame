<?php


namespace skh6075\MiniGameAPI\game;

use pocketmine\Server;

use skh6075\MiniGameAPI\MiniGameAPI;
use skh6075\MiniGameAPI\team\TeamFactory;
use skh6075\MiniGameAPI\event\JoinGameRoomEvent;
use skh6075\MiniGameAPI\event\QuitGameRoomEvent;

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
    
    public function addMember ($player): void{
        if (!$this->isMember ($player)) {
            $event = new JoinGameRoomEvent ($this, MiniGameAPI::convertName ($player));
            $event->call ();
            if ($event->isCancelled ()) {
                return;
            }
            $this->member [] = MiniGameAPI::convertName ($player);
        }
    }
    
    public function deleteMember ($player): void{
        if ($this->isMember ($player)) {
            $event = new QuitGameRoomEvent ($this, MiniGameAPI::convertName ($player));
            $event->call ();
            if ($event->isCancelled ()) {
                return;
            }
            unset ($this->member [array_search (MiniGameAPI::convertName ($player), $this->member)]);
        }
    }
    
    public function startGame (): void{
    }
    
    public function endGame (): void{
    }
    
    public function broadcastMessage (string $msg): void{
        foreach ($this->member as $name) {
            if (($player = Server::getInstance ()->getPlayer ($name)) !== null)
                $player->sendMessage ($msg);
        }
    }
}