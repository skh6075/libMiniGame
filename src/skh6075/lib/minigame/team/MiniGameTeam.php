<?php

declare(strict_types=1);

namespace skh6075\lib\minigame\team;

use JetBrains\PhpStorm\Pure;
use pocketmine\Player;

class MiniGameTeam{

	public function __construct(
		private string $name,
		private array $players = []
	){}

	final public function getName(): string{
		return $this->name;
	}

	final public function getPlayers(): array{
		return $this->players;
	}

	#[Pure]
	final public function isJoinedPlayer(Player $player): bool{
		return isset($this->players[strtolower($player->getName())]);
	}

	public function addPlayer(Player $player): bool{
		if(!isset($this->players[strtolower($player->getName())])){
			$this->players[strtolower($player->getName())] = time();
			return true;
		}
		return false;
	}

	public function removePlayer($player): void{
		if($player instanceof Player){
			$player = $player->getName();
		}
		if(!isset($this->players[strtolower($player)])){
			return;
		}
		unset($this->players[strtolower($player)]);
	}

	public function reset(): void{
		$this->players = [];
	}
}