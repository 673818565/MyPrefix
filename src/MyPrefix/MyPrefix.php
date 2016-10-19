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
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\SignChangeEvent;
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
$sender->sendMessage("/prefix mylist -Look all of your prefix");
$sender->sendMessage("/prefix np <prefix> <money> --(OP) create a new prefix");
$sender->sendMessage("/prefix set <prefix> -- Change your prefix");
break;
case "mylist":
$ppconf = $this->getDataConfig($sender);
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
case "give":
if($this->getServer()->getPlayer($args[1]) == null){
$sender->sendMessage("[MyPrefix] This player is not online now");
return;
}
$sender->sendMessage("[MyPrefix] give the prefix succeed");
$this->addPrefix($this->getServer()->getPlayer($args[1]), $args[2]);
break;
case "all":
break;
}
break;
}
}

public function onSignChange(SignChangeEvent $e){
$t = $e->getLines();
$p = $e->getPlayer();
if($t[0] == "[Prefix]" OR $t[0] == "[px]") {
if($p->isOp()){
$e->setLine(0,"§f[§c§lMyPrefix§f]");
$e->setLine(1,"Cost:{$t[1]}");
$e->setLine(2,"Px:{$t[2]}");
$e->setLine(3,"Int:{$t[3]}");
$p->sendMessage("[MyPreifx] setting the sign done");
if(!$this->config->exists($t[2])){
$this-> config->set($t[2],$t[1]);
$this->config->save(true);
}else{
$p->sendMessage("[MyPreifx] U are not an op ");
$e->setLine(0, TextFormat::RED . "[§cBroken§f]");
}
}
unset($e,$p,$t);
}
}

public function onbreak(BlockBreakEvent $e){
$b = $e->getBlock();
$id = $b->getId();
if($id == 63 OR $id == 68) {
$x = $b->x;
$y = $b->y;
$z = $b->z;
$sign = $b->getLevel()->getTile(new Vector3($x,$y,$z));
if($sign->getText()[0] == "§f[§cMyPrefix§f]") {
if(!$e->getPlayer()->isOp()) $event->setCancelled();
$e->getPlayer()->sendMessage("Remove the sign succeed ");
}
}
}

public function onInteract(PlayerInteractEvent $e){
$b = $e->getBlock();
$id = $b->getId();
$p = $e->getPlayer();
if($id == 63 OR $id == 68 OR $id == 323) {
$x = $b->x;
$y = $b->y;
$z = $b->z;
$sign = $b->getLevel()->getTile(new Vector3($x,$y,$z));
if($sign->getText()[0] == "§f[§cMyPrefix§f]") {
if($this->hasPrefix($p, explode(":",$sign->getText()[2])[1])){
$this->addPrefix($p, explode(":",$sign->getText()[2])[1]);
$p->sendMessage("[MyPrefix]Bought the prefix succeed");
}else{
$p->sendMessage("[MyPrefix] You had bought it before");
}
}
}
}

public function getPrefix($p){
$ppconf = $this->getDataConfig($p);
return $ppconf->get("using");
}

public function hasPrefix($p, $prefix){
$ppconf = $this->getDataConfig($p);
if($ppconf->exists($prefix)) return true; return false;
}

public function addPrefix($p, $prefix){
$ppconf = $this->getDataConfig($p);
$ppconf->set($prefix,data("Y/m/d"));
$ppconf->save(true);
}

public function getDataConfig($p){
$pn = $p->getName();
$ppconf = new Config($this->getDataFolder().$pn.".yml",Config::YAML,array());
return $ppconf;
}

}
