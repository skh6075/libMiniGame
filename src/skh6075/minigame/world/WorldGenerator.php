<?php

namespace skh6075\minigame\world;

use pocketmine\entity\Living;
use pocketmine\scheduler\ClosureTask;
use pocketmine\world\World;
use skh6075\minigame\MiniGameHandler;
use ZipArchive;
use pocketmine\utils\SingletonTrait;
use pocketmine\Server;

final class WorldGenerator{
    use SingletonTrait;

    public function __construct() {
        self::setInstance($this);
    }

    public function extractWorldToDirectory(string $zipPath, string $name, bool $load = false): void{
        $zip = new ZipArchive();
        if ($zip->open($zipPath) === true)
            $zip->extractTo(Server::getInstance()->getDataPath() . "worlds/" . $name);

        $zip->close();
        if ($load)
            Server::getInstance()->getWorldManager()->loadWorld($name);
    }

    public function restoreWorld(string $zipPath, string $name): void{
        if (!($world = Server::getInstance()->getWorldManager()->getWorldByName($name)) instanceof World) {
            return;
        }

        foreach ($world->getPlayers() as $player) {
            $player->teleport(Server::getInstance()->getWorldManager()->getDefaultWorld()->getSpawnLocation());
        }

        MiniGameHandler::getRegistrant()->getScheduler()->scheduleTask(new ClosureTask(function () use ($zipPath, $world): void{
            Server::getInstance()->getWorldManager()->unloadWorld($world);
            $this->extractWorldToDirectory($zipPath, $world->getFolderName(), true);
        }));
    }
}