<?php

namespace skh6075\minigame;

use pocketmine\plugin\Plugin;

final class MiniGameHandler{

    private static ?Plugin $registrant = null;

    public static function isRegistrant(): bool{
        return self::$registrant instanceof Plugin;
    }

    public static function register(Plugin $plugin): void{
        if (self::isRegistrant()) {
            throw new \InvalidStateException("It is already linked to another class.");
        }

        self::$registrant = $plugin;
        self::$registrant->getServer()->getPluginManager()->registerEvents(new MiniGameListener(), self::$registrant);
    }

    public static function getRegistrant(): Plugin{
        return self::$registrant;
    }
}