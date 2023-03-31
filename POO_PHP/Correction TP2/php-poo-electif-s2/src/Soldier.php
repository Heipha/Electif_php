<?php

require_once('./src/Character.php');

class Soldier extends Character
{
    public function __construct(
        float $health,
        float $defenseRatio,
        int $attackDamages,
    )
    {
        parent::__construct($health, $defenseRatio, $attackDamages, magicDamages: 0);
    }

    protected function takesMagicalDamagesFrom(Character $character)
    {
        echo "Ce n'est pas très efficace…".PHP_EOL;
        return $character->getMagicDamages()*0.8;
    }

    public function getAttackDamages()
    {
        if (chance(10)) {
            echo "Coup critique !".PHP_EOL;
            return $this->attackDamages*2;
        }
        return parent::getAttackDamages();
    }
}
