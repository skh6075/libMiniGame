<?php

namespace skh6075\minigame\inventory;

use pocketmine\item\Item;
use pocketmine\player\Player;
use pocketmine\utils\SingletonTrait;

final class PlayerInventory{
    use SingletonTrait;

    private static array $inventories = [];

    public function __construct() {
        self::setInstance($this);
    }

    public function savePlayerInventory(Player $player, bool $directClear =  false): void{
        self::$inventories[$player->getName()] = [
            array_map(function (Item $item): array{ return $item->jsonSerialize(); }, $player->getArmorInventory()->getContents()),
            array_map(function (Item $item): array{ return $item->jsonSerialize(); }, $player->getInventory()->getContents())
        ];
        if ($directClear) {
            $player->getArmorInventory()->clearAll();
            $player->getInventory()->clearAll();
        }
    }

    public function sendSavePlayerInventory(Player $player): void{
        if (!isset(self::$inventories[$player->getName()])) {
            return;
        }

        $inventory = self::$inventories[$player->getName()];
        $player->getArmorInventory()->setContents(array_map(function (array $data): Item{ return Item::jsonDeserialize($data); }, $inventory[0]));
        $player->getInventory()->setContents(array_map(function (array $data): Item{ return Item::jsonDeserialize($data); }, $inventory[1]));
        unset(self::$inventories[$player->getName()]);
    }
}