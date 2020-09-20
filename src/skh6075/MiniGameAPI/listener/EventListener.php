<?php


namespace skh6075\MiniGameAPI\listener;

use pocketmine\event\Listener;

use skh6075\MiniGameAPI\lang\PluginLang;
use skh6075\MiniGameAPI\event\JoinGameRoomEvent;
use skh6075\MiniGameAPI\event\QuitGameRoomEvent;

class EventListener implements Listener{


    public function handleJoinGameRoom (JoinGameRoomEvent $event): void{
        $room = $event->getGameRoom ();
        $name = $event->getName ();
        
        if ($room->getGamemode () !== 0) {
            $event->setCancelled (true);
            return;
        }
        if (count ($room->getMembers ()) >= $roon->getMaxPlayer ()) {
            $event->setCancelled (true);
            return;
        }
        $room->broadcastMessage (PluginLang::translate ("join.game.room", [
            "%name%" => $name,
            "%nowPlayer%" => count ($room->getMembers ()) + 1,
            "%maxPlayer%" => $room->getMaxPlayer ()
        ]));
    }
    
    public function handleQuitGameRoom (QuitGameRoomEvent $event): void{
        $room = $event->getGameRoom ();
        $name = $event->getName ();
        
        $room->broadcastMessage (PluginLang::translate ("qoin.game.room", [
            "%name%" => $name,
            "%nowPlayer%" => count ($room->getMembers ()) - 1,
            "%maxPlayer%" => $room->getMaxPlayer ()
        ]));
    }
}