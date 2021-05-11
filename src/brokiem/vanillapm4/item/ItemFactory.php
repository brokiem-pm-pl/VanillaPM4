<?php

declare(strict_types=1);

namespace brokiem\vanillapm4\item;

use pocketmine\item\ItemFactory as ItemFactoryPM;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\ItemIds;

class ItemFactory {

    public static function init(): void {
        /** @var ItemFactoryPM $i */
        $i = ItemFactoryPM::getInstance();

        $i->register(new Campfire(new ItemIdentifier(ItemIds::CAMPFIRE, 0), "Campfire"));
    }
}