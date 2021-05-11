<?php

declare(strict_types=1);

namespace brokiem\vanillapm4\block;

use pocketmine\block\BlockBreakInfo;
use pocketmine\block\BlockIdentifier;
use pocketmine\block\BlockToolType;
use pocketmine\block\Transparent;
use pocketmine\block\utils\HorizontalFacingTrait;
use pocketmine\item\Item;
use pocketmine\item\VanillaItems;
use pocketmine\math\AxisAlignedBB;
use pocketmine\math\Facing;
use pocketmine\math\Vector3;
use pocketmine\player\Player;

//TODO: Tile for cook food
class Campfire extends Transparent {
    use HorizontalFacingTrait;

    protected bool $lit = false;

    public function __construct(BlockIdentifier $idInfo, string $name, ?BlockBreakInfo $breakInfo = null) {
        parent::__construct($idInfo, $name, $breakInfo ?? new BlockBreakInfo(2, BlockToolType::AXE, 0, 2));
    }

    public function getDrops(Item $item): array {
        return [VanillaItems::COAL()->setCount(mt_rand(1, 2))];
    }

    public function readStateFromData(int $id, int $stateMeta): void {
        $this->setLit((bool)($stateMeta >> 2));
        $this->readStateFromData($id, $stateMeta);
    }

    public function getStateBitmask(): int {
        return 0b111;
    }

    public function onInteract(Item $item, int $face, Vector3 $clickVector, ?Player $player = null): bool {
        if ($face === Facing::UP) {
            $block = clone $this;
            $block->setLit(!$block->isLit());
            $this->pos->getWorld()->setBlock($this->pos, $block);

            return true;
        }
        return false;
    }

    protected function writeStateToMeta(): int {
        return $this->isLit() << 2 | $this->writeStateToMeta();
    }

    public function isLit(): bool {
        return $this->lit;
    }

    public function setLit(bool $lit): self {
        $this->lit = $lit;
        return $this;
    }

    /** @return AxisAlignedBB[] */
    protected function recalculateCollisionBoxes(): array {
        return [AxisAlignedBB::one()->trim(Facing::UP, 0.5)];
    }
}