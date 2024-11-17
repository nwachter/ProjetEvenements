<?php

function getEnrollements($option = NULL)
{
    $table = "inscrire";
    if (isset($option)) $statement = select($table, $option);
    else $statement = select($table);

    $enrollments = [];

    while ($row = $statement->fetch()) {
        $enrollment = [
            'idEvenement' => $row['idEvenement'],
            'idUtilisateur' => $row['idUtilisateur'],
            'quantite' => $row['quantite'],
        ];

        $enrollments[] = $enrollment;
    }
}




function getEnrolled($idEvenement = NULL)  //Récupère les inscrits a un évènement ou tous les inscrits a tous les évènements
{

    global $db, $message, $error_message;
    if ($idEvenement == NULL) {
        $query = "SELECT u.nom, u.prenom, u.email, p.idUtilisateur, e.idEvenement, e.titre 
                  FROM utilisateur u 
                  JOIN inscrire p ON (u.idUtilisateur = p.idUtilisateur) 
                  JOIN evenement e ON (e.idEvenement = p.idEvenement) 
                  ORDER BY e.idEvenement";
        $statement = $db->prepare($query);
        $statement->execute();
    } else {
        $query = "SELECT u.nom, u.prenom, u.email, p.idUtilisateur, e.idEvenement, e.titre 
                  FROM utilisateur u 
                  JOIN inscrire p ON (u.idUtilisateur = p.idUtilisateur) 
                  JOIN evenement e ON (e.idEvenement = p.idEvenement) 
                  WHERE e.idEvenement=:idEvenement";
        $statement = $db->prepare($query);
        $statement->execute(['idEvenement' => $idEvenement]);
    }

    $participants = [];

    while ($row = $statement->fetch()) {
        $participant = [
            'idEvenement' => $row['idEvenement'],
            'titre' => $row['titre'],
            'idUtilisateur' => $row['idUtilisateur'],
            'nom' => $row['nom'],
            'prenom' => $row['prenom'],
            'email' => $row['email']
        ];
        $participants[] = $participant;
    }
    return $participants;
}


function checkUserEnrollmentToEvent($idUtilisateur, $idEvenement)
{
    global $db;

    $query = "SELECT * FROM inscrire WHERE idUtilisateur=:idUtilisateur AND idEvenement=:idEvenement";
    try {
        $stmt = $db->prepare($query);
        $stmt->execute(['idUtilisateur' => $idUtilisateur, 'idEvenement' => $idEvenement]);
        $result = $stmt->fetch();
    } catch (PDOException $e) {
        echo "Erreur SQL lors de la connexion : " . $e->getMessage();
        return false;
    }

    if ($result == FALSE) {
        return false;
    } else {
        return true;
    }
}

function joinEvent($idUtilisateur, $idEvenement)
{
    global $db;

    $query = "INSERT INTO inscrire (idUtilisateur, idEvenement) VALUES (:idUtilisateur, :idEvenement)";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':idUtilisateur', $idUtilisateur);
    $stmt->bindParam(':idEvenement', $idEvenement);
    $stmt->execute();
    if ($stmt != FALSE) {
        return true;
    } else {
        return false;
    }
}

function enrollUserToEvent($idUtilisateur, $idEvenement)
{
    global $db;

    $query = "INSERT INTO inscrire (idUtilisateur, idEvenement) VALUES (:idUtilisateur, :idEvenement)";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':idUtilisateur', $idUtilisateur);
    $stmt->bindParam(':idEvenement', $idEvenement);
    $stmt->execute();
    if ($stmt != FALSE) {
        return true;
    } else {
        return false;
    }
}

function unenrollUserToEvent($idUtilisateur, $idEvenement)
{
    global $db;

    $query = "DELETE FROM inscrire WHERE idUtilisateur=:idUtilisateur AND idEvenement=:idEvenement";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':idUtilisateur', $idUtilisateur);
    $stmt->bindParam(':idEvenement', $idEvenement);
    $stmt->execute();
    if ($stmt != FALSE) {
        return true;
    } else {
        return false;
    }
}
