<?php

declare(strict_types=1);

namespace BenMenEs\RolePlay;

use BenMenEs\RolePlay\command\TryCommand;
use BenMenEs\RolePlay\command\DoCommand;

use pocketmine\plugin\PluginBase;

class Main extends PluginBase
{
	public $config = [];

	public function onLoad() : void
	{
		$commands = 
		[
			new TryCommand($this, "try", "Try to do something", "try.cmd"),
			new DoCommand($this, "do", "Do something", "do.cmd")
		];

		foreach($commands as $command)
			$this->getServer()->getCommandMap()->register("RolePlay", $command);
	}

	public function onEnable() : void
	{
		$this->saveDefaultConfig();
		$this->config = $this->getConfig()->getAll();

		$this->getLogger()->info("My GitHub: github.com/BenMenEs");
	}
}