<?php

function getUsers($option = NULL, $rowsPerPage = -1)
{
    $table = "utilisateur";
    if (isset($option)) $statement = select($table, $option, $rowsPerPage);
    else $statement = select($table, $option, $rowsPerPage);

    $users = [];

    while ($row = $statement->fetch()) {
        $roles = json_decode($row['roles'], true);
        if (!is_array($roles)) {
            $roles = [];
        }
        $user = [
            'idUtilisateur' => $row['idUtilisateur'],
            'nom' => $row['nom'],
            'prenom' => $row['prenom'],
            'email' => $row['email'],
            'designation' => $row['designation'],
            // 'motDePasse' => $row['motDePasse'],
            // 'roles' => $row['roles'],
            'roles' => $roles,
        ];
        $users[] = $user; //Rajoute l'user au tableau users
    }
    return $users;
}

function getOrganizers()
{
    $table = "utilisateur";
    $option = ' WHERE JSON_CONTAINS(roles, \'\"Organisateur\"\') AND designation IS NOT NULL';
    $statement = select($table, $option);

    $users = [];

    while ($row = $statement->fetch()) {
        $user = [
            'idUtilisateur' => $row['idUtilisateur'],
            'nom' => $row['nom'],
            'prenom' => $row['prenom'],
            'email' => $row['email'],
            'designation' => $row['designation'],
            'roles' => json_decode($row['roles'], true)
        ];
        $users[] = $user;
    }

    return $users;
}



function getUser($pseudo)
{
    global $db;
    $rootPath = $_SERVER['DOCUMENT_ROOT'] . '/ProjetEvenements';
    $query = "SELECT * FROM Utilisateur WHERE pseudo=:pseudo";
    $stmt = $db->prepare($query);
    $stmt->bindParam('pseudo', $pseudo, PDO::PARAM_STR);
    $stmt->execute();

    $row = $stmt->fetch();

    $infos_util = [
        'idUtilisateur' => $row['idUtilisateur'],
        'pseudo' => $row['pseudo'],
        'motDePasse' => $row['motDePasse'],
        'email' => $row['email'],
        'prenom' => $row['prenom'],
        'nom' => $row['nom'],
        'roles' => $row['roles'],

    ];

    if ($stmt != false) {
        return $infos_util;
    } else {
        echo "Erreur dans la récupération des infos de l'utilisateur : " . $db->error;
        return false;
    }
}

//getSortiesUtil
function getEventsOfUser($idUtilisateur)
{

    global $db;
    $events = [];

    $sql = "SELECT 
    u.idUtilisateur,
    e.idEvenement, 
    e.titre, 
    e.description, 
    e.dateEvenement, 
    e.nbPlaces, 
    e.image, 
    e.actif, 
    l.nomLieu, 
    orga.nom,
    orga.prenom,
    orga.email,
    orga.designation,  
    COUNT(i.idUtilisateur) AS nbInscrits
FROM 
    evenement e
JOIN 
    lieu l ON e.idLieu = l.idLieu
JOIN 
    utilisateur orga ON e.idUtilisateur = orga.idUtilisateur
LEFT JOIN 
    inscrire i ON e.idEvenement = i.idEvenement
WHERE 
    e.idUtilisateur = :idUtilisateur
GROUP BY 
    e.idEvenement, l.nomLieu, orga.nom, orga.prenom, orga.email, orga.designation;";


    $stmt = $db->prepare($sql);
    $stmt->bindParam(':idUtilisateur', $_SESSION['idUtilisateur'], PDO::PARAM_INT);

    try {
        while ($row = $stmt->fetch()) {
            $participants = getEnrolled($row['idEvenement']);

            $event = [
                'idEvenement' => $row['idEvenement'],
                'titre' => $row['titre'],
                'dateEvenement' => $row['dateEvenement'],
                'description' => $row['description'],
                'image' => $row['image'],
                'actif' => $row['actif'],
                'nbInscrits' => $row['nbInscrits'],
                'nbPlaces' => $participants['nbPlaces'],
                'idUtilisateur' => $row['idUtilisateur'],
                'pseudo' => $row['pseudo'],
                'nom' => $row['nom'],
                'prenom' => $row['prenom'],
                'designation' => $row['designation'],
                'email' => $row['email'],
                'idLieu' => $row['idLieu'],
                'nomLieu' => $row['nomLieu'],

            ];
            $events[] = $event;
        }
    } catch (PDOException $e) {
        echo "La récupération des évenements de l'utilisateur $idUtilisateur n'a pas abouti : " . $e->getMessage();
        return $stmt;
    }
    echo "Récupération des évènements organisés par l'utilisateur $idUtilisateur effectuée avec succès";
    return $events;
}


function updateRole($idUtilisateur, $newRoles)
{
    global $db;

    $newRoles = array_intersect($newRoles, ['Administrateur', 'Utilisateur', 'Organisateur']);

    $rolesJson = json_encode($newRoles);

    try {
        $sql = "UPDATE utilisateur SET roles = :roles WHERE idUtilisateur = :idUtilisateur";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':idUtilisateur', $idUtilisateur, PDO::PARAM_INT);
        $stmt->bindParam(':roles', $rolesJson, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->rowCount();
    } catch (PDOException $e) {
        echo "Error updating roles: " . $e->getMessage();
        return false;
    }
}
