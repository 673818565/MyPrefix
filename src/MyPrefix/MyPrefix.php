<?php
namespace MyPrefix;

use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerJoinEvent;
use onebone\economyapi\EconomyAPI;

class MyPrefix extends PluginBase implements Listener{
	
public function onEnable(){
$this->getLogger()->info('§MyPrefix Loading...');
@mkdir($this->getDataFolder());
$this->config = new Config($this->getDataFolder().'config.yml',Config::YAML,array(
"小白"=> 0,
));
$this->getServer()->getPluginManager()->registerEvents($this, $this);
$this->getLogger()->info('§MyPrefix Loaded!!!');
}

public function onJoin(PlayerJoinEvent $e){
$pn = $e->getPlayer()->getName();
$ppconf = new Config($this->getDataFolder().$pn.".yml",Config::YAML,array());
$ppconf->set("using","小白");
$ppconf->set("0","小白");
$ppconf->save(true);
}

public function onCommand(CommandSender $sender, Command $cmd, $label, array $args){

switch($cmd->getName()){
case "prefix":
if(!isset($args[0])){
$sender->sendmessage("/prefix help");
}

switch($args[0]){
case "help": 
$sender->sendMessage("/prefix buy <prefix> -Buy a prefix");
$sender->sendMessage("/prefix mylist -Look your all prefix");
$sender->sendMessage("/prefix np <prefix> <money> --(OP) create a new prefix");
$sender->sendMessage("/prefix set <prefix> -- Change your prefix");
break;
case "mylist":
$ppconf = new Config($this->getDataFolder().$sender->getName().".yml",Config::YAML,array());
foreach($ppconf->getAll() as $all =>$prefix){
$sender->sendMessage("{$all} : {$prefix}");
}
break;
case "np":
$this->config->set($args[1],$args[2]);
$this->config->save(true);
$sender->sendMessage("succeed create a new prefix {$args[1]} cost{$args[2]}");
break;
case "set":
$ppconf = new Config($this->getDataFolder().$sender->getName().".yml",Config::YAML,array());
foreach($ppconf->getAll as $all => $prefix){
if($ppconf->exists($args[1])){
$ppconf->set("using",$args[1]);
}
}
$sender->sendMessage("succeed change your prefix");
break;
}
break;
}
}

public function getPrefix($p){
$ppconf = new Config($this->getDataFolder().$pn.".yml",Config::YAML,array());
return $ppconf->get("using");
}
}
