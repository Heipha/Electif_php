<?php 
require_once __DIR__ . '/Personnages.php';
class Archer extends Personnages{
    protected $arrow = 10;
    public function __construct(string $name, int $health, int $strength, float $defense, int $magicalDamage, Element $element, ?Weapon $weapon = null) {
        if($magicalDamage > $strength){
            throw new Exception("L'archer' ne peut pas avoir plus de dégats magiques que de dégats physiques");
        }
        parent::__construct($name, $health, $strength, $defense, $magicalDamage, $element, $weapon);
    }

    // public function attack($target) {
    //     $target->setHealth($target->getHealth() - $this->strength);
    //     $this->arrow--;
    // }
    public function getArrow() {
        return $this->arrow;
    }
    public function setArrow($arrow) {
        $this->arrow = $arrow;
    }
    //@Override
    public function getStrength()
    {
        if (chance(20)) {
            echo "Coup critique !".PHP_EOL;
            return $this->strength*1.2;
        }
        return parent::getStrength();
    }
    //@Override
    public function getDefense()
    {
        if (chance(10)) {
            echo "Esquive !".PHP_EOL;
            return 1;
        }
        return parent::getDefense();
    }
    // public function __toString() {
    //     return parent::__toString() . ' Il lui reste ' . $this->arrow . ' flèches.';
    // }
   
}
