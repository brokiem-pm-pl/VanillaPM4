<?php

declare(strict_types=1);

namespace brokiem\vanillapm4\block;

use pocketmine\block\BlockBreakInfo;
use pocketmine\block\BlockIdentifier;
use pocketmine\block\BlockToolType;
use pocketmine\block\Opaque;
use pocketmine\block\utils\FacesOppositePlacingPlayerTrait;
use pocketmine\block\utils\NormalHorizontalFacingInMetadataTrait;

class Smoker extends Opaque {
    use FacesOppositePlacingPlayerTrait;
    use NormalHorizontalFacingInMetadataTrait {
        readStateFromData as readFacingStateFromData;
    }

    public function __construct(BlockIdentifier $idInfo, string $name, ?BlockBreakInfo $breakInfo = null) {
        parent::__construct($idInfo, $name, $breakInfo ?? new BlockBreakInfo(3.5, BlockToolType::AXE, 0, 17.5));
    }

    public function readStateFromData(int $id, int $stateMeta): void {
        $this->readFacingStateFromData($id, $stateMeta);
    }
}