<?php

declare(strict_types=1);

namespace BenMenEs\RolePlay\command;

use BenMenEs\RolePlay\Main;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;

class DoCommand extends Command
{
	private $plugin;

	public function __construct(Main $plugin, string $command, string $description, string $permission)
	{
		$this->plugin = $plugin;

		parent::__construct($command, $description);
		$this->setPermission($permission);
	}

	public function execute(CommandSender $sender, string $label, array $args)
	{
		if(!$this->testPermission($sender)) return;

		$config = $this->plugin->config;

		if(!$sender instanceof Player) return $sender->sendMessage($config["console"]);

		if(empty($args)) return $sender->sendMessage($config["do"]["empty"]);

		if($config["do"]["radius"] != "server")
		{
			foreach($this->plugin->getServer()->getOnlinePlayers() as $player)
			{
				if($player->radius($sender) <= $config["do"]["radius"]) $player->sendMessage(str_replace(
					[
						"{player}",
						"{do}"
					], 
					[
						$sender->getName(),
						implode(" ", $args)
					],
					$config["do"]["format"]));
			}
		} else
		{
			$this->plugin->getServer()->broadcastMessage(str_replace(
				[
					"{player}",
					"{do}"
				], 
				[
					$sender->getName(),
					implode(" ", $args)
				],
				$config["do"]["format"]));
		}
	}
}