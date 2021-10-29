<?php
  require ('./Classes/Perso.php');
  require('./Classes/PDOManager.php');


  // $destroy = "DELETE FROM `persos` WHERE id=?";
  $id = $_GET['id'];
  $killPerso = Perso::deleteSelectedPerso($id);
  ?>
<script> location.replace("/"); </script>