<?php
// préparation des constantes de connection à MySQL
define('DB_SERVER', "localhost");
define('DB_USER', "root");
define('DB_MDP', "");
define('DB_NAME', "prepatestjuin");

// Constante contenant la racine du site
define("CHEMIN_RACINE","http://localhost/php/prepa-test-juin/");

// nom des dossiers de destination des images par rapport à la racine du site (chemin relatif due to move_uploaded_file cf fct)
$dossier_ori = "images/originales/"; // dossier des originales
$dossier_gd = "images/affichees/"; // dossier des grandes images à afficher
$dossier_mini = "images/miniatures/"; // dossier des miniatures

// taille des images d'affichage proportionnelle en px 
$grande_large = 850; //taille max en largeur
$grande_haute = 700; //taille max en hauteur

// taille des miniatures des images d'affichage 'croppée', coupées et centrées en px
$mini_large = 100; //taille max en largeur
$mini_haute = 120; //taille max en hauteur

// qualité de l'image d'affichage
$grande_qualite = 80; //0 à 100

// qualité de la miniature
$mini_qualite = 60; //0 à 100

// formats acceptés en miniuscule stocker dans un tableau, séparé par des virgules
$formats_acceptes = array('jpg', 'jpeg', 'png');
