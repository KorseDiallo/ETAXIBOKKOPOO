<?php 
class Utilisateur {
    private $email;
    private $motDePasse;
    private $prenom;
    private $nom;
    private $telephone;

    public function __construct($email, $motDePasse, $prenom, $nom, $telephone) {
        $this->setEmail($email);
        $this->setPass($motDePasse);
        $this->setNom($nom);
        $this->setPrenom($prenom);
        $this->setTelephone($telephone);
       
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function getPrenom()
    {
        return $this->prenom;
    }

    public function getTelephone()
    {
        return $this->telephone;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPass()
    {
        return $this->motDePasse;
    }

    public function setNom($newNom)
    {
        if (empty($newNom) || !preg_match("/^[a-zA-Z]+$/", $newNom)) {
            throw new Exception("Donner un nom correct svp");
        } else {
            $this->nom = $newNom;
        }
    }

    public function setPrenom($newPrenom)
    {
        if (empty($newPrenom) || !preg_match("/^[a-zA-Z ]+$/", $newPrenom)) {
            throw new Exception("Donner un prénom correct svp");
        } else {
            $this->prenom = $newPrenom;
        }
    }

    public function setTelephone($newTelephone)
    {
        if (empty($newTelephone) || !preg_match("/^[0-9]+$/", $newTelephone) || substr($newTelephone, 0, 1) != 7 || strlen($newTelephone) != 9) {
            throw new Exception("Donner un numéro de téléphone correct");
        } else {
            $this->telephone = $newTelephone;
        }
    }


    public function setEmail($newEmail)
    {
        if (empty($newEmail) || !preg_match("/^[a-zA-Z0-9]+@[a-zA-Z]+\.[a-zA-Z]{2,5}$/", $newEmail)) {
            throw new Exception("Donner un email correct");
        } else {
            $this->email = $newEmail;
        }
    }


    public function setPass($newPass)
    {
        if (empty($newPass) || strlen($newPass) !=  8) {
            throw new Exception("Donner un mot de passe de 8 caractères");
        } else {
            $passcrypt = md5($newPass);
            $this->motDePasse = $passcrypt;
        }
    }


    public function enregistrerUtilisateur(PDO $conn) {
        $sqlQuery = 'INSERT INTO utilisateur (email, mot_de_passe, prenom, nom, telephone) VALUES (:email, :mot_de_passe, :prenom, :nom, :telephone)';
        $insertUser = $conn->prepare($sqlQuery);

        $insertUser->execute([
            'email' => $this->email,
            'mot_de_passe' => $this->motDePasse,
            'prenom' => $this->prenom,
            'nom' => $this->nom,
            'telephone' => $this->telephone
        ]);

        echo "Inscription réussie";
    }

    public static function verifierConnexion(PDO $conn, $email, $motDePasse) {
        $sqlQuery = 'SELECT * FROM utilisateur WHERE email=:email AND mot_de_passe=:mot_de_passe';
        $selectUser = $conn->prepare($sqlQuery);
        $selectUser->execute([
            "email" => $email,
            "mot_de_passe" => $motDePasse
        ]);

        if ($selectUser->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
}
