<?php


namespace skh6075\MiniGameAPI\event;

use pocketmine\event\Event;
use pocketmine\event\Cancellable;

use skh6075\MiniGameAPI\game\GameRoom;

class QuitGameRoomEvent extends Event implements Cancellable{

    /** @var GameRoom */
    private $room;
    
    /** @var string */
    private $name;
    
    
    public function __construct (GameRoom $room, string $name) {
        $this->room = $room;
        $this->name = $name;
    }
    
    public function getGameRoom (): GameRoom{
        return $this->room;
    }
    
    public function getName (): string{
        return $this->name;
    }
}