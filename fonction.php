<?php

require_once 'config.php';
/*
 * Fonction d'upload de l'image d'origine, renvoie un tableau si réussie sinon renvoie une chaine de caractère contenant l'erreur
 * Utilisation upload_originales("$_FILE","url du dossier","extentions permises (array)")
 */

function traite_chaine($chaine) {
    $sortie = htmlentities(strip_tags(trim($chaine)), ENT_QUOTES);
    return $sortie;
}

function upload_originales($fichier, $destination, $ext) {
    $sortie = array();
    // récupération du nom d'origine
    $nom_origine = $fichier['name'];
    // récupération de l'extension du fichier mise en minuscule et sans le .
    $extension_origine = substr(strtolower(strrchr($nom_origine, '.')), 1);
    // si l'extension ne se trouve pas (!) dans le tableau contenant les extensions autorisées
    if (!in_array($extension_origine, $ext)) {
        // envoi d'une erreur et arrêt de la fonction
        return "Erreur : Extension non autorisée";
    }
    // si l'extension est valide mais de type jpeg
    if ($extension_origine === "jpeg")
        $extension_origine = "jpg";
    // création du nom final sans extension (appel de la fonction chaine_hasard, pour la chaine de caractère aléatoire)
    $nom_final = chaine_hasard(25);
    // on a besoin du nom final dans le tableau $sortie si la fonction réussit
    $sortie['nom'] = $nom_final;
    $sortie['extension'] = $extension_origine;
    // on déplace l'image du dossier temporaire vers le dossier 'originales' avec le nom de fichier complet
    if (@move_uploaded_file($fichier['tmp_name'], $destination . $nom_final . "." . $extension_origine)) {
        return $sortie;
        // si erreur
    } else {
        return "Erreur lors de l'upload d'image";
    }
}

/*
 * 
 * renvoie une chaine au hasard de longueur égale au nombre passé en paramètre
 * appel => chaine_hasard(int);
 * 
 */

function chaine_hasard($nombre_caracteres) {
    $caracteres = "a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,0,1,2,3,4,5,6,7,8,9";
    $tableau = explode(",", $caracteres);
    $nb_element_tab = count($tableau);
    $sortie = "";
    for ($i = 0; $i < $nombre_caracteres; $i++) {
        $hasard = mt_rand(0, $nb_element_tab - 1);
        $sortie .= $tableau[$hasard];
    }
    return $sortie;
}

/*
 * 
 * Fonction qui crée les images en .jpg proportionnelles et avec centrage avec comme paramètres:
 * creation_img("chemin vers l'originales",
 *  "nom complet du fichier original sans extention",
 *  "extension de l'originale",
 *  "dossier de destination",
 *  "largeur en pixel maximum de l'image",
 *  "hauteur maximale en pixel de l'image",
 *  "Qualitée jpeg de 0 à 100");
 * "Proportion TRUE par defaut , garde les proportions, mettre en FALSE si on souhaite centrer l'image et la couper
 * 
 */

function creation_img($chemin_org, $nom, $extension, $destination, $largeur_max, $hauteur_max, $qualite, $proportion = true) {
    // chemin + nom + point + extension de l'image à traitée
    $chemin_image = $chemin_org . $nom . '.' . $extension;
    // récupération des paramètres de l'images
    $param_image = getimagesize($chemin_image);
    // récupération de la largeur et de la hauteur d'origine en pixel
    $largeur_org = $param_image[0];
    $hauteur_org = $param_image[1];
    // calcul du ratio largeur originale avec la largeur maximale
    $ratio_l = $largeur_org / $largeur_max;
    // calcul du ratio hauteur originale avec la heuteur maximale
    $ratio_h = $hauteur_org / $hauteur_max;
    // on vérifie si un ratio est plus grand que l'autre (L > H)
    if ($ratio_l > $ratio_h) {
    // si la largeur originale est plus petite que largeur maximale on va garder la taille d'origine en Largeur mais aussi en hauteur!
        if ($ratio_l < 1) {
            $largeur_dest = $largeur_org;
            $hauteur_dest = $hauteur_org;
        } else {
            // on donne la largeur maximale comme référence
            $largeur_dest = $largeur_max;
            // on calcule la hauteur grâce à son ratio
            $hauteur_dest = round($hauteur_org / $ratio_h);
        }
        // sinon (le ratio hauteur est plus grand ou égale au ratio largeur)   
    } else {
        // si la hauteur originale est plus petite que hauteur maximale on va garder la taille d'origine en hauteur mais aussi en largeur!
        if ($ratio_h < 1) {
            $largeur_dest = $largeur_org;
            $hauteur_dest = $hauteur_org;
        } else {
            // on calcule la largeur grâce à son ratio
            $largeur_dest = round($largeur_org / $ratio_l);
            // on donne la hauteur maximale comme référence
            $hauteur_dest = $hauteur_max;
        }
    }
    // création d'une image vide aux bonnes dimensions dans laquelle ou colera l'image d'origine 
    $nouvelle_image = imagecreatetruecolor($largeur_dest, $hauteur_dest);
    switch ($extension) {
        case '.jpg':
            $image_finale = imagecreatefromjpeg($chemin_image);
            // copie de l'image d'origine vers l'image finale
            imagecopyresampled($nouvelle_image, $image_finale, 0, 0, 0, 0, $largeur_dest, $hauteur_dest, $largeur_org, $hauteur_org);
            // création de l'image finale en .jpg dans le dossier de destination avec la qualité passée en paramètre
            imagejpeg($nouvelle_image, $destination . $nom, $qualite);
            break;
        case '.png':
            $image_finale = imagecreatefrompng($chemin_image);
            // copie de l'image d'origine vers l'image finale
            imagecopyresampled($nouvelle_image, $image_finale, 0, 0, 0, 0, $largeur_dest, $hauteur_dest, $largeur_org, $hauteur_org);
            // création de l'image finale en .png dans le dossier de destination (rem: la transparance n'est pas gardée)
            imagepng($nouvelle_image, $destination . $nom);
            break;
        default:
            return false;
    }
    return true;
}
