<?php
/*TODO faire type(eau, feu, plante)
spell:
-sort de degats
-sort de defense
-sort de soin

equipement:
-3 sort
-1 arme
-1 spell de chaque

regen a chaque tour

test equilibrage 

*/
require_once __DIR__ . '/Weapon.php';
abstract class Personnages {

    protected string $name;
    protected float $health;
    protected int $strength;
    protected float $defense;
    protected int $magicalDamage;
    protected ?int $damage = null;
    protected ?Weapon $weapon = null;

    public function __construct($name, $health, $strength, $defense, $magicalDamage, ?Weapon $weapon = null) {
        $this->name = $name;
        $this->health = $health;
        $this->strength = $strength;
        $this->defense = $defense;
        $this->magicalDamage = $magicalDamage;
        $this->weapon = $weapon;
    }
    //Nom getter et setter
    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    // Points de vie getter et setter
    public function gethealth() {
        return $this->health;
    }

    public function sethealth($health) {
        $this->health = $health;
    }

    // Points de degats getter et setter
    public function getStrength() {
        if($this->weapon instanceof PhysicalWeapon) {
            return $this->strength + $this->weapon->getPhysicalDamage();
        }
        return $this->strength;
    }

    public function setStrength($strength) {
        $this->strength = $strength;
    }

    // Points de defenses getter et setter
    public function getDefense() {
        return $this->defense;
    }

    public function setDefense($defense) {
        $this->defense = $defense;
    }

    // Points de degats magiques getter et setter
    public function getMagicalDamage() {
        if($this->weapon instanceof MagicalWeapon) {
            return $this->magicalDamage + $this->weapon->getMagicDamage();
        }
        return $this->magicalDamage;
    }

    public function setMagicalDamage($magicalDamage) {
        $this->magicalDamage = $magicalDamage;
    }

    //Methodes combat
    public function equipWeapon(Weapon $weapon)
    {
        $this->weapon = $weapon;
    }
    public function hasWeapon()
    {
        return $this->weapon instanceof Weapon;
    }

    public function attacks(Personnages $target)
    {
        if($this->hasWeapon()){
                echo "{$this} attaque {$target} avec {$this->weapon->getName()}!".PHP_EOL;
                echo "".PHP_EOL;
                $damageDealt = $target->takesDamagesFrom($this);
                echo "{$this} inflige {$damageDealt} points de dégâts à {$target} !".PHP_EOL;
        }else{
            echo "{$this} attaque {$target} !".PHP_EOL;
            echo "".PHP_EOL;
            $damageDealt = $target->takesDamagesFrom($this);
            echo "{$this} inflige {$damageDealt} points de dégâts à {$target} !".PHP_EOL;
        }
    }

    public function takesDamagesFrom(Personnages $attacker)
    {
        $damages = $this->takesPhysicalDamagesFrom($attacker) + $this->takesMagicalDamagesFrom($attacker);
        $this->setHealth(
            $this->getHealth() - ($damages * (1 - $this->getDefense()))
        );
        $damageDealt = $damages * (1 - $this->getDefense());
        return $damageDealt;

    }

    protected function takesPhysicalDamagesFrom(Personnages $attacker)
    {
        return $attacker->getStrength();
    }

    protected function takesMagicalDamagesFrom(Personnages $attacker)
    {
        return $attacker->getMagicalDamage();
    }

    public function isDead() {
        return $this->health <= 0;
    }

    public function getDamage() {
        $damage = $this->getStrength() + $this->getMagicalDamage();
        $defense = $this->getDefense();
        $result = $damage - ($damage * $defense);
        return $result;
    }

    // public function MagicalDamage($target) {
    //     $magicalDamage = $target->getMagicalDamage();
    //     $defense = $this->getDefense();
    //     $result = $magicalDamage - ($magicalDamage * $defense);
    //     return $result;
    // }

    public function __toString() {
        // return "\n" . $this->name . ' a ' . round($this->health, 0) . ' points de vie ' . "\ninflige " . $this->damage . ' degat a son adversaire'. PHP_EOL;
        return static::class;
    }

}