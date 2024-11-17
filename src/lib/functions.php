<?php
$rootPath = $_SERVER['DOCUMENT_ROOT'] . '/ProjetEvenements';

function validateInputs($array)
{
    $emailPattern = '/^[\w\.-]+@[a-zA-Z\d\.-]+\.[a-zA-Z]{2,6}$/';
    $namePattern = '/^[a-zA-ZÀ-ÿ\s\'-]{2,50}$/'; // letters, accents, spaces, hyphens, apostrophes
    $passwordPattern = '/^(?=.*[A-Z])(?=.*\d)(?=.*[a-zA-Z]).{8,}$/'; // Min 8 chars, 1 uppercase, 1 letter, 1 number


    if (isset($array['nom'])) {
        if (!preg_match($namePattern, $array["nom"])) {
            $error_message = "Nom invalide";
            echo "<br>" . $error_message;
            return false;
        }
    }

    if (isset($array['prenom'])) {
        if (!preg_match($namePattern, $array["prenom"])) {
            $error_message = "Prénom invalide";
            echo "<br>" . $error_message;
            return false;
        }
    }
    if (isset($array['email'])) {
        if (!preg_match($emailPattern, $array["email"])) {
            $error_message = "Email invalide";
            echo "<br>" . $error_message;
            return false;
        }
    }

    if (isset($array['motDePasse'])) {
        if (!preg_match($passwordPattern, $array["motDePasse"])) {
            $error_message = "Mot de passe invalide";
            echo "<br>" . $error_message;
            return false;
        }
    }

    if (isset($array['confirm'])) {
        if ($array["motDePasse"] != $array["confirm"]) {
            $error_message = "Confirmation du mot de passe invalide";
            echo "<br>" . $error_message;
            return false;
        }
    }


    $data = [];
    $designation = NULL;
    if (isset($array['prenom'])) {
        if (isset($array['roles'])) {
            if (is_array($array['roles'])) {
                $validRoles = ['Administrateur', 'Utilisateur', 'Organisateur'];
                foreach ($array['roles'] as $role) {
                    if (!in_array($role, $validRoles)) {
                        $error_message = "Rôle invalide";
                        echo "<br>" . $error_message;
                        return false;
                    }
                }
                $rolesJson = json_encode($array['roles']);
            } else {
                // $rolesJson = json_encode("Utilisateur");
                $error_message = "Veuillez sélectionner au moins un rôle (functions.php)";
                echo "<br>" . $error_message;
                return false;
            }


            if (isset($array['designation']) && !empty($array['designation']) && $array['designation'] != "") {
                if (!preg_match($namePattern, $array["designation"])) {
                    $error_message = "Designation invalide";
                    echo "<br>" . $error_message;
                    return false;
                } else $designation = $array['designation'];
            }
        } else {
            $error_message = "Veuillez sélectionner au moins un rôle (functions.php)";
            echo "<br>" . $error_message;
            return false;
        }

        $data = [
            'prenom' => $array['prenom'],
            'nom' => $array['nom'],
            'email' => $array['email'],
            'motDePasse' => $array['motDePasse'],
            'roles' => $rolesJson,
        ];
        if (isset($designation)) {
            $data['designation'] = $designation;
        }
    } else {
        $data = [
            'email' => $array['email'],
            'motDePasse' => $array['motDePasse']
        ];
    }

    return $data;
}


function select($table, $option = null, $rowsPerPage = -1)
{
    global $db;

    $sqlRowCount = "SELECT COUNT(*) AS nb_" . $table . "s FROM " . $table;
    $sql = "SELECT * FROM " . $table;

    if (!empty($option)) {
        $sqlRowCount .= " " . $option;
        $sql .= " " . $option;
    }

    $stmt = $db->query($sqlRowCount);
    $countResult = $stmt->fetch();
    $nbRows = (int) $countResult["nb_" . $table . "s"];

    if ($rowsPerPage > 0) {
        $GLOBALS['totalPagesUsers'] = ceil($nbRows / $rowsPerPage);
    } else {
        $GLOBALS['totalPagesUsers'] = 1;
    }

    if ($rowsPerPage !== -1) {
        $currentPage = isset($_GET['nb']) && !empty($_GET['nb']) ? (int) strip_tags($_GET['nb']) : 1;
        $firstRow = ($currentPage * $rowsPerPage) - $rowsPerPage;
    }

    if ($rowsPerPage !== -1) {
        $sql .= " LIMIT :firstRow, :rowsPerPage";
    }

    $stmt = $db->prepare($sql);

    if ($rowsPerPage !== -1) {
        $stmt->bindParam(":firstRow", $firstRow, PDO::PARAM_INT);
        $stmt->bindParam(":rowsPerPage", $rowsPerPage, PDO::PARAM_INT);
    }

    $stmt->execute();

    return $stmt;
}


