<?php

require('./Classes/PDOManager.php');
require('./Classes/Perso.php');
// Create connection
$bdd = PDOManager::getBdd();
// Check connection
if ($bdd->connect_error) {
    die("Connection failed: " . $bdd->connect_error);
    echo 'err';
};
$id = $_GET['id'];


$player = Perso::getSinglePerso($id);
$allPersos = Perso::getAllPersos($id);

if (isset($_POST['buttonAttack'])) {
    $player->attack($allPersos[$_POST['buttonAttack']]);
    unset($_POST);
    header("Refresh:0");
}
if (isset($_POST['buttonSleep'])) {
    if ($player->getType() === 'magicien') {
        $player->sleep($allPersos[$_POST['buttonSleep']]);
    }
    unset($_POST);
}

?>

<!doctype html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./css/style.css">
    <title>Battle</title>
</head>

<body class="body-bg">
    <div class="battle-main-perso">
        <img src="./images/<? echo $player->getType() ?>.png" class="perso-image" alt="perso <?php echo $player->getType() ?>" onclick="document.querySelector('#input-type-1').checked = true">
    </div>
    <div class="battle-persos-container">
        <?php
        foreach ($allPersos as $key => $perso) {
        ?>
            <div class="battle-perso-row">
                <div class="battle-perso-element">
                    <?php echo $perso->getName() ?>
                </div>
                <div class="battle-perso-element">
                    <?php echo $perso->getType() ?>
                </div>
                <div class="battle-perso-element">
                    pv : <?php echo $perso->getPv() ?>
                </div>
                <div class="battle-perso-element">
                    force : <?php echo $perso->getForce() ?>
                </div>
                <div class="battle-perso-element">
                    defense : <?php echo $perso->getDefense() ?>
                </div>
                <div class="battle-perso-element">
                    <div class="battle-perso-buttons">
                        <form method="post">
                            <button type="post" name="buttonAttack" value="<?php echo $key ?>">
                                Attaquer
                            </button>
                            <?php
                            if ($player->gettype() === 'magicien') { ?>
                                <button type="post" name="buttonSleep" value="<?php echo $key ?>">
                                    Endormir
                                </button>
                            <?php } ?>

                        </form>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
</body>

</html>