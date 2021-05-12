<?php

declare(strict_types=1);

namespace brokiem\vanillapm4\item;

use pocketmine\block\Block;
use pocketmine\block\BlockBreakInfo;
use pocketmine\block\BlockIdentifier;
use pocketmine\block\BlockLegacyIds;
use pocketmine\item\Food;

class SweetBerries extends Food {

    public function getFoodRestore(): int {
        return 2;
    }

    public function getSaturationRestore(): float {
        return 1.2;
    }

    public function getBlock(?int $clickedFace = null): Block {
        return new Block(new BlockIdentifier(BlockLegacyIds::SWEET_BERRY_BUSH, 0), "SweetBerryBush", BlockBreakInfo::instant());
    }
}