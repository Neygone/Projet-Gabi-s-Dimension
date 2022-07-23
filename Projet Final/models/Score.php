<?php

namespace Models;

class Score extends Database
{
    // Récupère le score et le user pour chaque jeu
    // public function getScoreByGameId( $game_id )
    // {
    //     $query = $this->getDb()->prepare( " SELECT scores.game_id, scores.user_infos_id, scores                                             .score_value
    //                                         FROM scores 
    //                                         INNER JOIN games
    //                                         ON scores.game_id = games.id 
    //                                         WHERE games.id = ? " );
    //     $query->execute(array( $game_id ));
    //     return $query->fetch();
    // }
    
    // Insère le score de l'utilisateur dans la table scores.
    public function insertScore( $newScore, $id, $game_id )
    {
        $query = $this->getDb()->prepare( " UPDATE scores
                                            INNER JOIN users_infos
                                            ON scores.user_infos_id = users_infos.id
                                            INNER JOIN users
                                            ON users_infos.user_id = users.id
                                            SET scores.score_value = ?
                                            WHERE scores.user_infos_id = ? 
                                            AND scores.game_id = ? " );
        $query->execute(array ( $newScore, $id, $game_id ));
        return $query->fetch();
    }
    
    // Vérifie si un utilisateur à déjà jouer à un jeu par son ID.
    public function userVerificationInScoresTable( $user_id, $game_id )
    {
        $query = $this->getDb()->prepare( " SELECT scores.user_infos_id, scores.game_id
                                            FROM scores
                                            INNER JOIN users_infos
                                            ON scores.user_infos_id = users_infos.id 
                                            INNER JOIN users
                                            ON users_infos.user_id = users.id
                                            WHERE scores.user_infos_id = ? 
                                            AND scores.game_id = ? " );
        $query->execute(array( $user_id, $game_id ));
        return $query->fetchAll();
    }
    
    // Insère l'utilisateur dans la table scores s'il n'a jamais jouer à un jeu par son ID.
    public function addUserInScoresTable( $user_id, $game_id )
    {
        $query = $this->getDb()->prepare( " INSERT INTO scores ( scores.user_infos_id, scores.game_id )
                                            VALUES (?, ?) " );
        $query->execute(array( $user_id, $game_id ));
        return $query->fetch();
    }
    
    // Récupère TOUTES les positions de TOUS les utilisateurs par l'ID d'un jeu.
    public function positions()
    {
        $query = $this->getDb()->prepare( " SELECT *
                                            FROM users
                                            INNER JOIN users_infos
                                            ON users.id = users_infos.user_id
                                            INNER JOIN scores
                                            ON users_infos.id = scores.user_infos_id
                                            INNER JOIN games
                                            ON scores.game_id = games.id
                                            ORDER BY scores.score_value DESC " );
        $query->execute();
        return $query->fetchAll();
    }
}