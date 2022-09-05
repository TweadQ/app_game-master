<?php

require("helpers/functions.php");

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

