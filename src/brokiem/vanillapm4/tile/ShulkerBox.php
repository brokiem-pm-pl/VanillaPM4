<?php

declare(strict_types=1);

namespace brokiem\vanillapm4\tile;

use brokiem\vanillapm4\block\inventory\ShulkerBoxInventory;
use pocketmine\block\tile\Container;
use pocketmine\block\tile\ContainerTrait;
use pocketmine\block\tile\Nameable;
use pocketmine\block\tile\NameableTrait;
use pocketmine\block\tile\Spawnable;
use pocketmine\item\Item;
use pocketmine\math\Facing;
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\world\World;

class ShulkerBox extends Spawnable implements Container, Nameable {
    use NameableTrait {
        addAdditionalSpawnData as addNameSpawnData;
    }
    use ContainerTrait;

    public const TAG_FACING = "facing";

    /** @var int */
    protected int $facing = Facing::NORTH;

    protected ?ShulkerBoxInventory $inventory;

    public function __construct(World $world, Vector3 $pos) {
        parent::__construct($world, $pos);
        $this->inventory = new ShulkerBoxInventory($this->pos);
    }

    public function copyDataFromItem(Item $item): void {
        $this->readSaveData($item->getNamedTag());
        if ($item->hasCustomName()) {
            $this->setName($item->getCustomName());
        }
    }

    public function readSaveData(CompoundTag $nbt): void {
        $this->loadName($nbt);
        $this->loadItems($nbt);
        $this->facing = $nbt->getByte(self::TAG_FACING, $this->facing);
    }

    public function close(): void {
        if (!$this->closed) {
            $this->inventory->removeAllViewers();
            $this->inventory = null;
            parent::close();
        }
    }

    public function getCleanedNBT(): ?CompoundTag {
        $nbt = parent::getCleanedNBT();
        if ($nbt !== null) {
            if ($nbt->getTag(self::TAG_FACING) !== null) {
                $nbt->removeTag(self::TAG_FACING);
            }
        }
        return $nbt;
    }

    public function getFacing(): int {
        return $this->facing;
    }

    public function setFacing(int $facing): void {
        $this->facing = $facing;
    }

    public function getInventory(): ShulkerBoxInventory {
        return $this->inventory;
    }

    public function getRealInventory(): ShulkerBoxInventory {
        return $this->inventory;
    }

    public function getDefaultName(): string {
        return "Shulker Box";
    }

    public function onBlockDestroyedHook() : void{
		//Drop Nothing.
	}

	protected function writeSaveData(CompoundTag $nbt): void {
        $this->saveName($nbt);
        $this->saveItems($nbt);
        $nbt->setByte(self::TAG_FACING, $this->facing);
    }

    protected function addAdditionalSpawnData(CompoundTag $nbt): void {
        $nbt->setByte(self::TAG_FACING, $this->facing);
        $this->addNameSpawnData($nbt);
    }
}