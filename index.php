<?php
session_start();
require_once 'config.php';
require_once 'connect.php';
require_once 'fonction.php';

// si tentative de connexion, utilisation de la fct traite_chaine('string')
if (isset($_POST['lelogin'])) {
    $lelogin = traite_chaine($_POST['lelogin']);
    $lemdp = traite_chaine($_POST['lemdp']);
    // vérification dans la db
    $sql = "SELECT u.id, u.lemail, u.lenom,
    d.lenom AS nom_perm, d.ladesc, d.laperm
    FROM utilisateur u
    INNER JOIN droit d ON u.droit_id = d.id
    WHERE u.lelogin = '$lelogin' AND u.lemdp = '$lemdp';";
    $req = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));
    $recup_user = mysqli_fetch_assoc($mysqli);

    /*Reprendre ici
     * Si on récupère un utilisateur
     * if($recup_user)
     * 
     * 
     * 
     */
// Si l'utilisateur s'est bien connecté  
    $_SESSION = $recup_user; // transformation des résultats de la requête en variable de session
    $_SESSION['sid'] = session_id(); // récupération de la clef de session
    /*var_dump($_SESSION);*/
    //redirection vers la page d'accueil
    /*header('Location : '.CHEMIN_RACINE."?hahaok");*/
    //Pour éviter les doubles connexion par F5
    header('Location : '.CHEMIN_RACINE);
}
?>
<!DOCTYPE html>
<!--
20150616 @iNani
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Accueil</title>
    </head>
    <body>
        <div id="content">
            <div id="haut"><h1>photos.be</h1></div>
            <div id="connect">
                <?php
                if(!isset($_SESSION['sid']) || $_SESSION['sid']!=session_id()){
                ?>
                <form action="" name="connection" method="post">
                    <input type="text" name="lelogin" required />
                    <input type="password" name="lemdp" required />
                    <input type="submit" value="Connexion" />
                </form>
                <a href="mdp.php">Mot de passe oublié?</a>
                <a href="inscription.php">Inscription</a>
                <?php
                }
                ?>
            </div>
            <div id="milieu"></div>
            <div id="bas"></div>
        </div>
    </body>
</html>
