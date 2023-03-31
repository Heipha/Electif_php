<?php
require_once __DIR__ . './functions.php';

require_once __DIR__ . '/Archer.php';
require_once __DIR__ . '/Soldier.php';
require_once __DIR__ . '/Wizard.php';

require_once __DIR__ . '/PhysicalWeapon.php';
require_once __DIR__ . '/MagicalWeapon.php';


$archer = new Archer('Bruni', 100, 17, 0.05, 7);

$Soldier = new Soldier('Jean-Pierre', 120, 14, 0.15, new PhysicalWeapon('Couteau de chasse', 'test', 10));

$wizard = new Wizard('Gandalf', 100, 7, 0.25, 17, new MagicalWeapon('Bâton magique', 'test', 7));

$i=1;

$queue = [$archer, $Soldier, $wizard];

shuffle($queue);

while (count($queue) > 1){
    $attacker = array_shift($queue);
    $key= array_rand($queue);
    $defender = $queue[$key];

    $attacker->attacks($defender);


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