<?php

function getEvents($option = null)
{
    global $db;
    $rootPath = $_SERVER['DOCUMENT_ROOT'] . '/ProjetEvenements';
    require_once $GLOBALS['rootPath'] . '/src/lib/functions.php';
    $table = "evenement";
    $stmt = null;
    $stmt = isset($option)  ?  select($table, $option) : select($table);

    $events = [];

    while ($row = $stmt->fetch()) {
        $event = [
            'idEvenement' => $row['idEvenement'],
            'titre' => $row['titre'],
            'description' => $row['description'],
            'dateEvenement' => $row['dateEvenement'],
            'nbPlaces' => $row['nbPlaces'],
            // 'nbInscrits' => $row['nbInscrits'],
            'image' => $row['image'],
            'idUtilisateur' => $row['idUtilisateur'],
            'actif' => $row['actif'],

        ];
        $events[] = $event;
    }
    return $events;
}

function getEventsWithEnrolledAmount($option = "", $rowsPerPage = -1, $type = "active")
{
    global $db;
    $events = [];

    // Count total events
    $sqlRowCount = "SELECT COUNT(DISTINCT e.idEvenement) AS nb_evenements
        FROM 
            evenement AS e
        JOIN 
            lieu ON e.idLieu = lieu.idLieu
        LEFT JOIN 
            inscrire ON e.idEvenement = inscrire.idEvenement    
        LEFT JOIN 
            utilisateur AS orga ON orga.idUtilisateur = e.idUtilisateur";

    if (!empty($option)) {
        $sqlRowCount .= " " . $option;
    }

    $stmt = $db->prepare($sqlRowCount);
    $stmt->execute();
    $result = $stmt->fetch();
    $nbEvents = (int) $result['nb_evenements'];

    // $GLOBALS['totalPagesEvents'] = ($rowsPerPage === -1) ? 1 : ceil($nbEvents / $rowsPerPage);
    if ($type == "active") {
        $GLOBALS['totalPagesActiveEvents'] = ($rowsPerPage === -1) ? 1 : ceil($nbEvents / $rowsPerPage);
    } elseif ($type == "inactive") {
        $GLOBALS['totalPagesInactiveEvents'] = ($rowsPerPage === -1) ? 1 : ceil($nbEvents / $rowsPerPage);
    } else {
        $GLOBALS['totalPagesEvents'] = ($rowsPerPage === -1) ? 1 : ceil($nbEvents / $rowsPerPage);
    }

    // Determine the current page (only relevant if $rowsPerPage is not -1)
    if ($rowsPerPage !== -1) {
        switch ($type) {
            case "active":
                $currentPage = isset($_GET['nb_act']) && !empty($_GET['nb_act']) ? (int) strip_tags($_GET['nb_act']) : 1;
                $firstEvent = ($currentPage * $rowsPerPage) - $rowsPerPage;
                break;
            case "inactive":
                $currentPage = isset($_GET['nb_ina']) && !empty($_GET['nb_ina']) ? (int) strip_tags($_GET['nb_ina']) : 1;
                $firstEvent = ($currentPage * $rowsPerPage) - $rowsPerPage;
                break;
            default:
                $currentPage = isset($_GET['nb']) && !empty($_GET['nb']) ? (int) strip_tags($_GET['nb']) : 1;
                $firstEvent = ($currentPage * $rowsPerPage) - $rowsPerPage;
                break;
        }
        // $currentPage = isset($_GET['nb']) && !empty($_GET['nb']) ? (int) strip_tags($_GET['nb']) : 1;
        // $firstEvent = ($currentPage * $rowsPerPage) - $rowsPerPage;
    }

    // Main query with optional LIMIT for pagination
    $sql = "SELECT 
        e.idEvenement, 
        e.titre, 
        e.description, 
        e.dateEvenement, 
        e.nbPlaces, 
        e.image, 
        e.actif, 
        lieu.idLieu, 
        lieu.nomLieu, 
        orga.designation AS designationOrganisateur, 
        orga.email, 
        COUNT(inscrire.idUtilisateur) AS nbInscrits
    FROM 
        evenement AS e
    JOIN 
        lieu ON e.idLieu = lieu.idLieu
    LEFT JOIN 
        inscrire ON e.idEvenement = inscrire.idEvenement    
    LEFT JOIN 
        utilisateur AS orga ON orga.idUtilisateur = e.idUtilisateur";

    if (!empty($option)) {
        $sql .= " " . $option;
    }

    $sql .= " GROUP BY 
        e.idEvenement, 
        e.titre, 
        e.description, 
        e.dateEvenement, 
        e.nbPlaces, 
        e.image, 
        e.actif, 
        lieu.idLieu, 
        lieu.nomLieu, 
        orga.designation, 
        orga.email
        ORDER BY e.dateEvenement DESC";

    // Add LIMIT clause only if $rowsPerPage is not -1
    if ($rowsPerPage !== -1) {
        $sql .= " LIMIT :firstEvent, :rowsPerPage";
    }

    $stmt = $db->prepare($sql);

    // Bind parameters if $rowsPerPage is not -1
    if ($rowsPerPage !== -1) {
        $stmt->bindParam(":firstEvent", $firstEvent, PDO::PARAM_INT);
        $stmt->bindParam(":rowsPerPage", $rowsPerPage, PDO::PARAM_INT);
    }

    $stmt->execute();

    // Fetch and store the events
    while ($row = $stmt->fetch()) {
        $event = [
            'idEvenement' => $row['idEvenement'],
            'titre' => $row['titre'],
            'description' => $row['description'],
            'dateEvenement' => $row['dateEvenement'],
            'nbPlaces' => $row['nbPlaces'],
            'nbInscrits' => $row['nbInscrits'],
            'image' => $row['image'],
            'actif' => $row['actif'],
            'designationOrganisateur' => $row['designationOrganisateur'],
            'email' => $row['email'],
            'idLieu' => $row['idLieu'],
            'nomLieu' => $row['nomLieu'],
        ];
        $events[] = $event;
    }

    return $events;
}



