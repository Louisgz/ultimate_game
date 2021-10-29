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
    header("Refresh:0");
    unset($_POST);
}
if (isset($_POST['buttonSleep'])) {
    unset($_POST);
}

function uniquePost($posted)
{
    // take some form values
    $description = $posted['t_betreff'] . $posted['t_bereich'] . $posted['t_nachricht'];
    // check if session hash matches current form hash
    if (isset($_SESSION['form_hash']) && $_SESSION['form_hash'] == md5($description)) {
        // form was re-submitted return false
        return false;
    }
    // set the session value to prevent re-submit
    $_SESSION['form_hash'] = md5($description);
    return true;
}
?>

<!doctype html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Battle</title>
</head>

<body>
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
                            <button type="post" name="buttonSleep" value="<?php echo $key ?>">
                                Endormir
                            </button>
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