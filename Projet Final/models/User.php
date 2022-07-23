<?php

namespace Models;

class User extends Database
{
    // Récupère TOUTES les infos de TOUS les utilisateurs par l'ID d'un jeu.
    public function getUsersByGame( $id )
    {
        $query = $this->getDb()->prepare( " SELECT *
                                            FROM users
                                            INNER JOIN users_infos
                                            ON users.id = users_infos.user_id
                                            INNER JOIN scores
                                            ON users_infos.id = scores.user_infos_id
                                            INNER JOIN games
                                            ON scores.game_id = games.id
                                            WHERE games.id = ?
                                            ORDER BY scores.score_value DESC " );
        $query->execute(array( $id ));
        return $query->fetchAll();
    }
    
    // Insère l'ID de l'utilisateur dans la table users_infos.
    public function addUserInfos( $idUser )
    {
        $query = $this->getDb()->prepare( " INSERT INTO users_infos( user_id )
                                            VALUES ( ? ) " );
        $query->execute(array( $idUser ));
        return $query->fetch();
    }
    
    // Récupère TOUTES les infos de l'utilisateur par l'ID d'un jeu.
    public function getAllInfosByUserId( $id, $idGame )
    {
        $query = $this->getDb()->prepare( " SELECT *
                                            FROM users
                                            INNER JOIN users_infos
                                            ON users.id = users_infos.user_id
                                            INNER JOIN scores
                                            ON users_infos.id = scores.user_infos_id
                                            INNER JOIN games
                                            ON scores.game_id = games.id
                                            WHERE users.id = ?
                                            AND games.id = ? " );
                                            
        $query->execute( array( $id, $idGame ));
        return $query->fetch();
    }
    
    // Récupère TOUTES les infos d'un utilisateur par son username.
    public function getAllInfosByUsername( $username )
    {
        $query = $this->getDb()->prepare( " SELECT *
                                            FROM users
                                            INNER JOIN users_infos
                                            ON users.id = users_infos.user_id
                                            WHERE users.username = ? " );
                                            
        $query->execute( array( $username ));
        return $query->fetch();
    }
    
    // Récupère l'ID de la table users_infos de l'utilisateur connecté.
    public function getUserInfos( $id )
    {
        $query = $this->getDb()->prepare( " SELECT users_infos.id as infosId,
                                            users_infos.user_id
                                            FROM users_infos
                                            INNER JOIN users
                                            ON users_infos.user_id = users.id
                                            WHERE users.id = ? " );
        $query->execute( array( $id ));
        return $query->fetch();
    }
    
    // Récupère TOUTES les infos de l'utilisateur connecté.
    public function getMyProfileInfos( $id )
    {
        $query = $this->getDb()->prepare( " SELECT *
                                            FROM users
                                            INNER JOIN users_infos
                                            ON users.id = users_infos.user_id
                                            INNER JOIN scores
                                            ON users_infos.id = scores.user_infos_id
                                            INNER JOIN games
                                            ON scores.game_id = games.id
                                            WHERE users.id = ? " );
        $query->execute(array( $id ));
        return $query->fetchAll();
    }
    
    // Récupère l'ID, le username et la date d'enregistrement de l'utilisateur par son ID.
    public function getProfileInfos( $id )
    {
        $query = $this->getDb()->prepare( " SELECT users.id, users.username, users.registration_date
                                            FROM users
                                            WHERE users.id = ? " );
        $query->execute(array( $id ));
        return $query->fetch();
    }
}