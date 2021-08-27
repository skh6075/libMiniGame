<?php

declare(strict_types=1);

namespace skh6075\lib\minigame;

use InvalidArgumentException;
use pocketmine\plugin\Plugin;

final class MiniGameHandler{

	private static ?Plugin $registrant = null;

	public static function isRegistered(): bool{
		return self::$registrant !== null;
	}

	public static function getRegistrant(): ?Plugin{
		return self::$registrant;
	}

	public static function register(Plugin $plugin): void{
		if(self::isRegistered()){
			throw new InvalidArgumentException("{$plugin->getName()} attempted to register " . self::class . " twice.");
		}
		self::$registrant = $plugin;
		self::$registrant->getServer()->getPluginManager()->registerEvents(new MiniGameEventHandler(), self::$registrant);
	}
}