function getEventsAndIdIfEnrolled($userId, $option = '', $rowsPerPage = 6)
{
    global $db;
    $events = [];

    $sqlRowCount = "SELECT COUNT(*) AS nb_evenements
        FROM 
            evenement AS e
        JOIN 
            lieu AS l ON e.idLieu = l.idLieu
        LEFT JOIN 
            inscrire AS i ON e.idEvenement = i.idEvenement AND i.idUtilisateur = :idUtilisateur
        LEFT JOIN 
            utilisateur AS u ON u.idUtilisateur = i.idUtilisateur
        LEFT JOIN 
            utilisateur AS orga ON orga.idUtilisateur = e.idUtilisateur";

    if (!empty($option)) {
        $sqlRowCount .= " " . $option;
    }

    $stmt = $db->prepare($sqlRowCount);
    $stmt->bindParam(":idUtilisateur", $userId);
    $stmt->execute();

    $result = $stmt->fetch();
    $nbEvents = (int) $result['nb_evenements'];

    $GLOBALS['totalPagesEvents'] = ($rowsPerPage === -1) ? 1 : ceil($nbEvents / $rowsPerPage);

    if ($rowsPerPage !== -1) {
        $currentPage = isset($_GET['nb']) && !empty($_GET['nb']) ? (int) strip_tags($_GET['nb']) : 1;
        $firstEvent = ($currentPage * $rowsPerPage) - $rowsPerPage;
    }

    $sql = "SELECT 
        e.idEvenement,
        e.titre,
        e.description,
        e.nbPlaces,
        e.dateEvenement,
        e.image,
        e.actif,
        i.idUtilisateur AS idUtilisateur,
        l.nomLieu,
        u.nom AS nom,
        u.prenom AS prenom,
        orga.designation AS designationOrganisateur,
        (SELECT COUNT(*) FROM inscrire WHERE idEvenement = e.idEvenement) AS nbInscrits
    FROM 
        evenement AS e
    JOIN 
        lieu AS l ON e.idLieu = l.idLieu
    LEFT JOIN 
        inscrire AS i ON e.idEvenement = i.idEvenement AND i.idUtilisateur = :idUtilisateur
    LEFT JOIN 
        utilisateur AS u ON u.idUtilisateur = i.idUtilisateur
    LEFT JOIN 
        utilisateur AS orga ON orga.idUtilisateur = e.idUtilisateur";

    if (!empty($option)) {
        $sql .= " " . $option;
    }

    $sql .= " GROUP BY 
        e.idEvenement,
        e.titre,
        e.description,
        e.nbPlaces,
        e.dateEvenement,
        e.image,
        e.actif,
        l.nomLieu,
        orga.designation,
        idUtilisateur,
        u.nom,
        u.prenom
        ORDER BY e.dateEvenement DESC";

    if ($rowsPerPage !== -1) {
        $sql .= " LIMIT :firstEvent, :rowsPerPage";
    }

    $stmt = $db->prepare($sql);
    $stmt->bindParam(":idUtilisateur", $userId);

    if ($rowsPerPage !== -1) {
        $stmt->bindParam(":firstEvent", $firstEvent, PDO::PARAM_INT);
        $stmt->bindParam(":rowsPerPage", $rowsPerPage, PDO::PARAM_INT);
    }

    $stmt->execute();

    while ($row = $stmt->fetch()) {
        $event = [
            'idEvenement' => $row['idEvenement'],
            'idUtilisateur' => $row['idUtilisateur'],
            'nom' => $row['nom'],
            'prenom' => $row['prenom'],
            'actif' => $row['actif'],
            'titre' => $row['titre'],
            'description' => $row['description'],
            'dateEvenement' => $row['dateEvenement'],
            'nbPlaces' => $row['nbPlaces'],
            'nbInscrits' => $row['nbInscrits'],
            'image' => $row['image'],
            'designationOrganisateur' => $row['designationOrganisateur'],
            'nomLieu' => $row['nomLieu'],
        ];
        $events[] = $event;
    }

    return $events;
}


