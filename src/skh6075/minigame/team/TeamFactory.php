<?php

namespace skh6075\minigame\team;

final class TeamFactory{

    /** @var Team[] */
    private static array $teams = [];

    public function __construct(Team ...$teams) {
        foreach ($teams as $team)
            self::$teams[$team->getName()] = $team;
    }

    public function getTeams(): array{
        return self::$teams;
    }

    public function addTeam(Team $team): void{
        self::$teams[$team->getName()] = $team;
    }
}