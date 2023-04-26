<?php
class Spell {
    protected string $name;
    protected string $description;
    protected int $damage;
    protected int $manaCost;

    public function __construct($name, $description, $manaCost) {
        $this->name = $name;
        $this->description = $description;
        $this->manaCost = $manaCost;
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
}