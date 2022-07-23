<?php

namespace Controllers;

class RankController
{
    // Affiche TOUS les ranks de TOUS les utilisateurs pour un jeu.
    public function displayRanks()
    {
        $ranksModel = new \Models\Rank();
        $ranks = $ranksModel->getAllRanks();
        
        $gamesModel = new \Models\Game();
        $games = $gamesModel->getAllGames();
        
        foreach( $games as $game )
        {
            $game_id = $game['id'];
        }
        
        $usersModel = new \Models\User();
        $users = $usersModel->getUsersByGame( $game_id );
    }
}