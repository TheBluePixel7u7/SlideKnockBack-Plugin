<?php
namespace SlideNetwork\Managers;

use pocketmine\Player;

class SlideManager
{
    private $session = [];

    public function calculateKnockBack(Player $player, Player $damager){
            if ($damager->getDirection() == 0) {
                $player->knockBack($player, 0, 0.1, 0.1, 0);
            } elseif ($damager->getDirection() == 1) {
                $player->knockBack($player, 0, 0.1, 0.1, 0);
            } elseif ($damager->getDirection() == 2) {
                $player->knockBack($player, 0, -0.1, 0.1, 0);
            } elseif ($damager->getDirection() == 3) {
                $player->knockBack($player, 0, 0.1, -0.1, 0);
            }
    }

    public function isSession(Player $player){
        if(isset($this->session[$player->getName()])){
            return $player;
        }else{
            echo "fatal error";
        }
        return $player;
    }

    public function addSession(Player $player){
        if(!isset($this->session[$player->getName()])){
            $this->session[$player->getName()] = $player;
        }else{
            $this->removeSession($player);
            $player->sendMessage("Don't do that again!"); // i think this fix some bugs lol
        }
    }

    public function removeSession(Player $player){
        if(isset($this->session[$player->getName()])){
            unset($this->session[$player->getName()]);
        }
    }

    public function getAllSessions(){
        return $this->session;
    }

    public function getAllSessionsCount(){
        return count($this->session);
    }
}