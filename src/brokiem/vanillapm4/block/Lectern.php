<?php

declare(strict_types=1);

namespace brokiem\vanillapm4\block;

use pocketmine\block\BlockBreakInfo;
use pocketmine\block\BlockIdentifier;
use pocketmine\block\BlockToolType;
use pocketmine\block\Transparent;
use pocketmine\block\utils\BlockDataSerializer;
use pocketmine\block\utils\FacesOppositePlacingPlayerTrait;
use pocketmine\block\utils\HorizontalFacingTrait;

// For Decoration no tile or inventory
class Lectern extends Transparent {
    use FacesOppositePlacingPlayerTrait;
    use HorizontalFacingTrait;

    public function __construct(BlockIdentifier $idInfo, string $name, ?BlockBreakInfo $breakInfo = null) {
        parent::__construct($idInfo, $name, $breakInfo ?? new BlockBreakInfo(2.5, BlockToolType::AXE, 0, 2.5));
    }

    public function readStateFromData(int $id, int $stateMeta): void {
        $this->facing = BlockDataSerializer::readLegacyHorizontalFacing($stateMeta & 0x3);
    }

    public function getStateBitmask(): int {
        return 0b11;
    }

    protected function writeStateToMeta(): int {
        return BlockDataSerializer::writeLegacyHorizontalFacing($this->facing);
    }
}