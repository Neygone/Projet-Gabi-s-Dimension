<?php

namespace Controllers;

class SessionController
{
    // Affiche le formulaire d'inscription.
    public function displaySignUpPage()
    {
        if( isset( $_POST['submit'] ))
        {
            $password = $_POST['password'];
            $passwordConfirmation = $_POST['passwordConfirmation'];
        
            $model = new \Models\Session();
            $userVerification = $model->userSessionVerification( $_POST['username'], $_POST['email'] );
        }
       
        $view = 'signUp.phtml';
        include_once 'views/signUp.phtml';
   }
   
   // Affiche le formulaire de connexion.
   public function displayLoginPage()
   {
        if( isset( $_POST['submit'] ))
        {
            $userSessionModel = new \Models\Session();
            $userSession = $userSessionModel->getUserSession( $_POST['email'] );
        }
       
        $view = 'login.phtml';
        include_once 'views/login.phtml';
   }
   
   // Créer un nouveau compte.
   public function newSession()
   {
        // Vérifier si le formulaire a été validé ou non.
        if( isset( $_POST['submit'] ))
        {
            $username = htmlspecialchars( $_POST['username'] );
            $email = htmlspecialchars( $_POST['email'] );
            $password = $_POST['password'];
            $passwordConfirmation = $_POST['passwordConfirmation'];
            
            $model = new \Models\Session();
            $userVerification = $model->userSessionVerification( $_POST['username'], $_POST['email'] );
         
            // Vérifier si l'utilisateur existe dans la bdd.
            if( $userVerification != [] && $password !== $passwordConfirmation )
            {
                header('Location: index.php?route=signUp&error3');
                $_SESSION['EmailUsernameError'] = 'Le username et/ou l\'email est déjà utilisé !';
                $_SESSION['PasswordError'] = 'Les mots de passes ne sont pas identiques !';
            }
            
            elseif( $userVerification != [] )
            {
                header('Location: index.php?route=signUp&error1');
                $_SESSION['EmailUsernameError'] = 'Le username et/ou l\'email est déjà utilisé !';
            }
            
            // Vérifier si les 2 mots de passe rentrés sont identiques.
            elseif( $password !== $passwordConfirmation )
            {
                header('Location: index.php?route=signUp&error2');
                $_SESSION['PasswordError'] = 'Les mots de passes ne sont pas identiques !';
            }
            
            else
            {
                $sessionModel = new \Models\Session();
                $session = $sessionModel->addNewSession( $_POST['username'], $_POST['email'], password_hash( $_POST['password'], PASSWORD_BCRYPT ));
                
                $userSessionModel = new \Models\Session();
                $userSession = $userSessionModel->getUserSession( $_POST['email'] );
                
                
                
                $idUser = $userSession['id'];
                
                $userInfosModel = new \Models\User();
                $userInfos = $userInfosModel->addUserInfos( $idUser );
                
                $_SESSION['NewPlayer'] = $session;
                $_SESSION['Connection'] = $userSession;
                
                unset( $_SESSION['Message'] );
                header( 'Location: index.php?route=gamesLobby&' .$_SESSION['Connection']['username'] );
                exit;
            }
        } 
    }
    
    // Récupère la session de l'utilisateur venant de se connecter.
    public function getSession()
    {
        if( isset( $_POST['submit'] ))
        {
            $userSessionModel = new \Models\Session();
            $userSession = $userSessionModel->getUserSession( $_POST['email'] );
            
            $email = htmlspecialchars( $_POST['email'] );
            $password = htmlspecialchars( $_POST['password'] );
            
            if( empty( $_POST['email'] ) || empty( $_POST['password'] ))
            {
                header( 'Location: index.php?route=login' );
            }
            
            // Vérifier si l'email rentré dans le formulaire existe dans la base de donnée.
            elseif( !$userSession )
            {
                header( 'location: index.php?route=login&error4');
                $_SESSION['EmailError'] = 'Email incorrect !';
            }
            
            else
            {
                // Vérifier si le mot de passe du formulaire et celui de la base de donnée sont identiques.
                if( password_verify( $_POST['password'], $userSession['password'] ))
                {
                    $_SESSION['Connection'] = $userSession;
                    
                    if( $_SESSION['Connection']['roles'] == 'Admin' )
                    {
                        $_SESSION['Admin'] = $userSession;
                    }
                    
                    else
                    {
                        $_SESSION['Player'] = $userSession;
                    }
                    
                    unset($_SESSION['message']);
                    header( 'location:index.php?route=gamesLobby&' .$_SESSION['Connection']['username'] );
                    exit;
                }
                
                else
                {
                    header( 'location: index.php?route=login&error5');
                    $_SESSION['InvalidPassword'] = 'Mauvais mot de passe !';
                }
            }
        }
    }
    
    // Détruit la session de l'utilisateur connecté.
    public function deconnexion()
    {
        session_destroy();
        header( 'Location: index.php?route=home' );
        exit;
    }
}