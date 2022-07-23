<?php

namespace Controllers;

class ScoreController
{
    // Met à jour le score de l'utilisateur s'il souhaite rejouer.
    public function updateScoreAndReplay()
    {
        $user_id = $_SESSION['Connection']['id'];
        $game_id = $_GET['id'];
        
        $userModel = new \Models\User();
        
        // Récupère toutes les infos d'un user pour le jeu correspondant à l'id de l'URL.
        $infos = $userModel->getAllInfosByUserId( $user_id, $game_id );
        
        $score = $infos['score_value'];
        $newScore = htmlspecialchars( $_POST['score'] );
        
        if( $newScore > $score )
        {
            $id = $infos['user_infos_id'];
            echo 'Ton score a augmenté, GG !';
            $scoreUserModel = new \Models\Score();
            $scoreUser = $scoreUserModel->insertScore( $newScore, $id, $game_id);
        }
            
            header('Location: index.php?route=play&id='.$game_id);
            exit;
    }
    
    // Met à jour le score de l'utilisateur s'il souhaite quitter.
    public function updateScoreAndQuit()
    {
        $user_id = $_SESSION['Connection']['id'];
        $game_id = $_GET['id'];
        
        $userModel = new \Models\User();
        
        // Récupère toutes les infos d'un user pour le jeu correspondant à l'id de l'URL.
        $infos = $userModel->getAllInfosByUserId( $user_id, $game_id );
        
        $score = $infos['score_value'];
        var_dump( $score );
        
        $newScore = htmlspecialchars( $_POST['score'] );
        var_dump( $newScore );
        
        if( $newScore > $score )
        {
            $id = $infos['user_infos_id'];
            echo 'Ton score a augmenté, GG !';
            $scoreUserModel = new \Models\Score();
            $scoreUser = $scoreUserModel->insertScore( $newScore, $id, $game_id);
        }
        
            header('Location: index.php?route=gamesLobby');
            exit;
    }
}