<?php 
session_start();
require_once('dbConnexion.php');
require_once('utilisateur.php');
// Vérifiez si les données de session existent
if (isset($_SESSION["email"]) && isset($_SESSION["mot_de_passe"])) {
    $email = $_SESSION["email"];
    $motDePasse = $_SESSION["mot_de_passe"];

    if (isset($_POST["inscription"])) {
        if (isset($_POST["prenom"]) && isset($_POST["nom"]) && isset($_POST["telephone"])) {
            $prenom = htmlspecialchars($_POST["prenom"]);
            $nom = htmlspecialchars($_POST["nom"]);
            $telephone = $_POST["telephone"];
        } else {
            echo "Veuillez remplir tous les champs du formulaire d'inscription.";
            die();
        }

        // Vérification des expressions régulières ici

        // Assurez-vous que la connexion à la base de données est établie
        $bdd = new BaseDeDonnees();
        $mysqlClient = $bdd->getConnexion();
        $user = new Utilisateur ($email,$motDePasse,$nom,$prenom,$telephone);
        $user->enregistrerUtilisateur($mysqlClient);
        header("Location:connexion.php");
    } else {
        echo "Les données de session sont invalides. Veuillez vous inscrire à partir du premier formulaire.";
    }
} else {
    echo "Les données de session ne sont pas disponibles. Veuillez vous inscrire à partir du premier formulaire.";
}
?> 
