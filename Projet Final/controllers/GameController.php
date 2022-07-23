<?php

namespace Controllers;

class GameController
{
    // Affiche le Lobby des jeux.
    public function displayLobbyPage()
    {
        $gamesModel = new \Models\Game();
        $games = $gamesModel->getAllGames();
        
        $view = 'gamesLobby.phtml';
        include_once 'views/layout.phtml';
    }
    
    // Affiche le descriptif d'un jeu.
    public function displayGameDescription()
    {
        $id = $_SESSION['Connection']['id'];
        $game_id = $_GET[ 'id' ];
        
        $userModel = new \Models\User();
        $user = $userModel->getAllInfosByUserId( $id, $game_id );
        
        $gameModel = new \Models\Game();
        $game = $gameModel->getOneGameById( $game_id );
        
        if( !$game )
        {
            header( "Location: index.php?route=gamesLobby" );
            exit;
        }
        
        // $scoreModel = new \Models\Score();
        // $score = $scoreModel->getScoreByGameId( $game_id );
        // var_dump($score);
        
        $view = 'game.phtml';
        include_once 'views/layout.phtml';
    }
    
    // Affiche le jeu.
    public function displayGame()
    {
        
        $game_id = $_GET['id'];
        
        $gameModel = new \Models\Game();
        $game = $gameModel->getOneGameById( $game_id );
        
        if( !$game )
        {
            header( 'Location: index.php?route=gamesLobby' );
        }
        
        $id = $_SESSION['Connection']['id'];
        
        $infosModel = new \Models\User();
        $infos = $infosModel->getUserInfos( $id );

        $user_id = $infos['infosId'];
        
        $verificationModel = new \Models\Score();
        $verification = $verificationModel->userVerificationInScoresTable( $user_id, $game_id );
        
        if( $verification == [] )
        {
            $idUser = $infos['infosId'];
            $addUserModel = new \Models\Score();
            $addUser = $addUserModel->addUserInScoresTable( $idUser, $game_id );
        }
        
        switch( $_GET['id'] )
        {
            case 1:
                $view = 'casseBrique.phtml';
                include_once 'views/layout.phtml';
                break;
                
            case 2:
                $view = 'shooter.phtml';
                include_once 'views/layout.phtml';
                break;
        }
    }
}