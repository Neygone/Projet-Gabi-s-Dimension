<?php

namespace Controllers;

class UserController
{
    // Affiche le profil de l'utilisateur connecté.
    public function displayMyProfile()
    {
        $email = $_SESSION['Connection']['email'];
        $id = $_SESSION['Connection']['id'];
        
        $infosModel = new \Models\User();
        $infos = $infosModel->getMyProfileInfos( $id );
        
        $scoreModel = new \Models\Score();
        $positions = $scoreModel->positions();
        
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
        
        $view = 'profile.phtml';
        include_once 'views/layout.phtml';
    }
    
    // Affiche le profil d'un autre utilisateur.
    public function displayUserProfile()
    {
        if( isset($_GET['id']))
        {
            $id = $_GET['id'];
            
            $infoModel = new \Models\User();
            $info = $infoModel->getProfileInfos( $id );
            
            if( !$info )
            {
                header( 'Location: index.php?route=leaderboard' );
            }
            
            $users = $infoModel->getMyProfileInfos( $id );
            
            $scoreModel = new \Models\Score();
            $positions = $scoreModel->positions();
            
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
        
            $view = 'userProfile.phtml';
            include_once 'views/layout.phtml';
        }
    }
}