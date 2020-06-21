<?php

namespace chaca142;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\utils\Config;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;

use onebone\economyapi\EconomyAPI;
use metowa1227\moneysystem\api\core\API;
use MixCoinSystem\MixCoinSystem;
use MoneyPlugin\MoneyPlugin;
use hayao\main;

class GaTAPM extends PluginBase implements Listener{

    public function onEnable(){
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getLogger()->info("§aGaTAPMが読み込まれました");

        if(!file_exists($this->getDataFolder())){
            mkdir($this->getDataFolder(), 0744, true);
        }
        $this->set = new Config($this->getDataFolder() . "config.yml", Config::YAML, array(
            "Plugin" => "EconomyAPI"
            ##必ず /reload をしてください
        ));
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args):bool{
       if (!$sender->isOp()) {
           $sender->sendMessage("§c権限がありません");
           return false;
       }else{
           switch ($command->getName()) {
               case "gapm":
                   if (!isset($args[0])){
                       $sender->sendMessage("§cお金の数が設定されていません /gapm <お金の数>");
                       return false;
                   }else{
                       if(!$this->getServer()->getOnlinePlayers()) return false;
                       foreach($this->getServer()->getOnlinePlayers() as $player);
                       $mp = $this->set->get("Plugin");

                       if ($mp == "EconomyAPI"){
                           EconomyAPI::getInstance()->addMoney($player, $args[0]);
                           $this->getServer()->broadcastMessage("§aオンライン中の全プレイヤーに＄".$args[0]."を配りました");
                           return false;
                       }

                       if ($mp == "MixCoinSystem"){
                           MixCoinSystem::getInstance()->PlusCoin($player, $args[0]);
                           $this->getServer()->broadcastMessage("§aオンライン中の全プレイヤーに＄".$args[0]."を配りました");
                           return false;
                       }

                       if ($mp == "MoneySystem"){
                           API::getInstance()->increase($player, $args[0]);
                           $this->getServer()->broadcastMessage("§aオンライン中の全プレイヤーに＄".$args[0]."を配りました");
                           return false;
                       }
                   }
                   return false;
               case "tapm":
                   if (!isset($args[0])){
                       $sender->sendMessage("§cお金の数が設定されていません /tapm <お金の数>");
                       return false;
                   }else{
                       if (!$this->getServer()->getOnlinePlayers()) return false;
                       foreach($this->getServer()->getOnlinePlayers() as $player2)
                       $mp = $this->set->get("Plugin");

                       if ($mp == "EconomyAPI"){
                           EconomyAPI::getInstance()->reduceMoney($player2, $args[0]);
                           $this->getServer()->broadcastMessage("§aオンライン中の全プレイヤーから＄".$args[0]."減らしました");
                           return false;
                       }

                       if ($mp == "MixCoinSystem"){
                           MixCoinSystem::getInstance()->MinusCoin($player2, $args[0]);
                           $this->getServer()->broadcastMessage("§aオンライン中の全プレイヤーから＄".$args[0]."減らしました");
                           return false;
                       }

                       if ($mp == "MoneySystem"){
                           API::getInstance()->reduce($player2, $args[0]);
                           $this->getServer()->broadcastMessage("§aオンライン中の全プレイヤーから＄".$args[0]."減らしました");
                           return false;
                       }
                   }
           }
       }
     return false;
    }

}