function getEventsOrganizedByUser($idUtilisateur, $rowsPerPage = -1)
{
    global $db;
    $events = [];

    $sqlRowCount = "SELECT COUNT(*) AS nb_evenements
        FROM 
            evenement e
        JOIN 
            lieu l ON e.idLieu = l.idLieu
        JOIN 
            utilisateur orga ON e.idUtilisateur = orga.idUtilisateur
        WHERE 
            e.idUtilisateur = :idUtilisateur AND e.actif = 1;";

    $stmt = $db->prepare($sqlRowCount);
    $stmt->bindParam(":idUtilisateur", $idUtilisateur);
    $stmt->execute();

    $result = $stmt->fetch();
    $nbEvents = (int) $result['nb_evenements'];

    if ($rowsPerPage !== -1) {
        $GLOBALS['totalPagesEvents'] = ceil($nbEvents / $rowsPerPage);

        if (isset($_GET['nb']) && !empty($_GET['nb'])) {
            $currentPage = (int) strip_tags($_GET['nb']);
        } else {
            $currentPage = 1;
        }

        $firstEvent = ($currentPage * $rowsPerPage) - $rowsPerPage;

        $sql = "SELECT 
            orga.idUtilisateur,
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
            orga.designation AS designationOrganisateur, 
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
            e.idUtilisateur = :idUtilisateur AND actif = 1
        GROUP BY 
            e.idEvenement, l.nomLieu, orga.nom, orga.prenom, orga.email, orga.designation
        ORDER BY e.dateEvenement DESC
        LIMIT :firstEvent, :rowsPerPage;";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(":idUtilisateur", $idUtilisateur);
        $stmt->bindParam(":firstEvent", $firstEvent, PDO::PARAM_INT);
        $stmt->bindParam(":rowsPerPage", $rowsPerPage, PDO::PARAM_INT);
    } else {
        $sql = "SELECT 
            orga.idUtilisateur,
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
            orga.designation AS designationOrganisateur, 
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
            e.idUtilisateur = :idUtilisateur AND actif = 1
        GROUP BY 
            e.idEvenement, l.nomLieu, orga.nom, orga.prenom, orga.email, orga.designation
        ORDER BY e.dateEvenement DESC;";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(":idUtilisateur", $idUtilisateur);
    }

    $stmt->execute();

    while ($row = $stmt->fetch()) {
        $event = [
            'idEvenement' => $row['idEvenement'],
            'idUtilisateur' => $row['idUtilisateur'],
            'nom' => $row['nom'],
            'prenom' => $row['prenom'],
            'actif' => $row['actif'],
            'titre' => $row['titre'],
            'description' => $row['description'],
            'dateEvenement' => $row['dateEvenement'],
            'nbPlaces' => $row['nbPlaces'],
            'nbInscrits' => $row['nbInscrits'],
            'image' => $row['image'],
            'designationOrganisateur' => $row['designationOrganisateur'],
            'nomLieu' => $row['nomLieu'],
        ];
        $events[] = $event;
    }

    return $events;
}



