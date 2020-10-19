<?php


namespace skh6075\MiniGameAPI;

use pocketmine\plugin\PluginBase;
use pocketmine\Player;

use skh6075\MiniGameAPI\listener\EventListener;

class MiniGameAPI extends PluginBase{

    /** @var MiniGameAPI */
    private static $instance;
    
    
    public static function getInstance (): ?MiniGameAPI{
        return self::$instance;
    }
    
    public function onLoad (): void{
        if (self::$instance === null) {
            self::$instance = $this;
        }
    }
    
    public static function convertName ($player): string{
        return strtolower ($player instanceof Player ? $player->getName () : $player);
    }
}
