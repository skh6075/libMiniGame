<?php

namespace skh6075\minigame;

use pocketmine\player\Player;
use pocketmine\utils\SingletonTrait;

final class MiniGameRoomFactory{
    use SingletonTrait;

    /** @var MiniGameRoom[] */
    private static array $rooms = [];

    public function __construct() {
        self::setInstance($this);
    }

    public function isRegisteredRoom(string $name): bool{
        return isset(self::$rooms[$name]);
    }

    public function registerRoom(MiniGameRoom $room): void{
        if ($this->isRegisteredRoom($room->getName())) {
            throw new \InvalidStateException("This is an already registered game room.");
        }

        self::$rooms[$room->getName()] = $room;
    }

    public function unregisterRoom(MiniGameRoom $room): void{
        if (!$this->isRegisteredRoom($room->getName())) {
            return;
        }

        unset(self::$rooms[$room->getName()]);
    }

    public function getGameRooms(): array{
        return self::$rooms;
    }

    public function getPlayerJoinedGameRoom(Player $player): ?MiniGameRoom{
        foreach (self::$rooms as $room) {
            if ($room->isJoinedPlayer($player))
                return $room;
        }

        return null;
    }
}