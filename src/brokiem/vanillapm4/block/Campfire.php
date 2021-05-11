<?php

declare(strict_types=1);

namespace brokiem\vanillapm4\block;

use pocketmine\block\Block;
use pocketmine\block\BlockBreakInfo;
use pocketmine\block\BlockIdentifier;
use pocketmine\block\BlockToolType;
use pocketmine\block\Transparent;
use pocketmine\block\utils\HorizontalFacingTrait;
use pocketmine\entity\Entity;
use pocketmine\entity\Living;
use pocketmine\event\entity\EntityDamageByBlockEvent;
use pocketmine\item\Item;
use pocketmine\item\VanillaItems;
use pocketmine\math\AxisAlignedBB;
use pocketmine\math\Facing;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\world\BlockTransaction;

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

    public function place(BlockTransaction $tx, Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, ?Player $player = null): bool {
        if ($face === Facing::UP) {
            $this->setLit(!$this->isLit());
            return parent::place($tx, $item, $blockReplace, $blockClicked, $face, $clickVector, $player);
        }

        return false;
    }

    public function hasEntityCollision(): bool {
        return true;
    }

    public function onEntityInside(Entity $entity): bool {
        if ($entity instanceof Living) {
            $ev = new EntityDamageByBlockEvent($this, $entity, EntityDamageByBlockEvent::CAUSE_CONTACT, 1);
            $entity->attack($ev);
            return true;
        }

        return false;
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