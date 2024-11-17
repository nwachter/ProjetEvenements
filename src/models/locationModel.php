<?php

function getLocations($option = NULL)
{
    global $db;
    $rootPath = $_SERVER['DOCUMENT_ROOT'] . '/ProjetEvenements';
    require_once $GLOBALS['rootPath'] . '/src/lib/functions.php';
    $table = "lieu";
    $stmt = NULL;
    $stmt = isset($option)  ?  select($table, $option) : select($table);

    $events = [];

    while ($row = $stmt->fetch()) {
        $event = [
            'idLieu' => $row['idLieu'],
            'nomLieu' => $row['nomLieu'],
        ];
        $events[] = $event;
    }
    return $events;
}

function insertLocation($nomLieu)
{
    global $db;

    $query = "INSERT INTO lieu (nomLieu) VALUES (:nomLieu)";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':nomLieu', $nomLieu, PDO::PARAM_STR);

    if ($stmt->execute()) {
        return $db->lastInsertId();
    } else {
        return false;
    }
}

function updateLocation($idLieu, $nomLieu)
{
    global $db;

    $query = "UPDATE lieu SET nomLieu = :nomLieu WHERE idLieu = :idLieu";

    try {
        $stmt = $db->prepare($query);
        $stmt->bindParam(':nomLieu', $nomLieu, PDO::PARAM_STR);
        $stmt->bindParam(':idLieu', $idLieu, PDO::PARAM_INT);
        $stmt->execute();
        // $result = $stmt->rowCount();
        // echo "Number of rows updated: " . $result;
        return true;
    } catch (PDOException $e) {
        echo "Error updating location: " . $e->getMessage();
        return false;
    }
}
