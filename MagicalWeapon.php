<?php
require_once __DIR__ . '/Weapon.php';

class MagicalWeapon extends Weapon{
    public function __construct(
        protected string $name,
        protected string $description,
        private int $magicDamage,
    ) {parent::__construct($name, $magicDamage);
    }
    public function getMagicDamage(): int
    {
        return $this->magicDamage;
    }
    public function setMagicDamage(int $magicDamage): void
    {
        $this->magicDamage = $magicDamage;
    } 
}