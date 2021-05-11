<?php

declare(strict_types=1);

namespace brokiem\vanillapm4\item;

use pocketmine\item\ItemFactory as ItemFactoryPM;

class ItemFactory {

    public static function init(): void {
        /** @var ItemFactoryPM $i */
        $i = ItemFactoryPM::getInstance();
    }
}