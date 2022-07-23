<?php

namespace Controllers;

class HomeController
{
    // Affiche la page d'accueil.
    public function displayHomePage()
    {
        $view = 'home.phtml';
        include_once 'views/home.phtml';
    }
}