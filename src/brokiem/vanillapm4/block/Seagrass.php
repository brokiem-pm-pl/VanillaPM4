<?php

declare(strict_types=1);

namespace brokiem\vanillapm4\block;

use pocketmine\block\Block;
use pocketmine\block\BlockBreakInfo;
use pocketmine\block\BlockIdentifier;
use pocketmine\block\BlockToolType;
use pocketmine\block\Flowable;
use pocketmine\block\utils\HorizontalFacingTrait;
use pocketmine\block\Water;
use pocketmine\item\Item;
use pocketmine\math\Facing;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\world\BlockTransaction;

class Seagrass extends Flowable {
    use HorizontalFacingTrait;

    public function __construct(BlockIdentifier $idInfo, string $name, ?BlockBreakInfo $breakInfo = null) {
        parent::__construct($idInfo, $name, $breakInfo ?? new BlockBreakInfo(0, BlockToolType::SHEARS));
    }

    public function place(BlockTransaction $tx, Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, ?Player $player = null): bool {
        $down = $this->getSide(Facing::DOWN);
        $block = $this->pos->getWorld()->getBlock($this->pos);
        if ($down->isSolid() and $block instanceof Water and ($block->getMeta() === 0 or $block->getMeta() === 8)) {

            return parent::place($tx, $item, $blockReplace, $blockClicked, $face, $clickVector, $player);
        }

        return false;
    }

    public function onNearbyBlockChange(): void {
        $down = $this->getSide(Facing::DOWN);
        $block = $this->pos->getWorld()->getBlock($this->pos);
        if (!$down->isSolid() and !$block instanceof Water) {
            $this->pos->getWorld()->useBreakOn($this->pos);
        }
    }
}