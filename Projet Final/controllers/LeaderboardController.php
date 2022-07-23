<?php

namespace Controllers;

class LeaderboardController
{
    // Affiche le classement de TOUS les jeux.
    public function displayLeaderboard()
    {
        $gamesModel = new \Models\Game();
        $games = $gamesModel->getAllGames();

        if( !empty( $_POST ) )
        {
            $userModel = new \Models\User();
            $user = $userModel->getAllInfosByUsername( $_POST['search'] );
            
            if( $user != [] )
            {
                header('Location: index.php?route=userProfile&id='.$user['user_id']);
                exit;
            }
            
            else
            {
                header('Location: index.php?route=leaderboard');
                exit;
            }
        }
        
        $ranksModel = new \Models\Rank();
        $ranks = $ranksModel->getAllRanks();

        $grandMaster = $ranks[0]['name'];
        $master = $ranks[1]['name'];
        $miniMaster = $ranks[2]['name'];
        $diamant = $ranks[3]['name'];
        $emeraude = $ranks[4]['name'];
        $platine = $ranks[5]['name'];
        $or = $ranks[6]['name'];
        $argent = $ranks[7]['name'];
        $bronze = $ranks[8]['name'];
        $pierre = $ranks[9]['name'];
        
        $view = 'leaderboard.phtml';
        include_once 'views/layout.phtml';
    }
    
    // Affiche le classement D'UN jeu.
    public function displayLeaderboardByGame()
    {
        
        
        $id = $_GET['id'];
        
        $usersModel = new \Models\User();
        $users = $usersModel->getUsersByGame( $id );
        
        $gameModel = new \Models\Game();
        $game = $gameModel->getOneGameById( $id );
        
        if( !$game )
        {
            header( 'Location: index.php?route=leaderboard' );
        }
        
        $ranksModel = new \Models\Rank();
        $ranks = $ranksModel->getAllRanks();

        $grandMaster = $ranks[0]['name'];
        $master = $ranks[1]['name'];
        $miniMaster = $ranks[2]['name'];
        $diamant = $ranks[3]['name'];
        $emeraude = $ranks[4]['name'];
        $platine = $ranks[5]['name'];
        $or = $ranks[6]['name'];
        $argent = $ranks[7]['name'];
        $bronze = $ranks[8]['name'];
        $pierre = $ranks[9]['name'];

        $email = $_SESSION['Connection']['email'];
        $sessionModel = new \Models\Session();
        $session = $sessionModel->getUserSession( $email );
        
        $view = 'completeLeaderboard.phtml';
        include_once 'views/layout.phtml';
    }
}