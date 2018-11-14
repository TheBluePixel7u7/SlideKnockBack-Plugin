<?php
namespace SlideNetwork\Managers\Events;

use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\math\Vector3;
use pocketmine\Player;
use SlideNetwork\Central;

class EventListener implements Listener{
    private $central;
    public function __construct(Central $central)
    {
        $this->central = $central;
        $this->central->getServer()->getPluginManager()->registerEvents($this, $central);
    }

    public function playerJoin(PlayerJoinEvent $event)
    {
        $player = $event->getPlayer();
        $name = $player->getName();

        // ad hehe
        if ($player->isOp()) {
            $player->sendMessage("§6Hello §b$name §6thanks for use our plugin!!!");
            $player->sendMessage("§o§3- (SlideNetwork Team)");
        }
    }

    public function doKnockbackNumbers(EntityDamageEvent $event){
        $entity = $event->getEntity();
        foreach ($this->central->getConfig()->get("world") as $world) {
            if ($entity->getLevel()->getName() === $world) {
                if ($event instanceof EntityDamageByEntityEvent) {
                    if ($this->central->getConfig()->get("custom-motion-kb") === false and $this->central->getConfig()->get("custom-number-kb") === true) {
                        $event->setKnockBack($this->central->getConfig()->get("kb-number"));
                    }
                }
            }
        }
    }
   public function doKnockbackMotion(EntityDamageEvent $event)
   {
       $entity = $event->getEntity();
       foreach ($this->central->getConfig()->get("world") as $world) {
           if ($entity->getLevel()->getName() === $world) {
               if ($event instanceof EntityDamageByEntityEvent) {
                   $damager = $event->getDamager();
                   $player = $event->getEntity();
                   if ($this->central->getConfig()->get("custom-number-kb") === false and $this->central->getConfig()->get("custom-motion-kb") === true) {
                       if ($player instanceof Player){
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
                   }
               }
           }
       }
   }


    /***
     * @param EntityDamageEvent $event
     */
    public function noDelayBug(EntityDamageEvent $event){
        if($this->central->getConfig()->get("combo-mode") === true){
            if($event instanceof EntityDamageByEntityEvent){
                $entity = $event->getEntity();
                foreach($this->central->getConfig()->get("world") as $world){
                    if($entity->getLevel()->getName() === $world){
                        $event->setCancelled(false);
                    }
                }
            }
        }
    }

}