<?php
class HealingSpell extends Spell {
    protected float $healing;
    protected int $cooldown;
    protected int $initialCooldown;

    public function __construct($name, $description, $manaCost, $healing, $cooldown, $initialCooldown) {
        parent::__construct($name, $description, $manaCost, $initialCooldown);
        $this->healing = $healing;
        $this->cooldown = $cooldown;
    }

    public function getHealing() {
        return $this->healing;
    }

    public function setHealing($healing) {
        $this->healing = $healing;
    }

    public function cast(Personnages $caster) {
        $caster->setHealth($caster->getHealth() + $this->healing);
        $this->cooldown = $this->initialCooldown;
        var_dump($this->cooldown);
        return $this->healing;	
    }
}