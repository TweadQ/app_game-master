<?php

namespace Controllers;

require_once("models/Users.php");

class User
{
    private $model;

    public function __construct()
    {
        $this->model = new \Models\User();
    }

    public function index()
    {
        $title = "Accueil"; //title for current page

        require_once("models/users.php");

        $users = $this->model->getAllGames("pseudo");
        /**
         * Show view
         */
        require("view/usersPage.php");
    }

    public function show()
    {
        $title = "Show"; //title for current page

        $user = $this->model->getGame();

        $title = $user['name'];

        require("view/showUserPage.php");
    }

    public function create()
    {

        $title = "Add Game"; //title for current page

        $error = [];
        $errorMessage = "<span class=text-red-500>*Ce champs est obligatoire</span>";

        // 1-je verifie si le formulaire est soumis
        if (!empty($_POST["submited"])) {
            require_once("utils/security-form/include.php");
            if(count($error) == 0) 
            {
                $this->model->create($name, $price, $note, $description, $genre_clear, $plateforms_clear, $PEGI, $url_img);
            }
        }

        require("view/addGamePage.php");
    }

    public function update()
    {
        $title = "modifier"; //title for current page


        $game = $this->model->getGame();

        $error = [];

        $errorMessage = "<span class=text-red-500>*Ce champs est obligatoire</span>";

        if (!empty($_POST["submited"])) 
        {
            require_once("utils/security-form/include.php");
            if(count($error) == 0) 
            {
                $this->model->update($name, $price, $note, $description, $genre_clear, $plateforms_clear, $PEGI, $url_img);
            }
        }

        require("view/updatePage.php");
    }

    public function delete()
    {
        $this->model->delete();
    }
}