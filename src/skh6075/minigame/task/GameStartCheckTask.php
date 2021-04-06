<?php

namespace skh6075\minigame\task;

use pocketmine\scheduler\Task;
use skh6075\minigame\MiniGameRoom;

final class GameStartCheckTask extends Task{

    private MiniGameRoom $room;

    private int $leftTime;

    public function __construct(MiniGameRoom $room, int $leftTime) {
        $this->room = $room;
        $this->leftTime = $leftTime;
    }

    public function getRoom(): MiniGameRoom{
        return $this->room;
    }

    public function getLeftTime(): int{
        return $this->leftTime;
    }

    public function onRun(): void{
        if ($this->getHandler()->isCancelled()) {
            return;
        }

        if ($this->leftTime <= 0) {
            if ($this->room->getMinPlayer() <= count($this->room->getPlayers())) {
                $this->room->onGameStart();
            }

            $this->getHandler()->cancel();
            return;
        }

        $this->leftTime --;
        foreach ($this->room->getPlayersToPlayer() as $player) {
            $player->sendActionBarMessage(implode("\n", array_map(function (string $message): string{
                return str_replace("%leftTime%", $this->leftTime, $message);
            }, $this->room->getWaitingPopupMessage())));
        }
    }
}