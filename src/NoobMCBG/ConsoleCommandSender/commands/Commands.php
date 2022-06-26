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
		if(!isset($args[0])){
			$sender->sendMessage("§cUsage:§7 /consolecommandsender help");
			return true;
		}
		switch($args[0]){
			case "help":
			case "?":
				$sender->sendMessage("§6> ConsoleCommandSender display commands:\n" .
					"§b/consolecommandsender runcommand§7 - to run command in console\n" .
					"§b/consolecommandsender about§7 - see info plugin");
			break;
			case "runcommand":
			case "rca":
			case "ra":
			case "rcmd":
			case "runcmd":
				if(!$sender instanceof Player){
					$sender->sendMessage("§cYou can only use this command in-game.");
					return true;
				}
				if(!isset($args[1])){
					$sender->sendMessage("§cUsage:§7 /consolecommandsender runcommand <command>");
					return true;
				}
				array_shift($args);
				$this->getOwningPlugin()->consoleCommandSender(implode(" ", $args));
				$sender->sendMessage("§aSuccessfully run command§d /".implode(" ", $args));
			break;
			case "about":
			case "ver":
			case "version":
				$sender->sendMessage("§6Console§eCommand§bSender §av" . $this->getOwningPlugin()->getDescription()->getVersion() . "\n" . 
					"§bPlugin by:§d NoobMCBG\n" .
					"§bDiscord:§d NoobMCBG#5862");
			break;
		}
	}

	public function getOwningPlugin() : Loader {
		return $this->plugin;
	}
}