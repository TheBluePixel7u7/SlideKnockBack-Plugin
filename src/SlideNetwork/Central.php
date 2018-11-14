<?php
namespace SlideNetwork;
use pocketmine\plugin\PluginBase;

use SlideNetwork\Commands\KnockBackCommand;
use SlideNetwork\Managers\Events\EventListener;
use SlideNetwork\Managers\SlideManager;
class Central extends PluginBase{
    private $slideManager;

    public function onEnable()
    {
        $this->load();
        $this->saveDefaultConfig();
        $this->getServer()->getCommandMap()->register("/slidekb", new KnockBackCommand($this));
        $this->getLogger()->notice("Successfully enabled.");
        if(!$this->getServer()->getPluginManager()->getPlugin("SlideKnockBack")){
            echo "
            
            --------------------------------------
            Don´t remove the original plugin name.
            --------------------------------------
            
            ";
            $this->getServer()->shutdown();
        }else{
            if($this->getConfig()->get("custom-number-kb") === true and $this->getConfig()->get("custom-motion-kb") === true){
                $this->getServer()->getPluginManager()->disablePlugin($this->getServer()->getPluginManager()->getPlugin("SlideKnockBack"));
                echo "Error: Disable custom-number-kb or custom-motion-kb";
            }
        }
    }

    /***
     * @return SlideManager
     */
    public function getSlideManager(){
        return $this->slideManager;
    }

    public function load(){
        $this->slideManager = new SlideManager();
        new EventListener($this);
    }
}