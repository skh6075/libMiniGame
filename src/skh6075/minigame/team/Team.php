<?php

namespace skh6075\minigame\team;

use pocketmine\player\Player;

class Team{

    private string $name;

    /** @var string[] */
    private array $players = [];

    public function __construct(string $name) {
        $this->name = $name;
    }

    final public function getName(): string{
        return $this->name;
    }

    final public function getPlayers(): array{
        return $this->players;
    }

    final public function isExistsPlayer(string $name): bool{
        return array_search($name, $this->players) !== false;
    }

    public function addPlayer(Player $player): bool{
        if (!$this->isExistsPlayer($player->getName())) {
            $this->players[] = $player->getName();
            return true;
        }

        return false;
    }

    public function deletePlayer(string $name): bool{
        if ($this->isExistsPlayer($name)) {
            unset($this->players[array_search($name, $this->players)]);
            return true;
        }

        return false;
    }

    public function setPlayers(array $players): void{
        $this->players = $players;
    }
}