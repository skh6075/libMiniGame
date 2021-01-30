<?php

namespace skh6075\minigameapi\world;

use pocketmine\level\Level;
use pocketmine\scheduler\ClosureTask;
use pocketmine\Server;
use pocketmine\utils\SingletonTrait;
use skh6075\minigameapi\MiniGameAPI;
use ZipArchive;

final class WorldGenerator{
    use SingletonTrait;


    public function __construct() {
        self::setInstance($this);
    }

    public function extractWorldToDirectory(string $zipPath, string $name, bool $load = false): void{
        $zip = new ZipArchive();
        if ($zip->open($zipPath) === true) $zip->extractTo(Server::getInstance()->getDataPath() . "worlds/" . $name);
        $zip->close();

        if ($load)
            Server::getInstance()->loadLevel($name);
    }

    public function restoreWorld(string $zipPath, string $name): void{
        MiniGameAPI::getInstance()->getScheduler()->scheduleDelayedTask(new ClosureTask(function () use ($zipPath, $name): void{
            if (($level = Server::getInstance()->getLevelByName($name)) instanceof Level) {
                foreach ($level->getPlayers() as $player) {
                    $player->teleport(Server::getInstance()->getDefaultLevel()->getSafeSpawn());
                }
                Server::getInstance()->unloadLevel($level);
                $this->extractWorldToDirectory($zipPath, $name, true);
            }
        }), 20 * 3);
    }
}