function updateEvent($event)
{
    global $db;
    $table = "evenement";

    try {
        $fields = array_keys($event);
        $fields = array_filter($fields, fn($field) => $field !== 'idEvenement');
        if (empty($fields)) {
            return false;
        }

        $updateFields = array_map(fn($field) => "$field = :$field", $fields);
        $updateFieldsString = implode(", ", $updateFields);

        $sql = "UPDATE $table SET $updateFieldsString WHERE idEvenement = :idEvenement";

        $stmt = $db->prepare($sql);

        foreach ($fields as $field) {
            $stmt->bindValue(":$field", $event[$field]);
        }
        $stmt->bindValue(":idEvenement", $event['idEvenement'], PDO::PARAM_INT);
        $stmt->execute();
        $db = null;
        return true;
    } catch (PDOException $e) {
        echo "L'update dans la table $table a échoué : " . $e->getMessage();
        return false;
    }
}



function updateEvents($data, $option = null)
/* Exemple de $data :
foreach ($events as $event) {
	if (isset($imagePaths[$event['idEvenement']])) {
		$data[] = ['idEvenement' => $event['idEvenement'], 'image' => $imagePaths[$event['idEvenement']]];
	}
}
    */
{
    global $db;

    $table = "evenement";
    $stmt = isset($option) ? update($table, $data, $option) : update($table, $data);
    return $stmt;
}

function createEvents($data, $option = null)
{

    global $db;

    $table = "evenement";

    $stmt = isset($option) ? insert($table, $data, $option) : insert($table, $data);
    return $stmt;
}

function insertEvent($event_array)
{
    global $db;

    try {
        if (is_array($event_array)) {
            $query = "INSERT INTO evenement (titre, description, dateEvenement, nbPlaces, image, actif, idLieu, idUtilisateur) VALUES (:titre, :description, :dateEvenement, :nbPlaces, :image, :actif, :idLieu, :idUtilisateur)";

            $stmt = $db->prepare($query);

            $stmt->bindParam(':titre', $event_array['titre'], PDO::PARAM_STR);
            $stmt->bindParam(':description', $event_array['description'], PDO::PARAM_STR);
            $stmt->bindParam(':dateEvenement', $event_array['dateEvenement'], PDO::PARAM_STR);
            $stmt->bindParam(':nbPlaces', $event_array['nbPlaces'], PDO::PARAM_INT);
            $stmt->bindParam(':image', $event_array['image'], PDO::PARAM_STR);
            $stmt->bindParam(':actif', $event_array['actif'], PDO::PARAM_INT);
            $stmt->bindParam(':idLieu', $event_array['idLieu'], PDO::PARAM_INT);
            $stmt->bindParam(':idUtilisateur', $event_array['idUtilisateur'], PDO::PARAM_INT);

            $stmt->execute();
            return $stmt->rowCount() > 0;
        } else {
            return false;
        }
        // return $stmt !== false;
    } catch (PDOException $e) {
        echo "Erreur lors de l'ajout de l'événement : " . $e->getMessage();
        return false;
    }
}


