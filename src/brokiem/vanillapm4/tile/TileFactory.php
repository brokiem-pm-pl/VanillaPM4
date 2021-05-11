<?php

declare(strict_types=1);

namespace brokiem\vanillapm4\tile;

use brokiem\vanillapm4\tile\ShulkerBox as TileShulkerBox;
use pocketmine\block\tile\TileFactory as TileFactoryPM;

class TileFactory {

    public static function init(): void {
        /** @var TileFactoryPM $i */
        $i = TileFactoryPM::getInstance();

        $i->register(TileShulkerBox::class, ["ShulkerBox", "minecraft:shulker_box"]);
    }
}