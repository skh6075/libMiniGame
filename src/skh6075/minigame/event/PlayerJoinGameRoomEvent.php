<?php

namespace skh6075\minigame\event;

use pocketmine\event\Cancellable;
use pocketmine\event\CancellableTrait;
use pocketmine\event\Event;
use pocketmine\player\Player;
use skh6075\minigame\MiniGameRoom;

class PlayerJoinGameRoomEvent extends Event implements Cancellable{
    use CancellableTrait;

    private Player $player;

    private MiniGameRoom $room;

    public function __construct(Player $player, MiniGameRoom $room) {
        $this->player = $player;
        $this->room = $room;
    }

    public function getPlayer(): Player{
        return $this->player;
    }

    public function getRoom(): MiniGameRoom{
        return $this->room;
    }
}