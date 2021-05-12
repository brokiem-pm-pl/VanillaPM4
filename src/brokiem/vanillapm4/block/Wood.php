<?php

declare(strict_types=1);

namespace brokiem\vanillapm4\block;

use brokiem\vanillapm4\VanillaPM4;
use pocketmine\block\Wood as WoodPM;
use pocketmine\item\Axe;
use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\player\Player;

class Wood extends WoodPM {

    public function onInteract(Item $item, int $face, Vector3 $clickVector, ?Player $player = null): bool {
        if (!$this->isStripped() and $item instanceof Axe) {
            $item->applyDamage(2);
            $this->pos->getWorld()->setBlock($this->pos, VanillaPM4::getStrippedLogBlock($this->getTreeType()));
            return true;
        }
        return false;
    }
}