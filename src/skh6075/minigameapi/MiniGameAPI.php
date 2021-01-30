<?php

namespace skh6075\minigameapi;

use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;
function convertName($player): string{
    return strtolower($player instanceof Player ? $player->getLowerCaseName() : $player);
}

class MiniGameAPI extends PluginBase{
    use SingletonTrait;


    public function onLoad(): void{
        self::setInstance($this);
    }
}