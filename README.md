# MiniGameAPI
Tools that make it easy for developers to create MiniGames.

```PHP Version: 8.0.9```

# Usage

Write the code below in the onEnable method of the minigame plugin you are creating.
```php
public function onEnable() : void{
    if(!MiniGameHandler::isRegistered()){
        MiniGameHandler::register($this);
    }
}
```
</br>
</br>

Team overrides are as follows:
```php
final class ColorMatchRoom extends MiniGameRoom{
	
	public function __construct(
		string $name,
		int $minPlayerCount, 
		int $maxPlayerCount, 
		Plugin $plugin, 
		int $gamemode = self::GAMEMODE_DEFAULT, 
		array $players = [], 
		?MiniGameTeamManager $teamManager = null){
		parent::__construct($name, $minPlayerCount, $maxPlayerCount, $plugin, $gamemode, $players, $teamManager);
	}
}
```
</br>
</br>

This plugin supports team features.
If you create a game room without using the team feature.
```php
final class RedTeam extends MiniGameTeam{}
```
```php
final class BlueTeam extends MiniGameteam{}
```
</br>

```php
$teamManager = new MiniGameTeamManager(
    new RedTeam("RED", []),
    new BlueTeam("BLUE", [])
);
```

</br>
</br>

This library manages the player's inventory.
```php
$invManager = PlayerInventoryManager::getInstance();
```

</br>

You can save or load the player's inventory.
```php
public function onPlayerJoinEvent(PlayerJoinEvent $event) : void{
    $invManager = PlayerInventoryManager::getInstance();
    $invManager->send($event->getPlayer());
}
```
```php
public function onPlayerQuitEvent(PlayerQuitEvent $event) : void{
    $invManager = PlayerInventoryManager::getInstance();
    $invManager->save($event->getPlayer());
}
```
