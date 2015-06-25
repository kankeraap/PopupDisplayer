<?php
namespace PopupDisplayer;


use PopupDisplayer\Main;
use pocketmine\scheduler\PluginTask;

class Task extends PluginTask {
	private $message;
	
 public function __construct(Main $plugin, $message, $duration){
 	parent::__construct($plugin);
        $this->plugin = $plugin;
        $this->message = $message;
        $this->duration = $duration;
        $this->current = 0;
    }
    
    public function onRun($tick){
    	$this->plugin = $this->getOwner();
    	$message = $this->plugin->cfg->get("message");
    	if($this->current <= $this->duration){
    		foreach($this->plugin->getServer()->getOnlinePlayers() as $players){
    			$players->sendPopup($this->plugin->translateColors("&", $this->message));
    		}
    	}else{
    		$this->plugin->getServer()->getScheduler()->cancelTask($this->getTaskId());
    	}
    	$this->current += 1;
    }
}
?>