function validateEvent($idEvenement)
{
    global $db;

    try {
        $stmt = $db->prepare("UPDATE evenement SET actif = 1 WHERE idEvenement = :idEvenement");
        $stmt->execute(['idEvenement' => $idEvenement]);

        return $stmt->rowCount() > 0;
    } catch (PDOException $e) {
        echo "Erreur lors de la validation de l'évènement : " . $e->getMessage();
        return false;
    }
}

function validateEventInputs($array)
{
    global $db;
    $errors = [];
    $wordPattern = '/^[a-zA-ZÀ-ÿ\s\'\-\:\’]{2,100}$/';  // letters, accents, spaces, hyphens, apostrophes


    if (empty($array['nomLieu']) || !isset($_SESSION['idUtilisateur']) || empty($array['titre']) || empty($array['dateEvenement']) || empty($array['description']) || empty($array['nbPlaces'])) {
        $errors[] = "Veuillez remplir tous les champs.";
    }

    if (!isset($_SESSION['idUtilisateur'])) {
        $errors[] = "Veuillez vous connecter pour poster le formulaire.";
        return false;
    }

    if (!preg_match($wordPattern, $array['titre'])) {
        console_log("Le titre est invalide.");
        $errors[] = "Le titre est invalide.";
    }

    if (!preg_match($wordPattern, $array['nomLieu'])) {
        $errors[] = "Le nom du lieu est invalide.";
    }

    if (empty($array['dateEvenement']) || !strtotime($array['dateEvenement'])) {
        $errors[] = "Date incorrecte ou non spécifiée.";
    }


    if (!filter_var($array['nbPlaces'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'max_range' => 1000]])) {
        $errors[] = "Le nombre de places est invalide (1 à 1000).";
    }

    if (empty($errors)) {
        $returnData = [
            'titre' => $array['titre'],
            'description' => $array['description'],
            'dateEvenement' => $array['dateEvenement'],
            'nbPlaces' => (int)$array['nbPlaces'],
            'image' => $array['image'],
            'actif' => 0,
            'idUtilisateur' => (int)$_SESSION['idUtilisateur']
        ];

        if (isset($array['idEvenement'])) {
            $returnData['idEvenement'] = (int)$array['idEvenement'];
        }
        return $returnData;
    } else {
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
        return false;
    }
}



