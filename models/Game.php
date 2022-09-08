<?php

require ("database.php");

class Game
{
    /** 
    * This function return all games in array
    *
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
        $id = $this->getId();
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
}