<?php

require_once('./src/Character.php');

class Wizard extends Character
{
    public function __construct(
        float $health,
        float $defenseRatio,
        int $attackDamages,
        int $magicDamages,
    )
    {
        if ($magicDamages < $attackDamages) {
            throw new Exception("The wizard cannot have more physical damages than magic damages.");
        }
        parent::__construct($health, $defenseRatio, $attackDamages, $magicDamages);
    }

    public function getMagicDamages()
    {
        if (chance(10)) {
            echo "Coup critique !".PHP_EOL;
            return $this->magicDamages*2;
        }
        return parent::getMagicDamages();
    }

    public function getDefenseRatio()
    {
        if (chance(5)) {
            return $this->defenseRatio + 0.1;
        }
        return parent::getDefenseRatio();
    }
}
