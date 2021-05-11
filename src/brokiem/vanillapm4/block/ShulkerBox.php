<?php

declare(strict_types=1);

namespace brokiem\vanillapm4\block;

use brokiem\vanillapm4\tile\ShulkerBox as TileShulkerBox;
use pocketmine\block\Block;
use pocketmine\block\BlockBreakInfo;
use pocketmine\block\BlockIdentifier;
use pocketmine\block\BlockLegacyIds;
use pocketmine\block\BlockToolType;
use pocketmine\block\Opaque;
use pocketmine\block\utils\ColorInMetadataTrait;
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\math\Facing;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\world\BlockTransaction;

class ShulkerBox extends Opaque {
    use ColorInMetadataTrait;

    /** @var int */
    protected $facing = Facing::NORTH;

    public function __construct(BlockIdentifier $idInfo, string $name, ?BlockBreakInfo $breakInfo = null) {
        parent::__construct($idInfo, $name, $breakInfo ?? new BlockBreakInfo(2, BlockToolType::PICKAXE));
    }

    public function writeStateToWorld(): void {
        parent::writeStateToWorld();
        $shulker = $this->pos->getWorld()->getTile($this->pos);
        if ($shulker instanceof TileShulkerBox) {
            $shulker->setFacing($this->facing);
        }
    }

    public function readStateFromWorld(): void {
        parent::readStateFromWorld();
        $shulker = $this->pos->getWorld()->getTile($this->pos);
        if ($shulker instanceof TileShulkerBox) {
            $this->facing = $shulker->getFacing();
        }
    }

    public function place(BlockTransaction $tx, Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, ?Player $player = null): bool {
        $this->facing = $face;

        return parent::place($tx, $item, $blockReplace, $blockClicked, $face, $clickVector, $player);
    }

    public function asItem(): Item {
        $item = ItemFactory::getInstance()->get($this->getId(), $this->getMeta());
        $shulker = $this->pos->getWorld()->getTile($this->pos);
        if ($shulker instanceof TileShulkerBox) {
            $item->setNamedTag($shulker->getCleanedNBT());
            if ($shulker->hasName()) {
                $item->setCustomName($shulker->getName());
            }
        }
        return $item;
    }

    public function onInteract(Item $item, int $face, Vector3 $clickVector, ?Player $player = null): bool {
        if ($player instanceof Player) {

            $shulker = $this->pos->getWorld()->getTile($this->pos);
            if ($shulker instanceof TileShulkerBox) {
                if (
                    $this->getSide($this->facing)->getId() !== BlockLegacyIds::AIR or
                    !$shulker->canOpenWith($item->getCustomName())
                ) {
                    return true;
                }

                $player->setCurrentWindow($shulker->getInventory());
            }
        }

        return true;
    }
}