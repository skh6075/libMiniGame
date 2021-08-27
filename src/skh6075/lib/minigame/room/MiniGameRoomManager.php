<?php

declare(strict_types=1);

namespace skh6075\lib\minigame\room;

use InvalidArgumentException;
use pocketmine\Player;
use pocketmine\utils\SingletonTrait;

final class MiniGameRoomManager{
	use SingletonTrait;

	/** @var MiniGameRoom[] */
	private static array $rooms = [];

	public function register(MiniGameRoom $room): void{
		if(isset(self::$rooms[$room->getName()])){
			throw new InvalidArgumentException("The game room named " . $room->getName() . " already exists.");
		}
		self::$rooms[$room->getName()] = $room;
	}

	public function unregister(MiniGameRoom $room): void{
		if(!isset(self::$rooms[$room->getName()])){
			return;
		}
		unset(self::$rooms[$room->getName()]);
	}

	public function get(string $name): ?MiniGameRoom{
		return self::$rooms[$name] ?? null;
	}

	public function getAll(): array{
		return self::$rooms;
	}

	/**
	 * @param Player $player
	 *
	 * @return MiniGameRoom[]
	 */
	public function getPlayerJoinedRooms(Player $player): array{
		return array_filter(array_map(static function(MiniGameRoom $room) use ($player){
			return $room->isJoinedPlayer($player) ? $room : null;
		}, self::$rooms));
	}
}