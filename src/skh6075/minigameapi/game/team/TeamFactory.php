<?php

namespace skh6075\minigameapi\game\team;

class TeamFactory{

    /** @var Team[] */
    private array $teams = [];


    public function __construct(Team ...$teams) {
        foreach ($teams as $team)
            $this->teams[$team->getName()] = $team;
    }

    public function getTeams(): array{
        return $this->teams;
    }

    public function getTeam(string $name): ?Team{
        return $this->teams[$name] ?? null;
    }

    public function addTeam(Team $team): bool{
        if (isset($this->teams[$team->getName()])) {
            return false;
        }
        $this->teams[$team->getName()] = $team;
        return true;
    }

    public function deleteTeam(string $name): bool{
        if (isset($this->teams[$name])) {
            unset($this->teams[$name]);
            return true;
        }
        return false;
    }
}
