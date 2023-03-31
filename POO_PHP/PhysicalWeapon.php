<?php
require_once __DIR__ . '/Weapon.php';

class PhysicalWeapon extends Weapon{
    public function __construct(
        protected string $name,
        protected string $description,
        private int $physicalDamage,
    ) {parent::__construct($name, $physicalDamage);
    }
    public function getPhysicalDamage(): int
    {
        return $this->physicalDamage;
    }
    public function setPhysicalDamage(int $physicalDamage): void
    {
        $this->physicalDamage = $physicalDamage;
    }

}