<?php

declare(strict_types=1);

namespace brokiem\vanillapm4\block;

use brokiem\vanillapm4\sound\SweetBerryBushPickSound;
use pocketmine\block\Block;
use pocketmine\block\BlockBreakInfo;
use pocketmine\block\BlockLegacyIds;
use pocketmine\block\Crops;
use pocketmine\entity\Entity;
use pocketmine\entity\Living;
use pocketmine\event\block\BlockGrowEvent;
use pocketmine\event\entity\EntityDamageByBlockEvent;
use pocketmine\item\Fertilizer;
use pocketmine\item\Item;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\ItemIds;
use pocketmine\math\Facing;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\world\BlockTransaction;

class SweetBerryBush extends Crops {

    public function place(BlockTransaction $tx, Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, ?Player $player = null): bool {
        if (
            $blockReplace->getSide(Facing::DOWN)->getId() === BlockLegacyIds::GRASS or
            $blockReplace->getSide(Facing::DOWN)->getId() === BlockLegacyIds::DIRT or
            $blockReplace->getSide(Facing::DOWN)->getId() === BlockLegacyIds::PODZOL
        ) {
            return Block::place($tx, $item, $blockReplace, $blockClicked, $face, $clickVector, $player);
        }

        return false;
    }

    public function onInteract(Item $item, int $face, Vector3 $clickVector, ?Player $player = null): bool {
        if ($item instanceof Fertilizer) {
            $block = clone $this;
            $block->age++;
            if ($block->age > 7) {
                $block->age = 7;
            }

            $ev = new BlockGrowEvent($this, $block);
            $ev->call();

            if (!$ev->isCancelled()) {
                $newBlock = $ev->getNewState();
                if ($newBlock instanceof SweetBerryBush) {
                    if ($newBlock->getAge() >= 4) {
                        $newBlock->setAge(1);
                        $this->pos->getWorld()->dropItem($this->pos, (new Item(new ItemIdentifier(ItemIds::SWEET_BERRIES, 0), "SweetBerries"))->setCount(mt_rand(2, 3)));
                        $this->pos->getWorld()->addSound($this->pos, new SweetBerryBushPickSound());
                    }
                }

                $this->pos->getWorld()->setBlock($this->pos, $ev->getNewState());
            }

            $item->pop();
        } elseif ($this->age >= 2) {
            $this->age = 1;
            $this->pos->getWorld()->setBlock($this->pos, $this);
            $this->pos->getWorld()->dropItem($this->pos, (new Item(new ItemIdentifier(ItemIds::SWEET_BERRIES, 0), "SweetBerries"))->setCount($this->age === 3 ? mt_rand(2, 3) : mt_rand(1, 2)));
            $this->pos->getWorld()->addSound($this->pos, new SweetBerryBushPickSound());
        }

        return true;
    }

    public function setAge(int $age): Crops {
        $this->breakInfo = $this->age < 1 ? BlockBreakInfo::instant() : new BlockBreakInfo(0.25);

        return parent::setAge($age);
    }

    public function hasEntityCollision(): bool {
        return $this->age > 0;
    }

    public function onEntityInside(Entity $entity): bool {
        if ($entity instanceof Living/* and $entity->hasMovementUpdate()*/) {
            if ($this->age > 0) {
                $entity->resetFallDistance();

                $ev = new EntityDamageByBlockEvent($this, $entity, EntityDamageByBlockEvent::CAUSE_CONTACT, 1);
                $entity->attack($ev);

                // TODO: I think the ``$entity-> hasMovementUpdate()'' is broken because it doesn't detect the player if it moves
                //$this->pos->getWorld()->addSound($this->pos, new SweetBerryBushHurtSound());
            }
            return true;
        }

        return false;
    }

    public function getDropsForCompatibleTool(Item $item): array {

        if ($this->age >= 2) {
            return [
                (new Item(new ItemIdentifier(ItemIds::SWEET_BERRIES, 0), "SweetBerries"))->setCount($this->age === 3 ? mt_rand(2, 3) : mt_rand(1, 2))
            ];
        }

        return [];
    }

    public function getPickedItem(bool $addUserData = false): Item {
        return (new Item(new ItemIdentifier(ItemIds::SWEET_BERRIES, 0), "SweetBerries"));
    }

    public function onNearbyBlockChange(): void {
        $side = $this->getSide(Facing::DOWN);
        $supportedIds = [BlockLegacyIds::GRASS, BlockLegacyIds::DIRT, BlockLegacyIds::PODZOL];
        if (!in_array($side->getId(), $supportedIds, true)) {
            $this->pos->getWorld()->useBreakOn($this->pos);
        }
    }
}