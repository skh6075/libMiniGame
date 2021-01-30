<?php

namespace skh6075\minigameapi\game\inventory;

use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\utils\SingletonTrait;

final class PlayerInventory{
    use SingletonTrait;

    private static array $inventories = [];


    public function __construct() {
        self::setInstance($this);
    }

    public function savePlayerInventory(Player $player, bool $directClear =  false): void{
        self::$inventories[$player->getLowerCaseName()] = [
            array_map(function (Item $item): array{ return $item->jsonSerialize(); }, $player->getArmorInventory()->getContents()),
            array_map(function (Item $item): array{ return $item->jsonSerialize(); }, $player->getInventory()->getContents())
        ];
        if ($directClear) {
            $player->getArmorInventory()->clearAll();
            $player->getInventory()->clearAll();
        }
    }

    public function sendSavePlayerInventory(Player $player): void{
        if (!isset(self::$inventories[$player->getLowerCaseName()])) {
            return;
        }
        $player->getArmorInventory()->setContents(array_map(function (array $data): Item{ return Item::jsonDeserialize($data); }, self::$inventories[$player->getLowerCaseName()][0]));
        $player->getInventory()->setContents(array_map(function (array $data): Item{ return Item::jsonDeserialize($data); }, self::$inventories[$player->getLowerCaseName()][1]));
    }
}