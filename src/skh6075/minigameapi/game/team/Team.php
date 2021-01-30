<?php

namespace skh6075\minigameapi\game\team;

use function skh6075\minigameapi\convertName;

class Team{

    private string $name;

    private array $member = [];

    private array $scheme = [];


    public function __construct(string $name, array $member, array $scheme) {
        $this->name = $name;
        $this->member = $member;
        $this->scheme = $scheme;
    }

    public function getName(): string{
        return $this->name;
    }

    public function getMembers(): array{
        return $this->member;
    }

    public function isMember($player): bool{
        return in_array(convertName($player), $this->member);
    }

    public function addMember($player): bool{
        if (!$this->isMember($player)) {
            $this->member[] = convertName($player);
            return true;
        }
        return false;
    }

    public function deleteMember($player): bool{
        if ($this->isMember($player)) {
            unset($this->member[array_search(convertName($player), $this->member)]);
            return true;
        }
        return false;
    }

    public function resetMember(): void{
        $this->member = [];
    }

    public function ischeme(string $scheme): bool{
        return isset($this->scheme[$scheme]);
    }

    public function getSchemeValue(string $scheme, $default) {
        return $this->scheme[$scheme] ?? $default;
    }

    public function setSchemeValue(string $scheme, $value) {
        $this->scheme[$scheme] = $value;
    }
}