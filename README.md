# MiniGameAPI
PocketMine-MP easily implement minigames.

# Usage

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

# Histories

* Add Functions
  - https://github.com/SKHPMMPPlugins/MiniGameAPI/commit/128e8b34e0ed48d2a80ead8ff28db455081df4b5
  - https://github.com/SKHPMMPPlugins/MiniGameAPI/commit/34ec19ec2030f4c36ab15b9e50276ab7c6078c39
  - https://github.com/SKHPMMPPlugins/MiniGameAPI/commit/10fdd4e8b3cadaa7aef2878e741b359fe333897b

* Delete Unnecessary Functions
  - https://github.com/SKHPMMPPlugins/MiniGameAPI/commit/0483069bb1df1a35d7a9e4cb0025b5c75f05f29a
