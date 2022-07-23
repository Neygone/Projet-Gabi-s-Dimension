<?php

namespace Controllers;

class AdminController
{
    // Affiche la page de l'Admin.
    public function displayAdminPage()
    {
        $gamesModel = new \Models\Game();
        $games = $gamesModel->getAllGames();
        
        $view = 'adminPage.phtml';
        include_once 'views/layout.phtml';
    }
    
    // Affiche le formulaire pour ajouter un jeu.
    public function displayAddGameForm()
    {
        $view = 'addGameForm.phtml';
        include_once 'views/layout.phtml';
    }
    
    // Ajoute un jeu.
    public function addGame()
    {
        if( isset( $_POST['submit'] ))
        {
            if( !empty( $_POST['name'] ) && !empty( $_POST['description'] ) && !empty( $_POST['slogan'] ))
            {
                $gamesModel = new \Models\Admin();
                $games = $gamesModel->addGame( $_POST['name'], $_POST['description'], $_POST['slogan'] );
            }
        }
        
        header( 'Location: index.php?route=adminMode' );
    }
    
    // Affiche le formulaire pour modifier un jeu.
    public function displayEditGameForm()
    {
        $id = $_GET['id'];
        
        $gameModel = new \Models\Game();
        $game = $gameModel->getOneGameById( $id );
        
        $view = 'editGameForm.phtml';
        include_once 'views/layout.phtml';
    }
    
    // Modifie un jeu.
    public function editGame()
    {
        if( isset( $_POST['submit'] ))
        {
            $id = $_GET['id'];
            
            $gamesModel = new \Models\Admin();
            $games = $gamesModel->editGame( $_POST['name'], $_POST['description'], $_POST['slogan'], $id );
        }
        
        header( 'Location: index.php?route=adminMode' );
    }
    
    // Supprime un utilisateur.
    public function deleteUser()
    {
        $id = $_GET['id'];
        
        $userModel = new \Models\Admin();
        $user = $userModel->deleteUser( $id );
        
        header( 'Location: index.php?route=gamesLobby' );
    }
}