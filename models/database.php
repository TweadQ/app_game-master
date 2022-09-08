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

function update($name, $price, $note, $description, $genre_clear, $plateforms_clear, $PEGI, $url_img)
{
    require_once("utils/security-form/include.php");
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


