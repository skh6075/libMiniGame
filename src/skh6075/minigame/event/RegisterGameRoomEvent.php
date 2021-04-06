<?php

namespace skh6075\minigame\event;

use pocketmine\event\Event;
use skh6075\minigame\MiniGameRoom;

class RegisterGameRoomEvent extends Event{

    private MiniGameRoom $room;

    public function __construct(MiniGameRoom $room) {
        $this->room = $room;
    }

    public function getRoom(): MiniGameRoom{
        return $this->room;
    }
}