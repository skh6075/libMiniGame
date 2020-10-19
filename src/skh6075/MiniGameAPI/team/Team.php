<?php


namespace skh6075\MiniGameAPI\team;

use skh6075\MiniGameAPI\MiniGameAPI;

class Team{

    /** @var string */
    private $name;
    
    /** @var array */
    private $member = [];
    
    /** @var array */
    private $scheme = [];
    
    
    public function __construct (string $name, array $member = [], array $scheme = []) {
        $this->name = $name;
        $this->member = $member;
        $this->scheme = $scheme;
    }
    
    public function getName (): string{
        return $this->name;
    }
    
    public function getMembers (): array{
        return $this->member;
    }
    
    public function resetMember (): void{
        $this->member = [];
    }
    
    /**
     * @param mixed $player
     * @return bool
     */
    public function isMember ($player): bool{
        return in_array (MiniGameAPI::convertName ($player), $this->member);
    }
    
    /**
     * @param mixed $player
     * @return bool
     */
    public function addMember ($player): bool{
        if (!$this->isMember ($player)) {
            $this->member [] = MiniGameAPI::convertName ($player);
            return true;
        }
        return false;
    }
    
    /**
     * @param string $scheme
     * @return bool
     */
    public function isScheme (string $scheme): bool{
        return isset ($this->scheme [$scheme]);
    }
    
    /**
     * @param string $scheme
     * @return mixed
     */
    public function getScheme (string $scheme) {
        return $this->scheme [$scheme];
    }
    
    /**
     * @param string $scheme
     * @param mixed $value
     */
    public function setScheme (string $scheme, $value): void{
        $this->scheme [$scheme] = $value;
    }
}
