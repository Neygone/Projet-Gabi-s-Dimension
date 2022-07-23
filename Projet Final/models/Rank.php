<?php

namespace Models;

class Rank extends Database
{
    // Récupère TOUTES les infos de TOUS les ranks.
    public function getAllRanks()
    {
        $query = $this->getDb()->prepare( " SELECT ranks.id, ranks.name
                                            FROM ranks " );
        $query->execute();
        return $query->fetchAll();
    }
}