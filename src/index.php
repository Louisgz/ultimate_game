<?php

require('./Classes/PDOManager.php');
// Create connection
$conn = PDOManager::getBdd();
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "CREATE TABLE IF NOT EXISTS persos(
    `type` VARCHAR(100),
    `name` VARCHAR(100),
    `id` VARCHAR(100),
    `defense` INT,
    `pv` INT,
    `force` INT
);";

$conn->query($sql);

$getAllPerosRequest = "SELECT * FROM `persos`";
$ALL_PERSOS = $conn->query($getAllPerosRequest);


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <title>Jeu docker php</title>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body class="body-bg">
    <h1 class="main-title">Ultimate Warrior</h1>
    <div class="main-container">
        <div class="left-container">
            <h2 class="secondary-title">Séléctionne ton personnage :</h2>
            <div class="persos-list">
                <?php
                foreach ($ALL_PERSOS as $row) {
                ?>
                    <div class="perso-container">
                        <div class="perso-delete" onclick="document.location = './delete_perso.php?id=<?php echo $row['id']; ?>'">X</div>
                        <div class="perso-row" onclick="document.location = './attack.php?id=<?php echo $row['id']; ?>'">
                            <img src="./images/imagetemp.png" class="perso-icon" />
                            <p class="perso-item perso-name">
                                <?php echo $row['name'] ?>
                            </p>
                            <p class="perso-item">
                                <?php echo $row['type'] ?>
                            </p>
                            <p class="perso-item">
                                pv: <?php echo $row['pv'] ?>
                            </p>
                            <p class="perso-item">
                                force: <?php echo $row['force'] ?>
                            </p>
                            <p class="perso-item">
                                defense: <?php echo $row['defense'] ?>
                            </p>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
        <div class="form-container">
            <form action="create_perso.php" method="post">
                <h2 class="secondary-title">Ou crée ton personnage :</h2>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" aria-label="Text input with dropdown button" placeholder="Le nom de ton personnage" name="perso">
                </div>
                <div class="input-group mb-3 images-container">
                    <div class="form-check select-perso">
                        <img src="./images/magicien.png" class="perso-image" alt="perso magicien" onclick="document.querySelector('#input-type-1').checked = true">
                        <label class="form-check-label" for="exampleRadios1">
                            Magicien
                        </label>
                        <input class="form-check-input" id="input-type-1" type="radio" name="type" id="exampleRadios1" value="magicien" checked>
                    </div>
                    <div class="form-check select-perso">
                        <img src="./images/guerrier.png" class="perso-image" alt="perso guerrier" onclick="document.querySelector('#input-type-2').checked = true">
                        <label class="form-check-label" for="exampleRadios2">
                            Guerrier
                        </label>
                        <input class="form-check-input" id="input-type-2" type="radio" name="type" id="exampleRadios2" value="guerrier">
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div class="form-check">
                        <button class="btn btn-primary button-submit" type="submit">Créer mon personnage</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>