function update($table, $data)
{
    global $db;
    $table = "evenement";



    try {
        foreach ($data as $event) {
            $fields = array_keys($event);
            $fields = array_filter($fields, function ($field) {
                return $field !== 'idEvenement';
            });

            if (empty($fields)) {
                continue;
            }
            $updateFields = array_map(function ($field) {
                return "$field = :$field";
            }, $fields);
            $updateFieldsString = implode(", ", $updateFields);
            $sql = "UPDATE $table SET $updateFieldsString WHERE idEvenement = :idEvenement";
            $stmt = $db->prepare($sql);

            foreach ($fields as $field) {
                $stmt->bindValue(":$field", $event[$field]);
            }

            $stmt->bindValue(":idEvenement", $event['idEvenement'], PDO::PARAM_INT);

            $stmt->execute();
        }

        $db = null;
        return true;
    } catch (PDOException $e) {
        echo "L'update dans la table $table a échoué : " . $e->getMessage();
        return false;
    }
}


function insert($table, $data, $option = NULL)
/* Ex data :
$data = 
    [
        'name' => 'John Doe',
        'email' => 'john.doe@example.com',
        'age' => 30
    ];
 */
{
    global $db;
    $rootPath = $_SERVER['DOCUMENT_ROOT'] . '/ProjetEvenements';
    require_once $rootPath . '/src/lib/variables.php';

    try {

        // echo "Insert. Array : " . print_r($data, true) . "<br>";
        $fields = array_keys($data);
        $fieldsString = implode(", ", $fields);
        $placeholders = array_map(function ($field) {
            return ":$field";
        }, $fields);
        $placeholdersString = implode(", ", $placeholders);
        $sql = "INSERT INTO $table ($fieldsString) VALUES ($placeholdersString) $option";


        $stmt = $db->prepare($sql);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $stmt->execute();

        $db = null;
        return $stmt;
    } catch (PDOException $e) {
        echo "L'insertion de dans la table $table a échoué : " . $e->getMessage();
        return $stmt;
    }
}

function insertMany($table, $data, $option = NULL)
/* Ex data :
$data = [
    [
        'name' => 'John Doe',
        'email' => 'john.doe@example.com',
        'age' => 30
    ],
    [
        'name' => 'Jane Smith',
        'email' => 'jane.smith@example.com',
        'age' => 25
    ]
];
 */
{

    global $db;
    require_once $GLOBALS['rootPath'] . '/src/config/config.php';


    $fields = array_keys($data[0]);
    $fieldsString = implode(", ", $fields);
    $placeholders = array_map(function ($field) {
        return ":$field";
    }, $fields);
    $placeholdersString = implode(", ", $placeholders);
    $sql = "INSERT INTO $table ($fieldsString) VALUES ($placeholdersString) $option";

    try {
        $stmt = $db->prepare($sql);
        foreach ($data as $row) {
            foreach ($row as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }
            $stmt->execute();
        }
        $db = null;
        return $stmt;
    } catch (PDOException $e) {
        echo "L'insertion de dans la table $table a échoué : " . $e->getMessage();
        return $stmt;
    }
}

