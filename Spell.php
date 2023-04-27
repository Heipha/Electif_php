<?php
abstract class Spell {
    protected string $name;
    protected string $description;
    protected int $manaCost;
    protected int $initialCooldown;
    protected int $cooldown;

    public function __construct($name, $description, $manaCost, $cooldown = 0) {
        $this->name = $name;
        $this->description = $description;
        $this->manaCost = $manaCost;
        $this->initialCooldown = $cooldown;
        $this->cooldown = 0;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getManaCost() {
        return $this->manaCost;
    }

    public function setManaCost($manaCost) {
        $this->manaCost = $manaCost;
    }

    public function getCooldown(): int {
        return $this->cooldown;
    }

    public function getInitialCooldown(): int {
        return $this->initialCooldown;
    }

    public function setCooldown(int $cooldown): void {
        $this->cooldown = $cooldown;
    }

}