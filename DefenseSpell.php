<?php
class DefenseSpell extends Spell {
    protected float $defenseBonus;

    public function __construct($name, $description, $manaCost, $defenseBonus) {
        parent::__construct($name, $description, $manaCost);
        $this->defenseBonus = $defenseBonus;
    }

    public function cast(Personnages $caster) {
        $defenseRatio = $caster->getDefense() + $this->defenseBonus;
        $caster->setDefense($defenseRatio);
        return $defenseRatio;
    }
}