function searchEvents($searchOptions, $userId = null)
{
    global $db, $message, $error_message;

    $sql = "
        SELECT DISTINCT
            e.idEvenement,
            e.titre,
            e.description,
            e.nbPlaces,
            e.dateEvenement,
            e.image,
            e.actif,
            l.nomLieu,
            orga.nom AS nom,
            orga.prenom AS prenom,
            orga.designation AS designationOrganisateur,
            (SELECT COUNT(*) FROM inscrire WHERE idEvenement = e.idEvenement) AS nbInscrits,
            i.idUtilisateur
        FROM 
            evenement AS e
        JOIN
            lieu AS l ON e.idLieu = l.idLieu
        LEFT JOIN
            inscrire AS i ON e.idEvenement = i.idEvenement AND i.idUtilisateur = ?
        LEFT JOIN
            utilisateur AS orga ON orga.idUtilisateur = e.idUtilisateur
        WHERE
            e.actif = 1";

    $parameters = [$userId];

    if (!empty($searchOptions['date'])) {
        $sql .= " AND DATE(e.dateEvenement) = ?";
        $parameters[] = $searchOptions['date'];
    }

    if (!empty($searchOptions['location'])) {
        $sql .= " AND l.nomLieu = ?";
        $parameters[] = $searchOptions['location'];
    }

    if (!empty($searchOptions['organizer'])) {
        $sql .= " AND e.idUtilisateur = ?";
        $parameters[] = $searchOptions['organizer'];
    }

    if (!empty($searchOptions['keywords'])) {
        $keywords = strtolower(trim($searchOptions['keywords']));
        $patterns = ['/à/', '/é/', '/è/', '/ï/', '/î/', '/ô/', '/ù/', '/û/', '/ç/'];
        $replacements = ['a', 'e', 'e', 'i', 'i', 'o', 'u', 'u', 'c'];
        $keywords = preg_replace($patterns, $replacements, $keywords);
        $keywordsArray = explode(' ', $keywords);

        if (count($keywordsArray) > 0) {
            $sql .= " AND (";
            $keywordConditions = [];
            foreach ($keywordsArray as $word) {
                $keywordConditions[] = "(LOWER(e.titre) LIKE ? OR LOWER(e.description) LIKE ? OR LOWER(l.nomLieu) LIKE ?)";
                $parameters[] = "%$word%";
                $parameters[] = "%$word%";
                $parameters[] = "%$word%";
            }
            $sql .= implode(" OR ", $keywordConditions) . ")";
        }
    }

    $sql .= " ORDER BY e.dateEvenement DESC";

    try {
        $stmt = $db->prepare($sql);

        // Debug output
        echo "SQL Query: " . $sql . "<br>";
        echo "Parameters: <pre>" . print_r($parameters, true) . "</pre>";

        $stmt->execute($parameters);

        $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $message = "Recherche effectuée avec succès !";
        return $events;
    } catch (PDOException $e) {
        $error_message = "Erreur lors de la recherche d'évènements : " . $e->getMessage();
        // Debug output
        echo "Error: " . $e->getMessage() . "<br>";
        echo "SQL Query: " . $sql . "<br>";
        echo "Parameters: <pre>" . print_r($parameters, true) . "</pre>";
        return false;
    }
}


function procedureEvents()
{
    global $db;
    $query = "SELECT * FROM evenement e
JOIN lieu ON e.idLieu = lieu.idLieu
JOIN utilisateur ON e.idUtilisateur = utilisateur.idUtilisateur 
LEFT JOIN inscrire ON e.idEvenement = inscrire.idEvenement
AND inscrire.idUser=2;";
    $procQuery = "BEGIN
SELECT
e.idEvenement,
e.titre,
lieu.nomLieu,
utilisateur.designationOrganisateur,
inscrire.idUtilisateur
FROM evenement e
JOIN lieu ON e.idLieu = lieu.idLieu
JOIN utilisateur ON e.idUtilisateur = utilisateur.idUtilisateur 
LEFT JOIN inscrire ON 
e.idEvenement = inscrire.idEvenement
AND participer.idUtilisateur=userId;
END";

    $sql = "CALL getEventsByIdUser(?)";

    // $stmt = $db->prepare($sql);
    // $stmt->bindParam(':userId', $imagePath, PDO::PARAM_STR);
    $data = $db->query($sql);

    return $data;
}

function getEventsByUserIdProcedure($userId)
{
    global $db;

    try {
        // Préparer l'appel a la procédure stockée
        $stmt = $db->prepare('CALL getEventsByIdUser(:userId)');

        // Bind le param userId a la procédure stockée
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();

        // Récuperer les resultats
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $results;
    } catch (PDOException $e) {
        echo 'Database error: ' . $e->getMessage();
        return false;
    }
}
