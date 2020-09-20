<?php


namespace skh6075\MiniGameAPI;

use skh6075\MiniGameAPI\game\GameRoom;

class MiniGameFactory{

    /** @var GameRoom[] */
    private static $rooms = [];
    
    
    public static function addGameRoom (GameRoom $room): void{
        self::$rooms [$room->getName()] = $room;
    }
    
    public static function deleteGameRoom (string $name): void{
        if (isset (self::$rooms [$name])) {
            unset (self::$rooms [$name]);
        }
    }
    
    public static function getGameRoom (string $name): ?GameRoom{
        return self::$rooms [$name] ?? null;
    }
    
    public static function getRooms (): array{
        return array_keys (self::$rooms);
    }
}