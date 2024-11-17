 <?php
    session_cache_expire(120);
    ini_set('session.gc_maxlifetime', 120 * 60);
    session_set_cookie_params(120 * 60);
    session_start();

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require_once($GLOBALS['rootPath'] . '/src/lib/variables.php');
    require_once(LIB . "/functions.php");
    require_once($GLOBALS['rootPath'] . '/src/models/userModel.php');
    require_once($GLOBALS['rootPath'] . '/src/models/eventModel.php');
    require_once($GLOBALS['rootPath'] . '/src/models/signinModel.php');
    require_once($GLOBALS['rootPath'] . '/src/models/signupModel.php');
    require_once($GLOBALS['rootPath'] . '/src/models/locationModel.php');
    require_once($GLOBALS['rootPath'] . '/src/models/enrollmentModel.php');
    require_once($GLOBALS['rootPath'] . '/src/models/contactModel.php');
    require_once(CLASSES . '/AbstractController.php');
    require_once(CLASSES . '/Database.php');
    class AppController extends AbstractController
    {

        public function __construct() {}

        public function home($params)
        {
            global $db, $message, $error_message, $loggedIn;
            $option = "";
            $nb = $params['nb'] ?? 1;
            $rowsPerPage = 6;

            $users = getUsers($option, $rowsPerPage);
            $events = [];
            $organizers = getOrganizers();
            $locations = getLocations();
            $enrolled = getEnrolled();

            $option = ' WHERE actif = 1 ';
            $disconnect = $params['deconnexion'] ?? null;

            if ((bool)$disconnect) {
                disconnect();
                header("Location: " . $GLOBALS['rootUrl'] . "/index.php?page=" . "accueil");
            }

            if (isset($_POST['search'])) {
                $searchOptions = [
                    'date' => $_POST['date'] ?? '',
                    'location' => $_POST['location'] ?? '',
                    'organizer' => $_POST['organizer'] ?? '',
                    'keywords' => $_POST['keywords'] ?? ''
                ];


                $userId = $_SESSION['idUtilisateur'] ?? null;
                $events = searchEvents($searchOptions, $userId);
            } else {
                if (isset($_SESSION['idUtilisateur'])) {
                    //  echo 'No search, and user Connected <br>';
                    $userId = $_SESSION['idUtilisateur'];
                    $events = getEventsAndIdIfEnrolled($userId, $option, $rowsPerPage);

                    //Enrollment / Unenrollment
                    //Enrollment
                    if (isset($_POST['submit_inscrire']) && $params['idEvenement']) {
                        $isEnrolledToEvent = checkUserEnrollmentToEvent($_SESSION['idUtilisateur'], $params['idEvenement']);
                        if (!$isEnrolledToEvent) {
                            enrollUserToEvent($_SESSION['idUtilisateur'], $params['idEvenement']);
                            // header("Location: " . $GLOBALS['rootUrl']);Créer var session temporaire
                            $message = "Vous avez bien été inscrit à l'évènement";
                            $_POST = array();
                        } else {
                            $error_message = "Vous êtes déjà inscrit à cet evenement";
                        }
                    }
                    //Unenrollment
                    if (isset($_POST['submit_desinscrire']) && $params['idEvenement']) {
                        $isEnrolledToEvent = checkUserEnrollmentToEvent($_SESSION['idUtilisateur'], $params['idEvenement']);
                        if ($isEnrolledToEvent) {
                            unenrollUserToEvent($_SESSION['idUtilisateur'], $params['idEvenement']);
                            $_POST = array();
                            // header("Location: " . $GLOBALS['rootUrl']); Créer var session temporaire
                            $message = "Vous avez bien desinscrit de l'évènement";
                        } else {
                            $message = "Vous n'êtes pas inscrit à cet evenement";
                        }
                    }
                } else {
                    // echo 'No search, and user NOT CONNECTED <br>';
                    $option = " WHERE actif = 1";
                    $events = getEventsWithEnrolledAmount($option, $rowsPerPage, "all");
                }
            }

            $totalPagesEvents = $GLOBALS['totalPagesEvents'];

            $events = gettype($events) == 'array' && count($events) > 0 ? $events : [];

            if (isset($_SESSION['message'])) {
                $message = $_SESSION['message'];
                unset($_SESSION['message']);
            }



            $this->render("accueil", [
                "events" => $events,
                "users" => $users,
                "organizers" => $organizers,
                "locations" => $locations,
                "message" => $message,
                "error_message" => $error_message,
                "loggedIn" => $loggedIn,
                "nb" => $nb,
                "totalPagesEvents" => $totalPagesEvents
            ]);
        }


        public function signin()
        {



            global $db, $message, $error_message, $loggedIn;

            $users = getUsers();
            $disconnect = $params['deconnexion'] ?? null;

            if ((bool)$disconnect) {
                disconnect();
                header("Location: " . $GLOBALS['rootUrl'] . "/index.php?page=" . "inscription");
            }

            if (isset($_POST['submit_connexion']) && !$loggedIn) {
                if (!empty($_POST["email"]) && !empty($_POST["motDePasse"])) {
                    if ($userInfo = validateInputs($_POST)) {
                        if ($signin = signInUser($userInfo)) {
                            $_SESSION['idUtilisateur'] = $signin['idUtilisateur'];
                            $_SESSION['email'] = $signin['email'];
                            $_SESSION['prenom'] = $signin['prenom'];
                            $_SESSION['roles'] = $signin['roles'];
                            $_SESSION['session_id'] = session_id();
                            $_SESSION['session_debut'] = time();
                            $_SESSION['session_expiration'] = time() + (2 * 60 * 60); // 2 hours

                            $message = "Connexion réussie (appController) !";

                            console_log("Connexion réussie : " . print_r($signin, true));
                        } else {
                            echo "Données de l'erreur de connexion : " . print_r($signin, true);
                            $error_message = "Email ou mot de passe incorrect (appController).";
                        }
                    } else {
                        echo "Inputs invalides";
                    }
                }


                // CONNECTE + CLIC SUBMIT
                elseif ($loggedIn && isset($_POST['submit_connexion'])) {
                    echo "Déjà connecté !",
                    $message .= "Vous êtes déjà connecté ! <br>";
                    $_POST = array();
                } else {
                    echo "Inputs vides";
                    $error_message = "Veuillez remplir tous les champs.";
                }
            }
            sessionExpiration();

            if (isset($_SESSION['session_id']))
                echo "Connexion Session ID : " . time() . " - " . $_SESSION['session_id'] . " - " . $_SESSION['email'];
            $this->render("connexion", ['loggedIn' => $loggedIn, 'message' => $message, 'error_message' => $error_message, 'users' => $users]);
        }

        public function signup()
        {

            global $message, $error_message, $loggedIn;
            $user = [];
            $events = [];
            $user = getUsers();
            $organizers = getOrganizers();
            $events = getEvents();
            $disconnect = $params['deconnexion'] ?? null;

            if ((bool)$disconnect) {
                disconnect();
                header("Location: " . $GLOBALS['rootUrl'] . "/index.php?page=" . "connexion");
            }
            if (isset($_POST["submit_inscription"]) && !$loggedIn && isset($_POST["email"])) {
                if ($userInfo = validateInputs($_POST)) {
                    console_log("Validation des champs réussie");

                    if ($signup = createUser($userInfo)) {
                        console_log("Creation de l'utilisateur : $signup");
                        $message .= "<br/>Inscription réussie !";
                        console_log("Utilisateur créé !");
                    } else {
                        echo ("<br>Problème lors de la CREATION de l'utilisateur");
                        $error_message .= "<br />Erreur lors de la création de l'utilisateur";
                    }
                } else {
                    echo "<br>Champs non validés";
                    $error_message .= "<br/>Les champs ne respectent pas le format requis";
                }
            }


            $this->render("inscription", ['loggedIn' => $loggedIn, 'message' => $message, 'error_message' => $error_message, 'user' => $user, 'events' => $events, 'organizers' => $organizers]);
        }



        public function event($params)
        {

            global $loggedIn;
            global $error_message, $message;


            $disconnect = $params['deconnexion'] ?? null;

            if ((bool)$disconnect) {
                disconnect();
                header("Location: " . $GLOBALS['rootUrl'] . "/index.php?page=" . "evenement");
            }

            if (!isset($params['idEvenement'])) {
                echo "L'évènement n'existe pas";
                return;
            }

            $event = getEventsWithEnrolledAmount(" WHERE e.idEvenement=" . intval($params['idEvenement']), "all");
            if (!$event) {
                echo "L'évènement n'existe pas";
                return;
            }

            $enrolledOfEvent = getEnrolled($params['idEvenement']);

            $isEnrolledToEvent = false;
            $hasJustEnrolledToEvent = false;

            if (isset($_SESSION['idUtilisateur'])) {
                $isEnrolledToEvent = checkUserEnrollmentToEvent($_SESSION['idUtilisateur'], $params['idEvenement']);
                if (!$isEnrolledToEvent && isset($_POST['submit_inscrire'])) {
                    $hasJustEnrolledToEvent = enrollUserToEvent($_SESSION['idUtilisateur'], $params['idEvenement']);
                    $_POST = array();
                }
            }

            $this->render("evenement", [
                'message' => $message,
                'error_message' => $error_message,
                'loggedIn' => $loggedIn,
                'event' => $event,
                'enrolledOfEvent' => $enrolledOfEvent,
                'hasJustEnrolledToEvent' => $hasJustEnrolledToEvent,
                'isEnrolledToEvent' => $isEnrolledToEvent,
            ]);
        }


        public function organize($params)
        {
            global $db, $error_message, $message, $loggedIn;
            $message = "";
            $actionPath = "/index.php?page=organiser";
            $locations = getLocations();
            $disconnect = $params['deconnexion'] ?? null;

            if ((bool)$disconnect) {
                disconnect();
                header("Location: " . $GLOBALS['rootUrl'] . "/index.php?page=" . "organiser");
            }

            $currentDate = new DateTime();
            $currentDateStr = toString_datetime($currentDate);
            $message .= "Date et heure actuelles : " . $currentDateStr . "<br>";

            if (isset($_POST["submit_evenement"]) && $loggedIn) {

                $uploadedFilePath = handleImageUpload($_FILES['image']);

                $data = [
                    'titre' => $_POST['titre'],
                    'description' => $_POST['description'],
                    'nbPlaces' => $_POST['nbPlaces'],
                    'dateEvenement' => $_POST['dateEvenement'],
                    'idUtilisateur' => $_SESSION['idUtilisateur'],
                    'nomLieu' => $_POST['nomLieu'],
                    'image' => $uploadedFilePath,
                    'actif' => 0
                ];

                if (($checkedEvent = validateEventInputs($data)) !== false && $uploadedFilePath !== false) {

                    $nomLieu = $_POST['nomLieu'];
                    $idLieu = insertLocation($nomLieu);
                    if ($idLieu !== false) {

                        $checkedEvent['idLieu'] = (int)$idLieu;
                        $checkedEvent['image'] = $uploadedFilePath;
                        # var_dump("Checked_event : ", $checkedEvent);

                        if (insertEvent($checkedEvent)) {
                            $message .= "Vous avez bien créé l'événement !";
                        } else {
                            $message .= "Erreur lors de l'ajout de l'événement.<br>";
                        }
                    } else {
                        $message .= "Erreur lors de l'ajout du lieu.<br>";
                    }
                } else {
                    $message .= "La validation de l'événement a échoué.<br>";
                }
            } elseif (isset($_POST['submit_evenement']) && !$loggedIn) {
                $message .= "Vous n'êtes pas connecté !<br>";
                header('Location: ./connexion.php');
                exit;
            }


            $this->render("organiser", [
                'loggedIn' => $loggedIn,
                'message' => $message,
                'error_message' => $error_message,
                'locations' => $locations,
                'actionPath' => $actionPath
            ]);
        }

        public function updateEvent($params)
        {
            global $db, $error_message, $message, $loggedIn;
            $isAdmin = false;
            $isEventUpdated = false;
            $actionPath = "/index.php?page=modifier_evenement";
            $lastPageLink = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';

            $disconnect = $params['deconnexion'] ?? null;

            if ((bool)$disconnect) {
                disconnect();
                header("Location: " . $GLOBALS['rootUrl'] . "/index.php?page=" . "modifier_evenement");
            }

            $currentDate = new DateTime();
            $currentDateStr = toString_datetime($currentDate);
            $message .= "Date et heure actuelles : " . $currentDateStr . "<br>";
            $locations = getLocations();

            if (!$loggedIn || !isset($params['idEvenement'])) {
                $error_message = "Vous n'avez pas accès à cette page.";
                console_log($error_message);
                $this->render("modifier_evenement", [
                    'loggedIn' => $loggedIn,
                    'message' => $message,
                    'error_message' => $error_message,
                    'isAdmin' => $isAdmin,
                    'lastPageLink' => $lastPageLink,
                    'event' => []
                ]);
                return;
            }

            $eventId = $params['idEvenement'];
            $userId = $_SESSION['idUtilisateur'];

            $eventData = getEventsWithEnrolledAmount(" WHERE e.idEvenement=" . intval($eventId) . " AND e.idUtilisateur=" . intval($userId), "all");
            if (!$eventData) {

                $error_message = "Évènement introuvable.";
                console_log($error_message);
                $this->render("modifier_evenement", [
                    'loggedIn' => $loggedIn,
                    'message' => $message,
                    'error_message' => $error_message,
                    'isAdmin' => $isAdmin,
                    'lastPageLink' => $lastPageLink,
                    'event' => []
                ]);
                return;
            } else {
                console_log("Event found");
            }

            $event = $eventData[0];
            console_log("isEventUpdated (check to see if form submitted) : " . ($isEventUpdated ? 'true' : 'false'));
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_evenement'])) {
                console_log("Form submitted");

                if ($loggedIn) {
                    console_log("Logged in, uploading image, creating data");

                    $uploadedFilePath = handleImageUpload($_FILES['image']);

                    $data = [
                        'idEvenement' => $event['idEvenement'],
                        'titre' => $_POST['titre'],
                        'description' => $_POST['description'],
                        'nbPlaces' => $_POST['nbPlaces'],
                        'dateEvenement' => $_POST['dateEvenement'],
                        'idUtilisateur' => $_SESSION['idUtilisateur'],
                        'nomLieu' => $_POST['nomLieu'],
                        'image' => $uploadedFilePath,
                        'actif' => 0
                    ];

                    if (($checkedEvent = validateEventInputs($data)) !== false && $uploadedFilePath !== false) {
                        console_log("Inputs validated, upload made");
                        $nomLieu = $_POST['nomLieu'];
                        $idLieu  = $event['idLieu'];

                        if (updateLocation($idLieu, $nomLieu)) {
                            console_log("Location updated");
                            $checkedEvent['idLieu'] = (int)$idLieu;
                            $checkedEvent['image'] = $uploadedFilePath;

                            if (updateEvent($checkedEvent)) {
                                console_log("Event updated!");
                                $isEventUpdated = true;
                                $message .= "Vous avez bien modifié l'événement !";
                            } else {
                                $message .= "Erreur lors de la modification de l'événement.<br>";
                            }
                        } else {
                            $message .= "Erreur lors de la modification du lieu.<br>";
                            console_log("Location update failed");
                        }
                    } else {
                        $message .= "La validation de l'événement a échoué.<br>";
                        console_log("Validation failed");
                    }
                } else {
                    $message .= "Vous n'êtes pas connecté !<br>";
                    header('Location: ./connexion.php');
                    exit;
                }
            }

            $this->render("modifier_evenement", [
                'loggedIn' => $loggedIn,
                'message' => $message,
                'error_message' => $error_message,
                'locations' => $locations,
                'actionPath' => $actionPath,
                'isAdmin' => $isAdmin,
                'lastPageLink' => $lastPageLink,
                'event' => $event,
                'isEventUpdated' => $isEventUpdated

            ]);
        }



        public function profile($params)
        {

            global $db, $error_message, $message, $loggedIn;
            $editPassword = false;
            $oldPasswordIsValid = false;
            $email = $_SESSION['email'];
            $idUtilisateur = $_SESSION['idUtilisateur'];
            $nb = $params['nb'] ?? 1;
            $rowsPerPage = 6;

            $eventsOrganizedByUser = getEventsOrganizedByUser($idUtilisateur, $rowsPerPage);
            $totalPagesEvents = $GLOBALS['totalPagesEvents'];
            $users = getUsers();
            $locations = getLocations();

            $columns = getColumns('utilisateur');
            $roles = ["Administrateur", "Utilisateur", "Organisateur"];
            $userInfo = getUsers(" WHERE idUtilisateur=" . $idUtilisateur . "");
            $activeEvents = getEvents(" WHERE idUtilisateur=" . $idUtilisateur . " AND actif=1");
            $inactiveEvents = getEvents(" WHERE idUtilisateur=" . $idUtilisateur . " AND actif=0");

            $disconnect = $params['deconnexion'] ?? null;

            if ((bool)$disconnect) {
                disconnect();
                header("Location: " . $GLOBALS['rootUrl'] . "/index.php?page=" . "profil");
            }


            if (!isset($_SESSION['idUtilisateur'])) {
                echo ("Accès refusé : Vous n'êtes pas connecté.");
                return;
            }

            if (isset($_GET['disconnect'])) {
                forceDisconnect();
            }

            //Password change
            if ($loggedIn) {
                if (isset($_POST['submit_motDePasse']) && validateUpdatePasswordInputs($_POST)) {
                    $editPassword = true;
                    if (checkOldPassword($_SESSION['idUtilisateur'], $_POST['old_motDePasse'])) {
                        $oldPasswordIsValid = true;
                        updatePassword($_SESSION['idUtilisateur'], $_POST['new_motDePasse']);
                    } else {
                        $oldPasswordIsValid = false;
                        $error_message = "L'ancien mot de passe ne correspond pas à celui du compte <br>";
                    }
                } elseif (isset($_POST['submit_motDePasse']) && !validateUpdatePasswordInputs($_POST)) $error_message = "Il y a une erreur dans l'une ou plusieurs des saisies.<br>";
                else $message = "Bienvenue, " . $_SESSION['prenom'];
            } else {
                echo ("Accès refusé : Vous n'êtes pas connecté.");
                return;
            }

            $this->render("profil", [
                'message' => $message,
                'error_message' => $error_message,
                'loggedIn' => $loggedIn,
                'eventsOrganizedByUser' => $eventsOrganizedByUser,
                'userInfo' => $userInfo,
                'columns' => $columns,
                'users' => $users,
                'activeEvents' => $activeEvents,
                'inactiveEvents' => $inactiveEvents,
                'locations' => $locations,
                'roles' => $roles,
                'email' => $email,
                'editPassword' => $editPassword,
                'oldPasswordIsValid' => $oldPasswordIsValid,
                'nb' => $nb,
                'totalPagesEvents' => $totalPagesEvents,
            ]);
        }

        public function administration($params)
        {

            global $loggedIn, $message, $error_message;
            $nb = $params['nb'] ?? 1;
            $nb_act = $params['nb_act'] ?? 1;
            $nb_ina = $params['nb_ina'] ?? 1;
            $rowsPerPage = 6;
            $option = "";

            if (!isset($_SESSION['idUtilisateur'])) {
                echo ("Accès refusé : Vous n'êtes pas connecté.");
                return;
            }

            if (!in_array("Administrateur", $_SESSION['roles'])) {
                echo ("Accès refusé : Vous n'êtes pas un administrateur.");
                return;
            }

            $disconnect = $params['deconnexion'] ?? null;

            if ((bool)$disconnect) {
                disconnect();
                header("Location: " . $GLOBALS['rootUrl'] . "/index.php?page=" . "administration");
            }

            $users = getUsers($option, $rowsPerPage);


            $inactiveEvents = getEventsWithEnrolledAmount(" WHERE actif = 0", $rowsPerPage, "inactive");
            $totalPagesInactiveEvents = $GLOBALS['totalPagesInactiveEvents'];

            $activeEvents = getEventsWithEnrolledAmount(" WHERE actif = 1", $rowsPerPage, "active");
            $totalPagesActiveEvents = $GLOBALS['totalPagesActiveEvents'];

            // Get the total number of users for pagination
            $totalPagesUsers = $GLOBALS['totalPagesUsers'];

            $locations = getLocations();
            $roles = ["Administrateur", "Utilisateur", "Organisateur"];
            $test = $users[0]['roles'];



            if (isset($_POST['updateRoles']) && isset($_GET['idUtilisateur']) && isset($_POST['roles'])) {
                if (updateRole($_GET['idUtilisateur'], $_POST['roles'])) {
                    $message .= "Utilisateur N°" . $_GET['idUtilisateur'] . " modifié ; Nouveau role : " . implode($_POST['roles']) . "<br>";
                }
            }
            if (isset($_POST['validateEvent']) && isset($_POST['idEvenement'])) {
                if (validateEvent($_POST['idEvenement'])) {
                    $message .= "L'evènement n°" . $_POST["idEvenement"] . " a bien été validé !<br>";
                }
            }

            if (isset($_POST['deleteEvent']) && isset($_POST['idEvenement'])) {
                if (delete('evenement', ['idEvenement' => $_POST['idEvenement']])) {
                    $message .= "L'évènement n°" . $_POST['idEvenement'] . " a bien été supprimé !<br>";
                }
            }

            if (isset($_POST['deleteUser']) && isset($_GET['idUtilisateur'])) {
                if (delete('utilisateur', ['idUtilisateur' => $_GET['idUtilisateur']])) {
                    $message .= "L'utilisateur n°" . $_GET["idUtilisateur"] . " a bien été supprimé.<br>";
                }
            }

            console_log("TotalPagesUsers : " . $totalPagesUsers);

            $this->render("administration", ['loggedIn' => $loggedIn, 'message' => $message, 'error_message' => $error_message, 'users' => $users, 'activeEvents' => $activeEvents, 'inactiveEvents' => $inactiveEvents, 'locations' => $locations, 'roles' => $roles, 'nb' => $nb, 'nb_act' => $nb_act, 'nb_ina' => $nb_ina, 'totalPagesUsers' => $totalPagesUsers, 'totalPagesActiveEvents' => $totalPagesActiveEvents, 'totalPagesInactiveEvents' => $totalPagesInactiveEvents]);
        }

        public function contact($params)
        {
            global $loggedIn, $message, $error_message;
            $admin_recipient_email  = $_ENV['MAIL_RECIPIENT']; //Mail du destinataire : l'admin de NinjaEvents
            $admin_sender_email  = $_ENV['MAIL_SENDER']; //Mail de l'adresse "expéditrice" dans le code : l'admin de NinjaEvents
            $admin_name = $_ENV['USER_NAME'];

            $disconnect = $params['deconnexion'] ?? null;

            if ((bool)$disconnect) {
                disconnect();
                header("Location: " . $GLOBALS['rootUrl'] . "/index.php?page=" . "contact");
            }

            # var_dump($_SESSION);

            if (isset($_POST['submit_contact'])) {
                // $to = "ninjaevents@zohomail.eu";
                $to =  $admin_recipient_email;
                $message_from_email = $_SESSION['email'] ?? $_POST['email']; //Mail de l'utilisateur qui envoie le message

                $subject = $_POST['sujet'];
                // if ($loggedIn) {
                $message_from_user = $_SESSION['prenom'] ?? $_POST['name']; // Nom de l'utilisateur qui envoie le message

                $message_content = "
                <div class='width: 100%; height: 100%; background-color: #040216 '><div style='background-color: #0a0919; min-width: 70%; color: #ffffff; font-family: Cabin, Arial, sans-serif; padding: 20px; border-radius: 15px; max-width: 600px; margin: auto;'>
                    <h1 style='padding: 10px 20px; font-weight: 700; font-size: 28px; font-weight: bold; background: linear-gradient(to right, #5BC0EB, #DB324D); color: #ffffff; border-radius: 15px 15px 15px 15px; border-bottom: 2px solid #ffffff; text-align: center;'>
                        Contact
                    </h1>
                            <h2 style='font-size: 20px;  font-weight: 500; line-height: 1.6; color: #f3f3f3; margin-top: 20px;'>
                        " . $subject . "
                    </h2>
                    <p style='font-size: 16px; line-height: 1.6; opacity: 0.8; color: #f3f3f3; margin-top: 20px;'>
                        " . $_POST['message'] . "
                    </p>
                    <br>
                    <p style='font-size: 14px; color: #999999; border-top: 1px solid #444444; padding-top: 15px;'>
                        Membre : <span style='color: #ffffff; font-weight: bold;'>" . $message_from_user . "</span> - 
                        <span style='color: #ffffff;'>" . $message_from_email . "</span>
                    </p>
                </div></div>";

                $mailDetails = [
                    'destinataire' => "trashkan18@gmail.com",
                    'expediteur' => $admin_name,
                    'email' => $admin_sender_email,
                    'sujet' => $subject,
                    'message' => $message_content,
                ];


                if (verifContact($mailDetails)) {
                    if ($mail = sendMail($mailDetails['destinataire'], $mailDetails['expediteur'], $mailDetails['email'], $mailDetails['sujet'], $mailDetails['message'])) {
                        $message_erreur = "Votre mail a bien été envoyé !<br>";
                        $mailEnvoye = true;
                    } else {
                        $message_erreur = "<div class='text-orange-300'>Votre mail n'a pas été envoyé :(, veuillez réessayer.<br>To = $to ; Message From_user = $message_from_user ; Message_from_email = $message_from_email ; Code Expéditeur = $admin_name : Code Expéditeur/sender mail = $admin_sender_email ; subject = $subject ; message = $message <div><br>";
                        echo $message_erreur;
                        //$mailEnvoye = false;                     
                    }
                } else $message_erreur = "<div>Certains champs sont invalides.</div>";
            }

            $this->render("nous_contacter", ['loggedIn' => $loggedIn, 'message' => $message, 'error_message' => $error_message]);
        }

        public function notFound($params)
        {
            global $loggedIn, $message, $error_message;
            $disconnect = $params['deconnexion'] ?? null;

            if ((bool)$disconnect) {
                disconnect();
                header("Location: " . $GLOBALS['rootUrl'] . "/index.php?page=" . "404");
            }
            $this->render("404", ['loggedIn' => $loggedIn, 'message' => $message, 'error_message' => $error_message]);
        }
    }
