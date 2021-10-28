<?php

require ('./Classes/PDOManager.php');
require ('./Classes/Perso.php');

$bdd = PDOManager::getBdd();
$NAME_PERSO = $_POST['perso'];
$TYPE_PERSO = $_POST['type'];

$newPerso = Perso::createNewPerso($TYPE_PERSO, $NAME_PERSO);



?>
<script> location.replace("/"); </script>

