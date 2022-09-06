<?php

require("utils/helpers/functions.php");

/**
* Get connexion with database
* @return PDO
*/
function getPDO(): PDO /** :PDO est un commentaire */
{
    $serveur = "localhost";
    $dbname = "app_game";
    $login = "root";
    $password = "";

    try {
        $pdo = new PDO("mysql:host=$serveur;dbname=$dbname", $login, $password, array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            // pour ne pas avoir de doublons
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            // pour afficher les erreurs
            PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
        ));
        // affiche message ok connexion
        // echo "connexion établie";
        return $pdo;
    } catch (PDOException $e) {
        echo "Erreur de connexion : " . $e->getMessage();
}
}


/** 
* This function return all games in array
* @return array
*/
function getAllGames(): array
{
    $pdo = getPDO();
    $sql = "SELECT * FROM jeux2 ORDER BY name";
    $query = $pdo->prepare($sql);
    $query->execute();
    $games = $query->fetchAll();
    return $games;
}

/**
 * This function return current ID of item
 */
function getId(): int
{
    //1-verifie id existant et que c'est un int
    if (!empty($_GET['id']) && is_numeric($_GET['id'])) {
        // 2- je nettoie mon id contre xss
        $id = clear_xss($_GET['id']);
    } else {
        $_SESSION["error"] = "URL invalide";
        header("location: index.php");
    }
    return $id;
}

function getName (string $name)
{
    return $name;
}

/**
 * This function return a single game
 * @return array
 */
function getGame(): array
{
    $pdo = getPDO();
    $id = getId();
    // 3- requette (query in english) vers BDD
    $sql = "SELECT * FROM jeux2 WHERE id=:id";
    // 4- préparation de la requette
    $query = $pdo->prepare($sql);
    // 5- securiser la requette contre injection sql
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    // 6- executer la requette vers la BDD
    $query->execute();
    // 7- on stock tout ds une variable
    $game = $query->fetch();

    if (!$game) {
        $_SESSION["error"] = "Ce jeu n'est pas disponible.";
        header("location: index.php");
    }
    return $game;
}

/**
 * This function delete an item
 * @return void
 */
function delete(): void
{
    $pdo = getPDO();
    // 2- recup' id ds url & nettoie
    $id = clear_xss($_GET["id"]);
    // 3- requette vers BDD
    $sql = "DELETE FROM jeux2 WHERE id=?";
    //4- prepare ma requette
    $query = $pdo->prepare($sql);
    // 5- on execute le requette
    $query->execute([$id]);
    //redirect
    $_SESSION["success"] = "Le jeu es bien supprimer.";
    header("location:index.php");
}

function create($name, $price, $note, $description, $genre_clear, $plateforms_clear, $PEGI, $url_img): void
{
    require_once("utils/security-form/include.php");
        $pdo = getPDO();
        //1- ecriture de la requette
        $sql = "INSERT INTO jeux2(name, price, genre, note, plateforms, description, PEGI, created_at, url_img) VALUES(:name, :price, :genre, :note, :plateforms, :description, :PEGI, NOW(), :url_img)";

        // 2- prepare la requette
        $query = $pdo->prepare($sql);

        // 3- on associe chaque requette à sa valeur et protection contre injection SQL
        $query->bindValue(':name', $name, PDO::PARAM_STR);
        $query->bindValue(':price', $price, PDO::PARAM_STMT);
        $query->bindValue(':note', $note, PDO::PARAM_STMT);
        $query->bindValue(':description', $description, PDO::PARAM_STR);
        $query->bindValue(':genre', implode("|", $genre_clear), PDO::PARAM_STR);
        $query->bindValue(':plateforms', implode("|", $plateforms_clear), PDO::PARAM_STR);
        $query->bindValue(':PEGI', $PEGI, PDO::PARAM_STR);
        $query->bindValue(':url_img', $url_img, PDO::PARAM_STR);

        // 4- execution de la requette
        $query->execute();

        // 5- redirection
        $_SESSION["success"] = "le jeu a bien été ajouté";
        header("Location: index.php");
        die;
}

function update($error)
{
    require_once("utils/security-form/include.php");
    if (count($error) == 0) {
    $pdo = getPDO();
    $id = getId();
    $sql = "UPDATE jeux2 SET name = :name, price = :price, genre = :genre, url_img = :url_img, note = :note, plateforms = :plateforms, description = :description, PEGI = :PEGI, updated_at = NOW() WHERE id= :id";

    $query = $pdo->prepare($sql);

    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->bindValue(':name', $name, PDO::PARAM_STR);
    $query->bindValue(':price', $price, PDO::PARAM_STMT);
    $query->bindValue(':note', $note, PDO::PARAM_STMT);
    $query->bindValue(':description', $description, PDO::PARAM_STR);
    $query->bindValue(':genre', implode("|", $genre_clear), PDO::PARAM_STR);
    $query->bindValue(':url_img', $url_img, PDO::PARAM_STR);
    $query->bindValue(':plateforms', implode("|", $plateforms_clear), PDO::PARAM_STR);
    $query->bindValue(':PEGI', $PEGI, PDO::PARAM_STR);

    $query->execute();

    $_SESSION["success"] = "le jeu a bien été modifié";
    header("Location: index.php");
    die;
}
}

