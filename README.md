# MiniGameAPI
PocketMine-MP easily implement minigames.

# Usage
## Make GameRoom class.
```php
class ZombieSurvivalRoom extends GameRoom{

    public function startGame(): void{}
    
    public function endGame(string $winner): void{}
}
```

## GameRoomManager

- Add your GameRoom to the manager.
```php
GameRoomManager::getInstance()->addGameRoom(string $category, GameRoom $room);
```

- You can call up all GameRooms that are registered in the management.
```php
GameRoomManager::getInstance()->getGameRooms(string $category);
```

- also, get all GameRooms.
```php
GameRoomManager::getInstance()->getAllGameRooms();
```

## WorldGenerator

- extractWorld
```php
// $zipPath - zip file directory.
// $name - original zip file name.
// $load - after world load.
WorldGenerator::getInstance()->extractWorldToDirectory(string $zipPath, string $name, bool $load = false);
```

- restoreWorld
```php
// $zipPath - zip file directory.
// $name - original zip file name.
WorldGenerator::getInstance()->restoreWorld(string $zipPath, string $name)
```
