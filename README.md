# MiniGameAPI
PocketMine-MP easily implement minigames.

# Usage

```php
protected function onEnable(): void{
    if (!MiniGameHandler::isRegistrant()) {
        MiniGameHandler::register($this);
    }
}
```
