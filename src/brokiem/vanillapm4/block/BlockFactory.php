<?php

declare(strict_types=1);

namespace brokiem\vanillapm4\block;

use brokiem\vanillapm4\tile\ShulkerBox as TileShulkerBox;
use pocketmine\block\BlockBreakInfo;
use pocketmine\block\BlockFactory as BlockFactoryPM;
use pocketmine\block\BlockIdentifier as BID;
use pocketmine\block\BlockLegacyIds as Ids;
use pocketmine\block\BlockToolType;
use pocketmine\block\Opaque;
use pocketmine\block\Transparent;
use pocketmine\block\utils\TreeType;
use pocketmine\item\ItemIds;

class BlockFactory {

    public static function init(): void {
        /** @var BlockFactoryPM $i */
        $i = BlockFactoryPM::getInstance();

        $i->register(new ShulkerBox(new BID(Ids::SHULKER_BOX, 0, null, TileShulkerBox::class), "Shulker Box"));
        $i->register(new ShulkerBox(new BID(Ids::UNDYED_SHULKER_BOX, 0, null, TileShulkerBox::class), "Shulker Box"));
        $i->register(new Seagrass(new BID(Ids::SEAGRASS, 0), "Seagrass"));
        $i->register(new Lectern(new BID(Ids::LECTERN, 0), "Lectern"));
        $i->register(new Campfire(new BID(Ids::CAMPFIRE, 0, ItemIds::CAMPFIRE), "Campfire"));
        $i->register(new Composter(new BID(Ids::COMPOSTER, 0), "Composter"));
        $i->register(new Transparent(new BID(Ids::BELL, 0), "Bell", new BlockBreakInfo(1, BlockToolType::PICKAXE, 0, 25)));
        $i->register(new BlastFurnace(new BID(Ids::BLAST_FURNACE, 0), "BlastFurnace"));
        $i->register(new Smoker(new BID(Ids::SMOKER, 0), "Smoker"));
        $i->register(new SweetBerryBush(new BID(Ids::SWEET_BERRY_BUSH, 0), "SweetBerryBush"));
        $i->register(new Grindstone(new BID(Ids::GRINDSTONE, 0), "Grindstone"));

        $i->register(new Opaque(new BID(Ids::FLETCHING_TABLE, 0), "FletchingTable", new BlockBreakInfo(2, BlockToolType::AXE, 0, 2)));
        $i->register(new Transparent(new BID(Ids::STONECUTTER_BLOCK, 0), "Stonecutter", new BlockBreakInfo(2, BlockToolType::PICKAXE, 0, 2)));
        $i->register(new Opaque(new BID(Ids::CARTOGRAPHY_TABLE, 0), "CarthographyTable", new BlockBreakInfo(2, BlockToolType::AXE, 0, 2)));
        $i->register(new Transparent(new BID(Ids::CAULDRON_BLOCK, 0), "Cauldron", new BlockBreakInfo(2, BlockToolType::PICKAXE, 0, 2)));

        foreach (TreeType::getAll() as $treeType) {
            $magicNumber = $treeType->getMagicNumber();
            $name = $treeType->getDisplayName();
            $wood = new Wood(new BID(Ids::WOOD, $magicNumber), $name . " Wood", $treeType, false);
            $i->register($wood, true);
        }
    }
}