<?php
// Inscription

function createUser($array)
{
    echo "--------------- SIGNUP ------------ <br/>";
    echo '$array : ' . print_r($array, true);

    require($GLOBALS['rootPath'] . '/src/config/config.php');

    $query = "INSERT INTO utilisateur (prenom, nom, designation, email, motDePasse, roles) VALUES (:prenom, :nom, :designation, :email, :motDePasse, :roles)";

    try {
        $stmt = $db->prepare($query);

        $hashedPassword = password_hash($array['motDePasse'], PASSWORD_DEFAULT);

        $stmt->bindParam(':motDePasse', $hashedPassword);
        $stmt->bindParam(':email', $array['email']);
        $stmt->bindParam(':prenom', $array['prenom']);
        $stmt->bindParam(':nom', $array['nom']);
        $stmt->bindParam(':designation', $array['designation']);
        $stmt->bindParam(':roles', $array['roles']);

        $stmt->execute();

        echo " Insertion réussie ; STMT :" . print_r($stmt, true);

        return true;
    } catch (PDOException $e) {
        echo "Erreur SQL lors de l'insertion : " . $e->getMessage();
        return false;
    }
}


function getUserByEmail($email)
{
    $table = "utilisateur";
    $options = [
        'email' => [
            'email' => $email
        ]
    ];
    $statement = select($table, $options);
    return $statement->fetch();
}