function delete($table, $conditions, $option = NULL)
{

    global $db;

    try {
        $conditionStrings = [];
        foreach ($conditions as $field => $value) {
            $conditionStrings[] = "$field = :$field";
        }
        $conditionsString = implode(" AND ", $conditionStrings);
        $sql = "DELETE FROM $table WHERE $conditionsString $option";

        $stmt = $db->prepare($sql);
        foreach ($conditions as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $stmt->execute();

        return $stmt->rowCount() > 0;
    } catch (PDOException $e) {
        echo "La suppression dans la table $table a échoué : " . $e->getMessage();
        return false;
    }
}



function superglobales()
{
    echo "--------------- SUPERGLOBALES ------------ <br>";
    echo '$_SESSION : ';
    var_dump($_SESSION);
    echo ' <br> $_GET  : ';
    var_dump($_GET);
    echo ' <br> $_POST  : ';
    var_dump($_GET);
    echo ' <br> $_COOKIE  : ';
    var_dump($_COOKIE);
    echo '<br> $_FILES  : ';
    var_dump($_FILES);
}

//UTILITAIRES

function prettyEcho($params)
{
    echo "<div class='container mx-auto p-4 bg-gray-900 text-white text-md rounded-lg shadow-lg'>";
    print_r($params);
    echo "</div>";
};


function toString_datetime($object)
{
    return $object->format('Y-m-d H:i:s');
}

//console_log PHP
function console_log($output, $with_script_tags = true)
{
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . ');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}

function array_any(array $array, callable $fn)
{
    foreach ($array as $value) {
        if ($fn($value)) {
            return true;
        }
    }
    return false;
}

function array_some(array $array, mixed $var)
{
    foreach ($array as $value) {
        if ($value === $var) {
            return true;
        }
    }
    return false;
}
function array_every(array $array, callable $fn)
{
    foreach ($array as $value) {
        if (!$fn($value)) {
            return false;
        }
    }
    return true;
}
//Connexion - Deconnexion

function disconnect()
{
    if (isset($_GET['deconnexion']) && $_GET['deconnexion'] == true) {
        session_unset();
        session_destroy();
        $_GET = array();
        $_POST = array();
        return true;
    }
}

function forceDisconnect()
{
    session_unset();
    session_destroy();
    $_GET = array();
    $_POST = array();
    return true;
}


function sessionExpiration()
{
    if (isset($_SESSION['session_id'])) {

        if ($_SESSION['session_expiration'] == time()) {
            session_unset();
            session_destroy();
            echo "<br>Session terminée<br>";
            var_dump($_SESSION);
            return true;
        } else {
            return false;
        }
    } else {
        return NULL;
    }
}


function keywordSearch($mc)
{
    global $db;

    $mc = trim($mc);
    $mc = strtolower($mc);
    $mc_array = str_word_count($mc, 1, '&éàèùôïç');

    echo "<br> Tableau de mots clés : ";
    var_dump($mc_array);
    echo "<br>";

    $query_mc = "SELECT * FROM evenement AS e JOIN lieu AS l ON e.idLieu = l.idLieu";

    if (count($mc_array) > 0) {
        $query_mc .= " WHERE";
        $conditions = [];
        foreach ($mc_array as $mot) {
            $conditions[] = "(titre LIKE :mot OR description LIKE :mot OR nomLieu LIKE :mot)";
        }
        $query_mc .= " " . implode(" OR ", $conditions);
    }

    echo "<br> Requête après foreach : " . $query_mc . "<br>";

    $stmt = $db->prepare($query_mc);

    foreach ($mc_array as $mot) {
        $stmt->bindValue(':mot', "%$mot%");
    }

    // Execute and fetch results
    $stmt->execute();
    $donnees_mc = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $donnees_mc;
}



//ORGANISER


function handleImageUpload($file)
{
    // $uploadDir = __DIR__ . '/../public/assets/images/events/';
    $uploadDir = $GLOBALS['rootPath'] . '/public/assets/images/events/';

    if (!is_dir($uploadDir)) {
        if (!mkdir($uploadDir, 0777, true)) {
            echo "Erreur lors de la création du dossier d'upload.<br>";
            return false;
        }
    }

    if (isset($file) && $file['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $file['tmp_name'];
        $fileName = basename($file['name']);
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($fileExtension, $allowedExtensions)) {
            echo "Type de fichier non autorisé. Veuillez télécharger une image JPG, JPEG, PNG, ou GIF.<br>";
            return false;
        }

        $newFileName = uniqid('event_', true) . '.' . $fileExtension;
        $finalPath = $uploadDir . $newFileName;

        if (move_uploaded_file($fileTmpPath, $finalPath)) {
            return '/public/assets/images/events/' . $newFileName;
        } else {
            echo "Erreur lors du téléchargement de l'image.<br>";
            return false;
        }
    }

    echo "Erreur lors de la réception du fichier.<br>";
    return false;
}

//Zone ADMIN 



function validateUpdatePasswordInputs($array)
{
    $estCorrect = true;
    $regex_password = '~[A-Za-z0-9-_@\$!\.]{8,20}~';
    $message_erreur = "";
    if (isset($array['submit_password']) && isset($_SESSION['user_id'])) {
        if (!empty($array['ancien_password']) && preg_match($regex_password, $array['ancien_password']) && !empty($array['nouveau_password']) && $array['nouveau_password'] == $array['confirm_password']) {

            return $estCorrect;
        } else {
            //estCorrect = false
            //si 3 champs vides
            if (empty($array['ancien_password']) && empty($array['nouveau_password']) && empty($array['confirm_password'])) {
                $message_erreur = "Veuillez remplir les champs.<br />";
                $array = array();
                $estCorrect = false;
            } else {  //si 1 ou 2 champs incorrects
                //Ancien password
                if (empty($array['ancien_password'])) {
                    $message_erreur .= "Veuillez indiquer un ancien mot de passe.<br />";
                    $estCorrect = false;
                }

                //Nouveau Mot de passe  
                if (empty($array['nouveau_password']) || !preg_match($regex_password, $array['ancien_password'])) {
                    $message_erreur .= "Veuillez entrer un nouveau mot de passe valide. Caractères autorisés : [A-Za-z0-9-_@.$!.]. <br>";
                    $estCorrect = false;
                }

                //Confirm Mot de passe  
                if (empty($array['confirm_password'])) {
                    $message_erreur .= "Confirmation invalide <br>";
                    $estCorrect = false;
                }
                //Nouveau mot de passe et confirmation nouveau mot de passe différents
                if ($array['nouveau_password'] != $array['confirm_password']) {
                    $message_erreur .= "Le nouveau mot de passe et sa confirmation ne correspondent pas. <br>";
                    $estCorrect = false;
                }
            }
            $array = array();
            echo $message_erreur;
            return $estCorrect;
        }
    }
}
//On vérifie que l'ancien mdp correspond bien à celui dans la BDD
function checkOldPassword($user_id, $ancien_password)
{
    global $db;
    if (isset($_SESSION['sessionId']) && isset($_SESSION['utilId'])) {
        require($GLOBALS['rootPath'] . 'src/config/config.php');


        $query = "SELECT motDePasse FROM utilisateur WHERE idUtilisateur=:idUtilisateur";
        $stmt = $db->prepare($query);
        $stmt->execute(['idUtilisateur' => $user_id]);
        $resultat = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($resultat != FALSE) {
            echo "<br>L'ancien mdp a été fetch() ! !<br>";
        }

        $estValide = password_verify($ancien_password, $resultat['motDePasse']);

        if ($estValide) {
            echo "Le mdp dans la BDD et le mdp entré dans le champ \"Ancien PASSWORD\" correspondent.<br>";
            return $estValide;
        } else {
            $_POST = array();
            return false;
        }
    }
}


function updatePassword(int $userId, string $newPassword): bool
{
    global $db;
    $newPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    $query = "UPDATE utilisateur SET motDePasse=:newPassword WHERE idUtilisateur=:userId";
    $stmt = $db->prepare($query);
    $stmt->execute(['userId' => $userId, 'newPassword' => $newPassword]);

    if ($stmt != FALSE) {
        $_POST = array();
        return true;
    } else {
        //echo "Erreur lors de la modification du mdp <br>" . $db->error;
        $_POST = array();
        return false;
    }
}



function getColumns($table)
{
    global $db;

    $columns = $db->query('SHOW FULL COLUMNS FROM ' . $table);
    $columnNames = [];

    while ($column = $columns->fetch()) {
        if ($column['Field'] === 'motDePasse') continue;
        $columnNames[] = $column['Field'];
    }

    return $columnNames;
}
