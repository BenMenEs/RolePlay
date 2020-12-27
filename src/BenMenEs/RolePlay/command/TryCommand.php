<?php

declare(strict_types=1);

namespace BenMenEs\RolePlay\command;

use BenMenEs\RolePlay\Main;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;

class TryCommand extends Command
{
	private $plugin;

	public function __construct(Main $plugin, string $name, string $description, string $permission)
	{
		$this->plugin = $plugin;

		parent::__construct($name, $description);
		$this->setPermission($permission);
	}

	public function execute(CommandSender $sender, string $label, array $args)
	{
		if(!$this->testPermission($sender)) return;

		$config = $this->plugin->config;

		if(!$sender instanceof Player) return $sender->sendMessage($config["console"]);

		if(empty($args)) return $sender->sendMessage($config["try"]["empty"]);

		$failed = false;

		if(mt_rand(0, 100) <= $config["try"]["chance"])
		{
		} else
		{
			$failed = true;
		}

		if($config["try"]["radius"] != "server")
		{
			foreach($this->plugin->getServer()->getOnlinePlayers() as $player)
			{
				if($player->radius($sender) <= $config["try"]["radius"])
				{
					if(!$failed)
					{
						$player->sendMessage(str_replace(["{player}", "{try}"], [$sender->getName(), implode(" ", $args)], $config["try"]["success"]));
					} else
					{
						$player->sendMessage(str_replace(["{player}", "{try}"], [$sender->getName(), implode(" ", $args)], $config["try"]["failed"]));
					}
				}
			}
		} else
		{
			if(!$failed)
			{
				$this->plugin->getServer()->broadcastMessage(str_replace(["{player}", "{try}"], [$sender->getName(), implode(" ", $args)], $config["try"]["success"]));
			} else
			{
				$this->plugin->getServer()->broadcastMessage(str_replace(["{player}", "{try}"], [$sender->getName(), implode(" ", $args)], $config["try"]["failed"]));
			}
		}
	}
}