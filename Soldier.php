<?php
require_once __DIR__ . '/Personnages.php';
class Soldier extends Personnages{
    protected $ammo = 10;
    public function __construct(string $name, int $health, int $strength, float $defense, ?Weapon $weapon = null) {
        parent::__construct($name, $health, $strength, $defense, 0, $weapon);
    }
    // public function attack($target) {
    //     $target->setHealth($target->getHealth() - $this->strength);
    //     $this->ammo--;
    // }
    public function getammo() {
        return $this->ammo;
    }
    public function setammo($ammo) {
        $this->ammo = $ammo;
    }
    //@Override
    protected function takesMagicalDamagesFrom(Personnages $character)
    {
        echo "Ce n'est pas très efficace…".PHP_EOL;
        return $character->getMagicalDamage()*0.8;
    }
    //@Override
    public function getStrength()
    {
        if (chance(10)) {
            echo "Coup critique !".PHP_EOL;
            return $this->strength*2;
        }
        return parent::getStrength();
    }

    // public function __toString() {
    //     return parent::__toString() . ' Il lui reste ' . $this->ammo . ' munitions.';
    // }
}

