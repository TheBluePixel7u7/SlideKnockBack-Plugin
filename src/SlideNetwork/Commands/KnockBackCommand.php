<?php
namespace SlideNetwork\Commands;


use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\level\Position;
use pocketmine\Player;
use SlideNetwork\Central;

class KnockBackCommand extends PluginCommand{
    private $central;
    public function __construct(Central $central)
    {
        parent::__construct("/slidekb", $central);
        $this->central = $central;
        $this->setDescription("Main command");
        $this->setAliases(["kb", "knockback", "skb", "slidekb"]);
        $this->setPermission("admin");
    }

    public function execute(CommandSender $sender, $commandLabel, array $args){
        if($sender->isOp() || $sender->hasPermission("admin")) {
            if (isset($args[0])) {
                switch ($args[0]){
                    case "test":
                        if($sender instanceof Player){
                            if(!$this->central->getServer()->isLevelLoaded("lobby")){
                                $this->central->getServer()->loadLevel("lobby");
                                $sender->sendMessage("Try again!");
                            }else{
                                $sender->teleport($this->central->getServer()->getLevelByName("lobby")->getSafeSpawn());
                            }
                        }
                        break;
                    /*
                     * Help
                     */
                    case "help":
                        //TODO: Better help system xd
                        $sender->sendMessage("§7   ---   §8[§3Slide§4Network§8]   §7---   ");
                        $sender->sendMessage("                                            ");
                        $sender->sendMessage('§9/slidekb (set) (amount)§f - Set amount of kb (just for numeric kb, no motion.)');
                        $sender->sendMessage('§9/slidekb (type) (choose type) §f- Choose a default kb (Slide custom KBs.)');
                        $sender->sendMessage('§9/slidekb (type) (list) §f- View the list of all custom kbs');
                        $sender->sendMessage("                                            ");
                        $sender->sendMessage("§6[Aliases] §b- {skb}, {knockback}, {kb}.");
                        break;
                        /*
                         * Configuration
                         */
                    case "set":
                        break;
                        /*
                         * Our custom knockback numbers for all :)
                         */
                    case "type":
                        if(isset($args[1])){
                            switch ($args[1]){
                                case "table":
                                case "list":
                                case "help":
                                    //TODO: default kbs list
                                    break;
                                case "a":
                                    //TODO: add new system of very different default kbs.
                            }
                        }
                        break;
                    default:
                        $sender->sendMessage("Invalid command, use /slidekb help");
                        break;
                }
            } else {
                $sender->sendMessage("/kb help");
            }
        }else{
            $sender->sendMessage("no");
        }
    }

}