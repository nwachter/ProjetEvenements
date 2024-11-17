<?php
//Connexion


function signInUser($array)
{
    global $db;

    $query = "SELECT * FROM utilisateur WHERE email=:email";
    try {
        $stmt = $db->prepare($query);
        $stmt->bindParam('email', $array['email']);
        $stmt->execute();

        $infos = $stmt->fetch();

        if ($infos && password_verify($array['motDePasse'], $infos['motDePasse'])) {
            echo "Mot de passe valide";
            $rolesJson = $infos['roles'];
            $rolesArray = json_decode($rolesJson, true); //  2e param : assoc array

            $data = [
                'idUtilisateur' => $infos['idUtilisateur'],
                'prenom' => $infos['prenom'],
                'nom' => $infos['nom'],
                'email' => $infos['email'],
                'roles' => $rolesArray,
            ];

            print_r("Données retour connexion : ");
            print_r($data);

            return $data;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        echo "Erreur SQL lors de la connexion : " . $e->getMessage();
        return false;
    }
}
