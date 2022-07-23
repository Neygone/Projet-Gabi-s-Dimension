<?php

namespace Models;

class Session extends Database
{
    // Ajouter l'utilisateur dans la table users.
    public function addNewSession( $username, $email, $password )
    {
        $query = $this->getDb()->prepare( " INSERT INTO users ( username, email, password, roles )
                                            VALUES ( ?, ?, ?, 'Player' ) " );
                                            
        $query->execute( array( $username, $email, $password ));
        return $query->fetch();
    }
    
    // Vérifier si l'utilisateur existe dans la bdd.
    public function userSessionVerification( $username, $email ) 
    {
        $query = $this->getDb()->prepare( " SELECT username, email
                                            FROM users
                                            WHERE username = ?
                                            OR email = ? " );
        
        $query->execute( array( $username, $email ) );
        return $query->fetchAll();
    }
    
    // Récupère TOUTES les informations correspondant à l'email de l'utilisateur.
    public function getUserSession( $email )
    {
        $query = $this->getDb()->prepare( " SELECT *
                                            FROM users
                                            WHERE users.email = ? " );
                                            
        $query->execute( array( $email ));
        return $query->fetch();
    }
    
    // Détruit la session de l'utilisateur en cours.
    public function deconnexion()
    {
        session_dextroy();
        header('location:index.php?route=home');
        exit;
    }
}