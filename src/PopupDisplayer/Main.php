<?php
namespace PopupDisplayer;

use pocketmine\Player;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;
use pocketmine\Server;
use pocketmine\plugin\PluginManager;
use pocketmine\plugin\Plugin;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener{

	public $cfg;
	
	public function onLoad(){
		$this->getLogger()->info("Plugin Enabled");  //getLogger() mostra il messaggio dopo info nella console di PM
	}
	
	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		@mkdir($this->getDataFolder()); //crea la cartella dove sara il config.yml
		$this->saveDefaultConfig(); //salva la configurazione di default del config.yml
		$this->cfg = $this->getConfig(); //prende le informazioni dal config.yml
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->getServer()->getScheduler()->scheduleRepeatingTask(new Task($this, $this->cfg->get("duration"), 10));
	}	
	
	public function onPlayerJoin(PlayerJoinEvent  $event){
		$type = $this->cfg->get("type");
		$message = $this->cfg->get("message");
		if($type == "tip"){
			$event->getPlayer()->sendTip($message);
		}elseif($type == "popup"){
			$event->getPlayer()->sendPopup($message);
		}
	}

public function onDisable(){
		$this->saveDefaultConfig();
		$this->getLogger()->info("Plugin Disabled");
	}
}

?>
