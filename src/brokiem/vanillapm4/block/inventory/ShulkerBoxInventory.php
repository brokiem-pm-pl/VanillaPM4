<?php

declare(strict_types=1);

namespace brokiem\vanillapm4\block\inventory;

use brokiem\vanillapm4\sound\ShulkerCloseSound;
use brokiem\vanillapm4\sound\ShulkerOpenSound;
use pocketmine\block\BlockLegacyIds;
use pocketmine\block\inventory\AnimatedBlockInventoryTrait;
use pocketmine\block\inventory\BlockInventory;
use pocketmine\inventory\SimpleInventory;
use pocketmine\item\Item;
use pocketmine\network\mcpe\protocol\BlockEventPacket;
use pocketmine\world\Position;
use pocketmine\world\sound\Sound;

class ShulkerBoxInventory extends SimpleInventory implements BlockInventory {
    use AnimatedBlockInventoryTrait;

    public function __construct(Position $holder) {
        $this->holder = $holder;
        parent::__construct(27);
    }

    public function canAddItem(Item $item): bool {
        if ($item->getId() === BlockLegacyIds::UNDYED_SHULKER_BOX or $item->getId() === BlockLegacyIds::SHULKER_BOX) {
            return false;
        }
        return parent::canAddItem($item);
    }

    protected function getOpenSound(): Sound {
        return new ShulkerOpenSound();
    }

    protected function getCloseSound(): Sound {
        return new ShulkerCloseSound();
    }

    protected function animateBlock(bool $isOpen): void {
        $holder = $this->getHolder();

        $holder->getWorld()->broadcastPacketToViewers($holder, BlockEventPacket::create(1, $isOpen ? 1 : 0, $holder->asVector3()));
    }
}