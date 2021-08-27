<?php

declare(strict_types=1);

namespace skh6075\lib\minigame;

use JsonException;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use skh6075\lib\minigame\inventory\PlayerInventoryManager;
use skh6075\lib\minigame\room\MiniGameRoomManager;

final class MiniGameEventHandler implements Listener{

	/**
	 * @param PlayerQuitEvent $event
	 * @priority HIGHEST
	 */
	public function onPlayerQuitEvent(PlayerQuitEvent $event): void{
		$player = $event->getPlayer();
		$roomManager = MiniGameRoomManager::getInstance();
		foreach($roomManager->getPlayerJoinedRooms($player) as $room){
			$room->removePlayer($player);
		}
	}

	/**
	 * @param PlayerJoinEvent $event
	 *
	 * @priority LOWEST
	 * @throws JsonException
	 */
	public function onPlayerJoinEvent(PlayerJoinEvent $event): void{
		$player = $event->getPlayer();
		if(is_dir("invData/")){
			$invManager = PlayerInventoryManager::getInstance();
			$files = array_diff(scandir("invData/"), ['.', '..']);
			foreach($files as $file){
				if(str_contains($file, strtolower($player->getName()))){
					$invData = yaml_parse(file_get_contents("invData/" . $file));
					unlink("invData/" . $file);
					$invManager->push($player, $invData);
					$invManager->send($player);
				}
			}
		}
	}
}