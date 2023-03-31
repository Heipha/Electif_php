<?php
require_once __DIR__ . '/Personnages.php';
class Wizard extends Personnages{

    protected $mana = 10;
    public function __construct(string $name, int $health, int $strength, float $defense, int $magicalDamage) {
        parent::__construct($name, $health, $strength, $defense, $magicalDamage);
    }
    // public function attack($target) {
    //     $target->setHealth($target->getHealth() - $this->strength);
    //     $this->mana--;
    // }
    public function getMana() {
        return $this->mana;
    }
    public function setMana($mana) {
        $this->mana = $mana;
    }
    //@Override
    public function getMagicDamages()
    {
        if (chance(10)) {
            echo "Coup critique !". PHP_EOL;
            return $this->magicalDamage*2;
        }
        return parent::getMagicalDamage();
    }
    //@Override
    public function getDefense()
    {
        if (chance(5)) {
            return $this->defense + 0.1;
        }
        return parent::getDefense();
    }

    // public function __toString() {
    //     return parent::__toString() . ' Il lui reste ' . $this->mana . ' mana.';
    // }
}