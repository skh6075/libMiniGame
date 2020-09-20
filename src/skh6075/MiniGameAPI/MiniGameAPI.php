<?php


namespace skh6075\MiniGameAPI;

use pocketmine\plugin\PluginBase;
use pocketmine\Player;

use skh6075\MiniGameAPI\lang\PluginLang;
use skh6075\MiniGameAPI\listener\EventListener;

class MiniGameAPI extends PluginBase{

    /** @var MiniGameAPI */
    private static $instance;
    
    /** @var BaseLang */
    protected $baseLang;
    
    
    public static function getInstance (): ?MiniGameAPI{
        return self::$instance;
    }
    
    public function onLoad (): void{
        if (self::$instance !== null) {
            throw new \InvalidStateException ();
        }
        self::$instance = $this;
    }
    
    public function onEnable (): void{
        @mkdir ($this->getDataFolder () . "lang/");
        foreach ($this->getResources () as $resource) {
            file_put_contents ($this->getDataFolder () . "lang/" . $resource->getFilename (), file_get_contents ($resource->getPathname ()));
        }
        
        $lang = $this->getServer ()->getLanguage ()->getLang ();
        $this->baseLang = new PluginLang ($this, $lang);
        $this->baseLang->init ();
        
        $this->getServer ()->getPluginManager ()->registerEvents (new EventListener (), $this);
    }
    
    public function onDisable (): void{
    }
    
    /**
     * @return PluginLang
     */
    public function getBaseLang (): PluginLang{
        return $this->baseLang;
    }
    
    public static function convertName ($player): string{
        return strtolower ($player instanceof Player ? $player->getName () : $player);
    }
}