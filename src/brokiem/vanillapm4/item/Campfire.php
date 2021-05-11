<?php

declare(strict_types=1);

namespace brokiem\vanillapm4\item;

use pocketmine\item\Item;

class Campfire extends Item {

    public function getMaxStackSize(): int {
        return 1;
    }
}