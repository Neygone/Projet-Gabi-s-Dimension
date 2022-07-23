<?php

namespace Models;

class Game extends Database
{
    // Récupère TOUTES les infos d'un jeu par son ID.
    public function getOneGameById( $id )
    {
        $query = $this->getDb()->prepare( " SELECT *
                                            FROM games 
                                            WHERE games.id = ? " );
                                            
        $query->execute( array( $id ) );
        return $query->fetch();
    }
    
    // Récupère TOUTES les infos de TOUS les jeux.
    public function getAllGames()
    {
        $query = $this->getDb()->prepare( " SELECT *
                                            FROM games
                                            ORDER BY games.id ASC " );
                                            
        $query->execute();
        return $query->fetchAll();
    }
}