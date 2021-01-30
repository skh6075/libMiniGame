<?php

namespace skh6075\minigameapi\game;

use pocketmine\utils\SingletonTrait;

final class GameRoomManager{
    use SingletonTrait;

    /** @var GameRoom[][] */
    private static array $rooms = [];


    public function __construct() {
        self::setInstance($this);
    }

    public function getAllGameRooms(): array{
        return self::$rooms;
    }

    public function getGameRooms(string $category): array{
        return self::$rooms[$category] ?? [];
    }

    public function addGameRoom(string $category, GameRoom $room): void{
        if (!isset(self::$rooms[$category])) {
            self::$rooms[$category] = [];
        }
        self::$rooms[$category][] = $room;
    }

    public function deleteGameRoom(string $category, int $roomId): void{
        if (isset(self::$rooms[$category]) and isset(self::$rooms[$category][$roomId])) {
            unset(self::$rooms[$category][$roomId]);
        }
    }
}