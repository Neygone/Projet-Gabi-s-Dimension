<?php

session_start();

spl_autoload_register( function( $class ){
    require_once lcfirst( str_replace( '\\', '/', $class ) ) . '.php';
});

if( array_key_exists( 'route', $_GET ) )
{
    switch( $_GET[ 'route' ] )
    {
        case 'home':
            $controller = new Controllers\HomeController();
            $controller->displayHomePage();
            break;
           
        case 'login':
            $controller = new Controllers\SessionController();
            $controller->displayLoginPage();
            break;
            
        case 'signUp':
            $controller = new Controllers\SessionController();
            $controller->displaySignUpPage();
            break;
        
        case 'newSession':
            $controller = new Controllers\SessionController();
            $controller->newSession();
            break;
            
        case 'getSession':
            $controller = new Controllers\SessionController();
            $controller->getSession();
            break;
            
        case 'deconnexion':
            $controller = new Controllers\SessionController();
            $controller->deconnexion();
            break;
            
        case 'gamesLobby':
            if( $_SESSION['Connection'] )
            {
                $controller = new Controllers\GameController();
                $controller->displayLobbyPage();
                break;
            }
            
            else
            {
                header( 'Location: index.php?route=home' );
            }
        
        case 'leaderboard':
            if( $_SESSION['Connection'] )
            {
                $controller = new Controllers\LeaderboardController();
                $controller->displayLeaderboard();
                break;
            }
            
            else
            {
                header( 'Location: index.php?route=home' );
            }
            
        case 'completeLeaderboard':
            if( $_SESSION['Connection'] )
            {
                $controller = new Controllers\LeaderboardController();
                $controller->displayLeaderboardByGame();
                break;
            }
            
            else
            {
                header( 'Location: index.php?route=home' );
            }
            
        case 'myProfile':
            if( $_SESSION['Connection'] )
            {
                $controller = new Controllers\UserController();
                $controller->displayMyProfile();
                break;
            }
            
            else
            {
                header( 'Location: index.php?route=home' );
            }
            
        case 'adminMode':
            if( $_SESSION['Admin'] )
            {
                $controller = new Controllers\AdminController();
                $controller->displayAdminPage();
                break;
            }
            
            else
            {
                header( 'Location: index.php?route=home' );
            }
            
        case 'userProfile':
            if( $_SESSION['Connection'] )
            {
                $controller = new Controllers\UserController();
                $controller->displayUserProfile();
                break;
            }
            
            else
            {
                header( 'Location: index.php?route=home' );
            }
            
        case 'game':
            if( $_SESSION['Connection'] )
            {
                $controller = new Controllers\GameController();
                $controller->displayGameDescription();
                break;
            }
            
            else
            {
                header( 'Location: index.php?route=home' );
            }
            
        case 'play':
            if( $_SESSION['Connection'] )
            {
                $controller = new Controllers\GameController();
                $controller->displayGame();
                break;
            }
            
            else
            {
                header( 'Location: index.php?route=home' );
            }
            
        case 'updateScoreAndReplay':
            if( $_SESSION['Connection'] )
            {
                $controller = new Controllers\ScoreController();
                $controller->updateScoreAndReplay();
                break;
            }
            
            else
            {
                header( 'Location: index.php?route=home' );
            }
            
        case 'updateScoreAndQuit':
            if( $_SESSION['Connection'] )
            {
                $controller = new Controllers\ScoreController();
                $controller->updateScoreAndQuit();
                break;
            }
            
            else
            {
                header( 'Location: index.php?route=home' );
            }
            
        case 'addGameForm':
            if( $_SESSION['Admin'] )
            {
                $controller = new Controllers\AdminController();
                $controller->displayAddGameForm();
                break;
            }
            
            else
            {
                header( 'Location: index.php?route=home' );
            }
            
        case 'addGame':
            if( $_SESSION['Admin'] )
            {
                $controller = new Controllers\AdminController();
                $controller->addGame();
                break;
            }
            
            else
            {
                header( 'Location: index.php?route=home' );
            }
            
        case 'editGameForm':
            if( $_SESSION['Admin'] )
            {
                $controller = new Controllers\AdminController();
                $controller->displayEditGameForm();
                break;
            }
            
            else
            {
                header( 'Location: index.php?route=home' );
            }
            
        case 'editGame':
            if( $_SESSION['Admin'] )
            {
                $controller = new Controllers\AdminController();
                $controller->editGame();
                break;
            }
            
            else
            {
                header( 'Location: index.php?route=home' );
            }
            
        case 'deleteUser':
            if( $_SESSION['Admin'] )
            {
                $controller = new Controllers\AdminController();
                $controller->deleteUser();
                break;
            }
            
            else
            {
                header( 'Location: index.php?route=home' );
            }
    }
}
else
{
    header( 'Location: index.php?route=home' );
    exit();
}