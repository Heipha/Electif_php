<?php
require_once __DIR__ . './functions.php';

require_once __DIR__ . '/Archer.php';
require_once __DIR__ . '/Soldier.php';
require_once __DIR__ . '/Wizard.php';

require_once __DIR__ . '/PhysicalWeapon.php';
require_once __DIR__ . '/MagicalWeapon.php';

require_once __DIR__ . '/Element.php';

require_once __DIR__ . '/Spell.php';
require_once __DIR__ . '/DefenseSpell.php';
require_once __DIR__ . '/DamageSpell.php';
require_once __DIR__ . '/HealingSpell.php';

$Feu = new Element(Element::FEU);
$Eau = new Element(Element::EAU);
$Plante = new Element(Element::PLANTE);

$defenseSpell = new DefenseSpell('Sort de défense','Augmente la Défense définitivement', 10, 0,15);
$damageSpell = new DamageSpell('Sort de dégâts', 'Coup Critique assuré !', 15, 20, 1, 2);
$healSpell = new HealingSpell('Sort de soin', 'Soigne le personnage', 12, 10, 1, 2);

$archer = new Archer('Bruni', 100, 17, 0.05, 7, 100, $Plante);

$Soldier = new Soldier('Jean-Pierre', 120, 14, 0.15, 50, $Feu);

$wizard = new Wizard('Gandalf', 100, 7, 0.25, 17, 150, $Eau);

$weapon = new PhysicalWeapon('Épée', 'Une épée de 1m50', 10);

$magicalWeapon = new MagicalWeapon('Bâton', 'Un bâton magique de fou', 10);

$i=1;

$queue = [$archer, $Soldier, $wizard];

shuffle($queue);

$Soldier->equipWeapon($weapon);
echo "{$Soldier} a équipé {$weapon->getName()}".PHP_EOL;
$wizard->equipWeapon($magicalWeapon);
echo "{$wizard} a équipé {$magicalWeapon->getName()}". PHP_EOL;

$archer->equipSpell($healSpell);
$archer->equipSpell($defenseSpell);
$damageSpell->setElement($archer->getElement());
$archer->equipSpell($damageSpell);

$Soldier->equipSpell($healSpell);
$Soldier->equipSpell($defenseSpell);
$damageSpell->setElement($Soldier->getElement());
$Soldier->equipSpell($damageSpell);

$wizard->equipSpell($healSpell);
$wizard->equipSpell($defenseSpell);
$damageSpell->setElement($wizard->getElement());
$wizard->equipSpell($damageSpell);



while (count($queue) > 1){
    $attacker = array_shift($queue);
    $key= array_rand($queue);
    $defender = $queue[$key];

    $attacker->attacks($defender);
    $attacker->nextTurn();


    if ($defender->isDead()) {
        unset($queue[$key]);
        echo "{$defender} est mort".PHP_EOL;
        echo PHP_EOL;
        array_unshift($queue, $attacker);
        shuffle($queue);
        continue;
    }
    
    echo "{$defender} a {$defender->getHealth()} points de vie".PHP_EOL;
    echo PHP_EOL;
    array_unshift($queue, $attacker);
    shuffle($queue);

}

$winner = array_pop($queue);
echo "==================".PHP_EOL;
echo "{$winner} a gagné !".PHP_EOL;
echo "==================".PHP_EOL;


echo PHP_EOL;


//     echo "\nAttaque $i : ";
//     $archer->attack($Soldier);
//     echo $archer->__toString();
//     $i++;
//     echo "\nAttaque $i : ";
//     $Soldier->attack($archer);
//     echo $Soldier->__toString();
//     $i++;
// }

// if($archer->isAlive()){
//     echo "\nVictoire de l'archer !";
// }
// if($Soldier->isAlive()) {
//     echo "\nVictoire du soldat !";
// }
