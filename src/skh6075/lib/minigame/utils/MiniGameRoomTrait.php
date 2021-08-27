<?php

declare(strict_types=1);

namespace skh6075\lib\minigame\utils;

use pocketmine\Player;
use pocketmine\plugin\Plugin;
use skh6075\lib\minigame\team\MiniGameTeamManager;

trait MiniGameRoomTrait{

	final public function getName(): string{
		return $this->name;
	}

	final public function getMinPlayerCount(): int{
		return $this->minPlayerCount;
	}

	final public function getMaxPlayerCount(): int{
		return $this->maxPlayerCount;
	}

	final public function getPlugin(): Plugin{
		return $this->plugin;
	}

	final public function getGamemode(): int{
		return $this->gamemode;
	}

	public function setGamemode(int $gamemode): void{
		$this->gamemode = $gamemode;
	}

	final public function getJoinedPlayers(): array{
		return $this->players;
	}

	final public function isJoinedPlayer(Player $player): bool{
		return isset($this->players[strtolower($player->getName())]);
	}

	public function addPlayer(Player $player): bool{
		if($this->maxPlayerCount <= count($this->players) || $this->isJoinedPlayer($player)){
			return false;
		}
		$this->players[strtolower($player->getName())] = time();
		return true;
	}

	public function removePlayer($player): bool{
		if($player instanceof Player){
			$player = $player->getName();
		}
		if(isset($this->players[strtolower($player)])){
			unset($this->players[strtolower($player)]);
			return true;
		}
		return false;
	}

	final public function getTeamManager(): ?MiniGameTeamManager{
		return $this->teamManager;
	}
}