<?php

declare(strict_types=1);

namespace brokiem\vanillapm4\block;

use pocketmine\block\BlockBreakInfo;
use pocketmine\block\BlockIdentifier;
use pocketmine\block\BlockToolType;
use pocketmine\block\Transparent;
use pocketmine\block\utils\AnyFacingTrait;

class Grindstone extends Transparent {
    use AnyFacingTrait;

    public function __construct(BlockIdentifier $idInfo, string $name, ?BlockBreakInfo $breakInfo = null) {
        parent::__construct($idInfo, $name, $breakInfo ?? new BlockBreakInfo(2, BlockToolType::PICKAXE, 0, 6));
    }

    public function getStateBitmask(): int {
        return 0b11;
    }
}