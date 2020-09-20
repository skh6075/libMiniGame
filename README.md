# MiniGameAPI
PocketMine-MP easily implement minigames.

### Usage

#### Make GameRoom class.

```php
class MafiaGameRoom extends \skh6075\MiniGameAPI\game\GameRoom{
}
```

#### Register GameRoom class.

```php
$teamFactory = new \skh6075\MiniGameAPI\team\TeamFactory (
    new \skh6075\MiniGameAPI\team\Team ("citizen"),
    new \skh6075\MiniGameAPI\team\Team ("mafia"),
    new \skh6075\MiniGameAPI\team\Team ("police"),
    new \skh6075\MiniGameAPI\team\Team ("doctor"),
    new \skh6075\MiniGameAPI\team\Team ("repoter"),
    new \skh6075\MiniGameAPI\team\Team ("spy")
);
$minPlayer = 8;
$maxPlayer = 12;
$room = new MafiaGameRoom ("mafia", $minPlayer, $maxPlayer, $teamFactory);
\skh6075\MiniGameAPI\MiniGameFactory::addGameRoom ($room);
```

- Implement the rest of the coding in the MafiaGameRoom class by yourself.
