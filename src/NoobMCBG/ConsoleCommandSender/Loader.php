<?php

declare(strict_types=1);

namespace NoobMCBG\ConsoleCommandSender;

use pocketmine\plugin\PluginBase;
use pocketmine\console\ConsoleCommandSender;
use NoobMCBG\ConsoleCommandSender\commands\Commands;
use NoobMCBG\ConsoleCommandSender\task\CheckUpdateTask;

class Loader extends PluginBase {

	public static $instance;

	public static function getInstance() : self {
		return self::$instance;
	}

	public function onEnable() : void {
		$this->getServer()->getCommandMap()->register("/consolecommandsender", new Commands($this));
		$this->checkUpdate();
		self::$instance = $this;
	}

	public function checkUpdate(bool $isRetry = false) : void {
		$this->getServer()->getAsyncPool()->submitTask(new CheckUpdateTask($this->getDescription()->getName(), $this->getDescription()->getVersion()));
	}

	public function consoleCommandSender(string $command){
		$this->getServer()->getCommandMap()->dispatch(new ConsoleCommandSender($this->getServer(), $this->getServer()->getLanguage()), $command);
	}
}
