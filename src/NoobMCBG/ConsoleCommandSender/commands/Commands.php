<?php

declare(strict_types=1);

namespace NoobMCBG\ConsoleCommandSender\commands;

use pocketmine\player\Player;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginOwned;
use NoobMCBG\ConsoleCommandSender\Loader;

class Commands extends Command implements PluginOwned {

	private Loader $plugin;

	public function __construct(Loader $plugin){
		$this->plugin = $plugin;
		parent::__construct("consolecommandsender", "Console Command Sender", null, ["ccs"]);
		$this->setPermission("console.control");
	}

	public function execute(CommandSender $sender, string $label, array $args){
		if(!$this->testPermission($sender)){
			return true;
		}
		if(!$sender instanceof Player){
			$sender->sendMessage("§cYou can only use this command in-game.");
			return true;
		}
		if(!isset($args[0])){
			$sender->sendMessage("§cUsage:§7 /consolecommandsender <command>");
			return true;
		}
		array_shift($args):
		$this->getOwningPlugin()->consoleCommandSender(implode(" ", $args));
		$sender->sendMessage("§aSuccessfully run command§d /".implode(" ", $args));
	}

	public function getOwningPlugin() : Loader {
		return $this->plugin;
	}
}