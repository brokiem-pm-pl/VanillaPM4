<?php

declare(strict_types=1);

namespace brokiem\vanillapm4\sound;

use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;
use pocketmine\world\sound\Sound;

class SweetBerryBushPickSound implements Sound {

    public function encode(?Vector3 $pos): array {
        return [LevelSoundEventPacket::create(LevelSoundEventPacket::SOUND_BLOCK_SWEET_BERRY_BUSH_PICK, $pos)];
    }
}