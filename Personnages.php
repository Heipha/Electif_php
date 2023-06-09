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
require_once __DIR__ . '/Element.php';
require_once __DIR__ . '/Spell.php';

abstract class Personnages {

    protected string $name;
    protected float $health;
    protected int $strength;
    protected float $defense;
    protected int $magicalDamage;
    protected ?int $damage = null;
    protected int $mana;
    protected ?Spell $spell = null;
    protected ?Weapon $weapon = null;
    protected Element $element;

    public function __construct($name, $health, $strength, $defense, $magicalDamage, $mana, Element $element, ?Weapon $weapon = null, ?Spell $spell = null) {
        $this->name = $name;
        $this->health = $health;
        $this->strength = $strength;
        $this->defense = $defense;
        $this->magicalDamage = $magicalDamage;
        $this->mana = $mana;
        $this->spell = $spell;
        $this->weapon = $weapon;
        $this->element = $element;
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

    public function equipSpell(Spell $spell)
    {
        // Vérifiez si le sort est compatible avec l'élément du personnage
        if($spell instanceof DamageSpell){
            if($spell->getElement() == $this->getElement()){
                $this->spell = $spell;
                echo "{$this} a équipé le sort d'attaque {$spell->getName()} de type {$spell->getElement()}!".PHP_EOL;;
            }
        }else{
            $this->spell = $spell;
            echo "{$this} a équipé le sort {$spell->getName()}!".PHP_EOL;
        }
    }

    public function attacks(Personnages $target)
    {
        if($this->spell !== null && $this->canCastSpell()){
            echo "{$this} utilise {$this->spell->getName()}!".PHP_EOL;
            $damageDealt = $this->castSpell($target);
            $this->spell->setCooldown($this->spell->getInitialCooldown());
            return;
        } else{
            echo "{$this->spell->getName()} n'est pas encore prêt. Cooldown restant : {$this->spell->getCooldown()} tour(s)".PHP_EOL;
        }
        if($this->hasWeapon())
            {
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
        $damageDealt = $damages * (1 - $this->getDefense());
        if($attacker->effectiveAgainst($this))
        {
            echo "C'est super efficace !".PHP_EOL;
            $damageDealt *= 2;
        }else{
            echo "Ce n'est pas très efficace...".PHP_EOL;
            $damageDealt /= 2;
        }
        $this->setHealth(
            $this->getHealth() - $damageDealt
        );
        
        return $damageDealt;

    }

    public function effectiveAgainst(Personnages $target): bool
    {

        $thisElement = $this->element;
        $targetElement = $target->getElement();
        
        if ($thisElement == Element::EAU && $targetElement == Element::FEU ||
            $thisElement == Element::FEU && $targetElement == Element::PLANTE ||
            $thisElement == Element::PLANTE && $targetElement == Element::EAU) {
            return true;
        } else {
            return false;
        }
    }

    public function nextTurn()
    {
        if ($this->spell !== null && $this->spell->getCooldown()> 0) {
            $this->spell->setCooldown($this->spell->getCooldown() - 1);
        }
    }

    public function canCastSpell(): bool
    {
        if ($this->mana >= $this->spell->getManaCost() && $this->spell->getCooldown() == 0) {
            return true;
        }else{
            echo "{$this->spell->getName()} n'est pas encore prêt. Cooldown restant : {$this->spell->getCooldown()} tour(s)".PHP_EOL;
            return false;
        }
    }

    public function castSpell(Personnages $target) 
    {
            if($this->spell instanceof HealingSpell){
                echo "{$this} se soigne de {$this->spell->cast($this)} points de vie !".PHP_EOL;
            }

            if($this->spell instanceof DamageSpell){
                if($this->effectiveAgainst($target)){
                    echo "C'est super efficace !".PHP_EOL;
                    $damageDealt = $this->spell->cast($target) * 2;
                    echo "{$this} inflige {$damageDealt} points de dégâts à {$target} !".PHP_EOL;
                    return $damageDealt;
                }else{
                    echo "Ce n'est pas très efficace...".PHP_EOL;
                    $damageDealt = $this->spell->cast($target) / 2;
                    echo "{$this} inflige {$damageDealt} points de dégâts à {$target} !".PHP_EOL;
                    return $damageDealt;
                }
            }

            if($this->spell instanceof DefenseSpell){
                echo "{$this} augmente sa défense de {$this->spell->cast($this)} !".PHP_EOL;
                // $this->spellCooldown = $spell->getCooldown();
            }
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

    public function getElement() {
        return $this->element;
    }

    public function setElement($element) {
        $this->element = $element;
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