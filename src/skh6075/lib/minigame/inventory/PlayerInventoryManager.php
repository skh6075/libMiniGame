<?php

declare(strict_types=1);

namespace skh6075\lib\minigame\inventory;

use JetBrains\PhpStorm\Pure;
use JsonException;
use pocketmine\Player;
use pocketmine\utils\SingletonTrait;

final class PlayerInventoryManager{
	use SingletonTrait;

	public const PLAYER_INVENTORY = 0;
	public const CURSOR_INVENTORY = 1;
	public const ARMOR_INVENTORY = 2;

	private array $inventories = [];

	/**
	 * @throws JsonException
	 */
	public function send(Player $player): bool{
		if(!isset($this->inventories[strtolower($player->getName())])){
			return false;
		}
		$invData = $this->inventories[strtolower($player->getName())];
		for($sync = self::PLAYER_INVENTORY; $sync <= self::ARMOR_INVENTORY; $sync++){
			$method = $this->syncToMethod($sync);
			if($method === "" || !method_exists(Player::class, $method)){
				continue;
			}
			$player->{$method . "()"}->setContents(json_decode($invData[$sync], true, 512, JSON_THROW_ON_ERROR));
		}
		unset($this->inventories[strtolower($player->getName())]);
		return true;
	}

	public function push(Player $player, array $data): void{
		$this->inventories[strtolower($player->getName())] = $data;
	}

	private function syncToMethod(int $sync = self::PLAYER_INVENTORY): string{
		return match ($sync){
			self::PLAYER_INVENTORY => "getInventory",
			self::CURSOR_INVENTORY => "getCursorInventory",
			self::ARMOR_INVENTORY => "getArmorInventory",
			default => ""
		};
	}

	/**
	 * @throws JsonException
	 */
	public function save(Player $player): void{
		$invData = [];
		$invData[self::PLAYER_INVENTORY] = json_encode($player->getInventory()->getContents(true), JSON_THROW_ON_ERROR);
		$invData[self::CURSOR_INVENTORY] = json_encode($player->getCursorInventory()->getContents(true), JSON_THROW_ON_ERROR);
		$invData[self::ARMOR_INVENTORY] = json_encode($player->getArmorInventory()->getContents(true), JSON_THROW_ON_ERROR);

		$this->inventories[strtolower($player->getName())] = $invData;
	}

	#[Pure]
	public function getInventoryData($player): ?array{
		if($player instanceof Player){
			$player = $player->getName();
		}
		return $this->inventories[strtolower($player)] ?? null;
	}
}
