<?php

namespace Controllers;

require_once("models/Game.php");

class Game
{
    private $model;

    public function __construct()
    {
        $this->model = new \Models\Game();
    }

    public function index()
    {
        require_once("models/Game.php");
        $model = new \Models\Game();
        $games = $this->model->getAllGames();

        require("view/Homepage.php");
    }

    public function show()
    {
        $title = "Show"; //title for current page
        require_once("models/Game.php");

        $model = new \Models\Game();
        $game = $this->model->getGame();

        $title = $game['name'];
        /**
         * Show view
         */
        require("view/ShowPage.php");
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