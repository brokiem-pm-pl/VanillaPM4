<?php

declare(strict_types=1);

namespace brokiem\vanillapm4;

use brokiem\vanillapm4\block\BlockFactory;
use brokiem\vanillapm4\item\ItemFactory;
use brokiem\vanillapm4\tile\TileFactory;
use pocketmine\plugin\PluginBase;

class VanillaPM4 extends PluginBase {

    protected function onEnable(): void {
        $this->getLogger()->debug("Registering VanillaPM4 blocks");
        BlockFactory::init();
        $this->getLogger()->debug("Registering VanillaPM4 items");
        ItemFactory::init();
        $this->getLogger()->debug("Registering VanillaPM4 tiles");
        TileFactory::init();
    }
}