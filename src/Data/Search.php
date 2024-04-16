<?php

namespace  App\Data;

class Search
{

    public $page = 1;
    public $q = ' ';



    public function __toString() {
        // Retournez la représentation en chaîne de caractères de votre objet ici
        return $this->q; // Remplacez par la propriété que vous souhaitez afficher
    }

}