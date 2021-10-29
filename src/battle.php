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
        $player->makeSleep($allPersos[$_POST['buttonSleep']]);
    }
    unset($_POST);
}

?>

<!doctype html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./css/style.css">
    <title>Battle</title>
    <link rel="shortcut icon" href="./images/logo.png" type="image/x-icon">
</head>

<body class="body-bg">
<button class="back-button"><a href="./index.php">
        <img src="./images/icons/left-arrow.png" alt="left arrow">
        go back
    </a></button>
<div class="battle-main-perso">
    <img src="./images/<? echo $player->getType(); ?>.png" class="battle-player-image"
         alt="perso <?php echo $player->getType() ?>">
    <h3 class="battle-player-title"><?php echo $player->getName(); ?></h3>
    <p class="battle-player-att">
        <img src="./images/icons/heart.png" class="att-icons"></img>
        <?php echo $player->getPv(); ?> pv
    </p>
    <p class="battle-player-att">
        <img src="./images/icons/shield.png" class="att-icons"></img>
        <?php echo $player->getDefense(); ?> defense
    </p>
    <p class="battle-player-att">
        <img src="./images/icons/sword.png" class="att-icons"></img>
        <?php echo $player->getForce(); ?> attack
    </p>
</div>
<div class="battle-persos-container">
    <?php
    foreach ($allPersos as $key => $perso) {
        if ($perso->getId() !== $player->getId()) {
            ?>
            <div class="battle-perso-row">
                <div class="battle-perso-image-container">
                    <img src="./images/<? echo $perso->getType(); ?>.png" class="battle-perso-image"
                         alt="perso <?php echo $perso->getType() ?>">
                </div>
                <div class="battle-perso-stats">
                    <div class="battle-perso-title">
                        <?php echo $perso->getName() ?>
                    </div>
                    <p class="battle-perso-att">
                        <img src="./images/icons/heart.png" class="att-icons"></img>
                        <?php echo $perso->getPv(); ?> pv
                    </p>
                    <p class="battle-perso-att">
                        <img src="./images/icons/shield.png" class="att-icons"></img>
                        <?php echo $perso->getDefense(); ?> defense
                    </p>
                    <p class="battle-perso-att">
                        <img src="./images/icons/sword.png" class="att-icons"></img>
                        <?php echo $perso->getForce(); ?> attack
                    </p>
                    <div class="battle-perso-element">
                        <div class="battle-perso-buttons">
                            <form method="post">
                                <button class="battle-perso-button1" type="post" name="buttonAttack"
                                        value="<?php echo $key ?>">
                                    Attaquer
                                </button>
                                <button class="battle-perso-button2" type="post" name="buttonSleep"
                                        value="<?php echo $key ?>">
                                    Endormir
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    }

    if (count($allPersos) === 1) {
        echo '<p class="text-win">
        <img src="./images/winner.png"/>
                Tous les personnages ont été vaincus, vous avez gagné !
</p>';
    };
    ?>
</div>
</body>

</html>