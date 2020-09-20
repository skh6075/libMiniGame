<?php


namespace skh6075\MiniGameAPI\team;



class TeamFactory{

    /** @var Team[] */
    private $team = [];
    
    
    public function __construct (Team ...$teams) {
        foreach ($teams as $team) {
            $this->team [$team->getName ()] = $team;
        }
    }
    
    /**
     * @param string $tean
     * @return Team|null
     */
    public function getTeam (string $team): ?Team{
        return $this->team [$team] ?? null;
    }
    
    /**
     * @param Team $team
     * @return bool
     */
    public function addTeam (Team $team): bool{
        if (!isset ($this->team [$team->getName ()])) {
            $this->team [$team->getName ()] = $team;
            return true;
        }
        return false;
    }
    
    /**
     * @param string $team
     * @return bool
     */
    public function deleteTeam (string $team): bool{
        if (isset ($this->team [$team])) {
            unset ($this->team [$team]);
            return true;
        }
        return false;
    }
}