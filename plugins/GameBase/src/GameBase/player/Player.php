<?php

declare(strict_types=1);

namespace GameBase\player;

use GameBase\entity\Attributes;
use pocketmine\level\Position;
use pocketmine\Player as _Player;

class Player
{

    /** @var Attributes */
    private static $attributes;
    private $defaultDamage = [.0, .0];
    private $magicalDamage = [.0, .0];

    public function __construct(_Player $player)
    {
        static::$player = $player;
        static::init();
    }

    public function getPlayer() : _Player
    {
        return static::$player;
    }

    private static function init() : void
    {
        static::$attributes = new Attributes();
        //TODO: Data push
        //TODO: Для реализации этого всего, нужны классы персонажей
        static::$attributes->push([]);
    }

    public function getMinDamage() : float
    {
        $damage = $this->defaultDamage[0];
        //По логике игровой механики, сила даёт +3 физ. дамага.
        $damage += static::$attributes->{Attributes::STRENGTH} * 3;

        return $damage;
    }

    public function getMaxDamage() : float
    {
        $damage = $this->defaultDamage[1];
        //По логике игровой механики, сила даёт +3 физ. дамага.
        $damage += static::$attributes->{Attributes::STRENGTH} * 3;
        return $damage;
    }

    public function getFinalDamage() : float
    {
        $damage = mt_rand($this->getMinDamage(), $this->getMaxDamage());

        //Крит вынести в процесс атаки.
        if(mt_rand(0, 100) < $this->getCriticalChance())
        {
            $damage *= $this->getCriticalMilitiplication();
        }
        return $damage;
    }

    public function getMinMagicalDamage() : float
    {
        $damage = $this->defaultDamage[0];
        //По логике игровой механики, сила даёт +3 физ. дамага.
        $damage += static::$attributes->{Attributes::INTELLIGENCE} * 6;

        return $damage;
    }

    public function getMaxMagicalDamage() : float
    {
        $damage = $this->defaultDamage[1];
        //По логике игровой механики, сила даёт +3 физ. дамага.
        $damage += static::$attributes->{Attributes::INTELLIGENCE} * 6;
        return $damage;
    }

    public function getCriticalChance() : float
    {
        $chance = 8;
        // 1 ловкость = 0.45 шк
        $chance += static::$attributes->{Attributes::VITALITY} * 0.45;

        return min(100, $chance);
    }

    public function getCriticalMilitiplication() : float
    {
        $multi = 1.2;//База у всех классов
        return $multi;
    }

    public function save() : void
    {

    }

    /**
     * @var _Player
     */
    private static
        $player;

    /** Implementations */

    public function getPosition() : Position
    {
        return static::$player->getPosition();
    }

    public function getName() : string
    {
        return static::$player->getName();
    }

    public function getDisplayName() : string
    {
        return static::$player->getDisplayName();
    }

    public function setDisplayName(string $newName) : void
    {
        static::$player->setDisplayName($newName);
    }

}