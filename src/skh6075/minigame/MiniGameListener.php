<?php

namespace skh6075\minigame;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerQuitEvent;

class MiniGameListener implements Listener{

    /**
     * @param PlayerQuitEvent $event
     * @priority MONITOR
     */
    public function onPlayerQuit(PlayerQuitEvent $event): void{
        if (($room = MiniGameRoomFactory::getInstance()->getPlayerJoinedGameRoom($player = $event->getPlayer())))
            $room->deleteJoinPlayer($player);
    }
}