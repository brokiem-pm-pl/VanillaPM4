<?php

declare(strict_types=1);

namespace brokiem\vanillapm4\block;

use pocketmine\block\BlockBreakInfo;
use pocketmine\block\BlockIdentifier;
use pocketmine\block\BlockToolType;
use pocketmine\block\Transparent;
use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\player\Player;

class Composter extends Transparent {

    public function __construct(BlockIdentifier $idInfo, string $name, ?BlockBreakInfo $breakInfo = null) {
        parent::__construct($idInfo, $name, $breakInfo ?? new BlockBreakInfo(2, BlockToolType::AXE, 0, 3));
    }

    public function onInteract(Item $item, int $face, Vector3 $clickVector, ?Player $player = null): bool {
        /*if (
            $item->getId() === ItemIds::BEETROOT_SEEDS or
            $item->getId() === ItemIds::MELON_SEEDS or
            $item->getId() === ItemIds::SEEDS or
            $item->getId() === ItemIds::PUMPKIN_SEEDS or
            $item->getId() === ItemIds::SWEET_BERRIES or
            $item->getId() === ItemIds::SAPLING or
            $item->getId() === ItemIds::CACTUS or
            $item->getId() === ItemIds::SUGARCANE
        ){

        }*/

        return false;
    }
}