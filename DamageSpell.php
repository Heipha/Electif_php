<?php
class DamageSpell extends Spell {
    protected int $damage;
    protected int $cooldown;
    protected int $initialCooldown;
    protected ?Element $element = null;

    public function __construct($name, $description, $manaCost, $damage, $cooldown, $initialCooldown, ?Element $element = null ) {
        parent::__construct($name, $description, $manaCost, $initialCooldown);
        $this->damage = $damage;
        $this->cooldown = $cooldown;
        $this->element = $element;
    }

    public function getDamage() {
        return $this->damage;
    }

    public function setDamage($damage) {
        $this->damage = $damage;
    }

    public function getElement() {
        return $this->element;
    }

    public function setElement($element) {
        $this->element = $element;
    }

    public function castDamageSpell(Personnages $target) {
        $damageDealt = $target->getHealth() - $this->damage;
        $target->setHealth($damageDealt);
        $this->cooldown = $this->initialCooldown;
        return $this->damage;
    }
}