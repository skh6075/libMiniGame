<?php

declare(strict_types=1);

namespace skh6075\lib\minigame\room;

use pocketmine\plugin\Plugin;
use skh6075\lib\minigame\inventory\PlayerInventoryManager;
use skh6075\lib\minigame\team\MiniGameTeamManager;
use skh6075\lib\minigame\utils\MiniGameRoomTrait;

class MiniGameRoom{
	use MiniGameRoomTrait;

	public const GAMEMODE_DEFAULT = 0;

	public function __construct(
		private string $name,
		private int $minPlayerCount,
		private int $maxPlayerCount,
		private Plugin $plugin,
		private int $gamemode = self::GAMEMODE_DEFAULT,
		private array $players = [],
		private ?MiniGameTeamManager $teamManager = null
	){}

	public function onStartGame(): void{
	}

	public function onEndGame(): void{
	}

	public function unloadGameRoom(): void{
		$invManager = PlayerInventoryManager::getInstance();
		if(!mkdir("invData/") && !is_dir("invData/")){
			throw new \RuntimeException('Directory "invData/" was not created');
		}

		foreach(array_keys($this->players) as $player){
			$invData = $invManager->getInventoryData($player);
			if($invData === null){
				continue;
			}
			file_put_contents("invData/" . $this->name . "_" . strtolower($player) . ".yml", yaml_emit($invData, YAML_UTF8_ENCODING));
		}
	}
}