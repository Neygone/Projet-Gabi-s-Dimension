<?php

namespace Models;

class Admin extends Database
{
    // Ajouter un jeu.
    public function addGame( $name, $description, $slogan )
    {
        $query = $this->getDb()->prepare( " INSERT INTO games
                                            ( games.name, games.description, games.slogan )
                                            VALUES ( ?, ?, ? ) " );
        $query->execute(array( $name, $description, $slogan ));
        return $query->fetch();
    }
    
    // Modifier un jeu.
    public function editGame( $name, $description, $slogan, $id )
    {
        $query = $this->getDb()->prepare( " UPDATE games
                                            SET name = ?,
                                            description = ?,
                                            slogan = ?
                                            WHERE id = ? " );
        $query->execute(array( $name, $description, $slogan, $id ));
    }
    
    // Supprimer un jeu.
    public function deleteUser( $id )
    {
        $query = $this->getDb()->prepare( " DELETE FROM
                                            users
                                            WHERE id = ? " );
        $query->execute(array( $id ));
    }
}