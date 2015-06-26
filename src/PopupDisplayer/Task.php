<?php
namespace PopupDisplayer;


use PopupDisplayer\Main;
use pocketmine\scheduler\PluginTask;

class Task extends PluginTask {
	private $message;
	
 public function __construct(Main $plugin, $duration){
 	parent::__construct($plugin);
        $this->plugin = $plugin;
        $this->duration = $duration;
        $this->current = 0;
    }
    
    public function onRun($tick){
    	$this->plugin = $this->getOwner();
    	$message = $this->plugin->cfg->get("message");
    	$type = $this->plugin->cfg->get("type");
    	if($this->current <= $this->duration){
    		foreach($this->plugin->getServer()->getOnlinePlayers() as $players){
    			if($type == "tip"){
			$players->sendTip($message);
		}elseif($type == "popup"){
			$players->sendPopup($message);
		}
    		}
    	}else{
    		$this->plugin->getServer()->getScheduler()->cancelTask($this->getTaskId());
    	}
    	$this->current += 1;
    }
}
?>
