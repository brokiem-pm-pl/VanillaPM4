<?php

declare(strict_types=1);

namespace brokiem\vanillapm4;

use brokiem\vanillapm4\block\BlockFactory;
use brokiem\vanillapm4\item\ItemFactory;
use brokiem\vanillapm4\tile\TileFactory;
use pocketmine\block\Block;
use pocketmine\block\utils\TreeType;
use pocketmine\block\VanillaBlocks;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\AssumptionFailedError;

class VanillaPM4 extends PluginBase {

    protected function onEnable(): void {
        $this->getLogger()->debug("Registering VanillaPM4 blocks");
        BlockFactory::init();
        $this->getLogger()->debug("Registering VanillaPM4 items");
        ItemFactory::init();
        $this->getLogger()->debug("Registering VanillaPM4 tiles");
        TileFactory::init();
    }

    public static function getStrippedLogBlock(TreeType $treeType): Block {
        switch ($treeType->id()) {
            case TreeType::OAK()->id():
                return VanillaBlocks::STRIPPED_OAK_LOG();
            case TreeType::SPRUCE()->id():
                return VanillaBlocks::STRIPPED_SPRUCE_LOG();
            case TreeType::BIRCH()->id():
                return VanillaBlocks::STRIPPED_BIRCH_LOG();
            case TreeType::JUNGLE()->id():
                return VanillaBlocks::STRIPPED_JUNGLE_LOG();
            case TreeType::ACACIA()->id():
                return VanillaBlocks::STRIPPED_ACACIA_LOG();
            case TreeType::DARK_OAK()->id():
                return VanillaBlocks::STRIPPED_DARK_OAK_LOG();
        }
        throw new AssumptionFailedError("Switch should cover all wood types");
    }
}