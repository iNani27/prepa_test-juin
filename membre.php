<?php
session_start();
require_once 'config.php';
require_once 'connect.php';
require_once 'fonction.php';
// si on est pas/plus connecté
if (!isset($_SESSION['sid']) || $_SESSION['sid'] != session_id()) {
    header("Location: deconnect.php");
}
// si on a envoyé le formulaire et qu'un fichier est bien attaché
if (isset($_POST['letitre']) && isset($_FILES['lefichier'])) {
    // traitement des chaines de caractères
    $letitre = traite_chaine($_POST['letitre']);
    $ladesc = traite_chaine($_POST['ladesc']);
    // récupération des paramètres du fichier uploadé
    $limage = $_FILES['lefichier'];
    // appel de la fonction d'envoi de l'image, le résultat de la fonction est mise dans la variable $upload
    $upload = upload_originales($limage,$dossier_ori,$formats_acceptes);
    // si $upload n'est pas un tableau c'est qu'on a une erreur
    if (!is_array($upload)) {
        // on affiche l'erreur
        echo $upload;
        // si on a pas d'erreur, on va insérer dasn la DB et créer sa miniature et sa grande image
    } else {
        var_dump($upload);
       
    }
}
?>
<!DOCTYPE html>
<!--
20150617 @iNani
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title><?= $_SESSION['lelogin']; ?> - Votre Espace membre</title>
    </head>
    <body>
        <div id="content">
            <div id="haut"><h1>Espace membre de <a href='./'>photos.be</a></h1></div>
            <div id="connect">
                <?php
                //Texte d'accueil
                echo "<h3>Bonjour " . $_SESSION['lenom'] . "</h3>";
                echo "<p>Vous êtes connecté en tant que <span title='" . $SESSION['ladesc'] . "'>" . $SESSION['nom_perm'] . "</span></p>";
                echo "<h5><a href='deconnect.php'>Déconnexion</a></h5>";
                // liens selon perm
                switch ($_SESSION["laperm"]) {
                    // admin
                    case 0:
                        echo "<a href='admin.php'>Administrer le site</a>";
                        echo "<a href='membre.php'>Espace membres</a>";
                        break;
                    // modérateur
                    case 1:
                        echo "<a href='moder.php'>Modérer le site</a>";
                        echo "<a href='membre.php'>Espace membres</a>";
                        break;
                    // utilisateur
                    default:
                        echo "<a href='membre.php'>Espace membres</a>";
                }
                ?>
            </div>
            <div id="milieu">
                <div id="formulaire">
                    <form action="" enctype="multipart/form-data" method="POST" name="onposte">
                        <input type="text" name="letitre" required /><br/>
                       <!-- <input type="hidden" name="MAX_FILE_SIZE" value="50000000" /> -->
                        <input type="file" name="lefichier" required /><br/>
                        <textarea name="ladesc"></textarea><br/>
                        <input type="submit" value="Envoyer le fichier" /><br/>
                    </form>
                </div>
                <div id='lesphotos'>

                </div>
            </div>
            <div id="bas"></div>
        </div>
    </body>
</html>
