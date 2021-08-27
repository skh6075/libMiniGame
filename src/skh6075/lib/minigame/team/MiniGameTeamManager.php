<?php

declare(strict_types=1);

namespace skh6075\lib\minigame\team;

final class MiniGameTeamManager{

	/** @var MiniGameTeam[] */
	private static array $teams = [];

	public function __construct(MiniGameTeam ...$teams){
		foreach($teams as $team){
			self::$teams[$team->getName()] = $team;
		}
	}

	public function getTeams(): array{
		return self::$teams;
	}

	public function addTeam(MiniGameTeam $team): void{
		if(isset(self::$teams[$team->getName()])){
			return;
		}
		self::$teams[$team->getName()] = $team;
	}

	public function removeTeam(MiniGameTeam $team): void{
		if(!isset(self::$teams[$team->getName()])){
			return;
		}
		unset(self::$teams[$team->getName()]);
	}
}