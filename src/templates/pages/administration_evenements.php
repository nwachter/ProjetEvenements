<div id="container">
    <div>
        <?php
        echo "Affiche infos sur session? : <br>";
        echo '$_SESSION Tableau : ' . var_dump($_SESSION) . "<br>";
        echo '$_GET Tableau : ' . var_dump($_GET) . "<br>";
        if (isset($_GET['deconnexion'])) {
            echo "<br><br> Deconnexion existe, infos : " . $_GET['deconnexion'];
        }
        ?>
    </div>

    <?php if (isset($_SESSION['session_id']) && in_array($_SESSION['roles'] === "Administrateur", $_SESSION['roles'])) {  ?>

        <div class="events">

            <?php

            if (isset($_POST["submit_rech"])) {
                echo "isset rech_submit!<br />";
                print_r($_GET . "<br><br>");

                $events = getEvents();

                $x = 0;
                foreach ($events as $event) :
                    $numEvent = $numEvent + 1;
                    $auteur = $event['designation'];
                    $lieu = $event['nomLieu'];

            ?>

                    <h1>Recherche de Events</h1>

                    <h2>Résultats de la Recherche :</h2>

                    <article class="event">
                        <h2><?php echo $numEvent; ?>
                            <div class="infos intitule varphp"><?php echo $event['titre']; ?></div>
                        </h2>
                        <div class="infos lieu">
                            <h3 class="lieu infos_lieu boldred"><?php echo $lieu['nomLieu']; ?></h3>
                            <p class="infos infos_lieu"><?php echo $lieu['adresse']; ?>
                            </p>

                        </div>

                        <div class="infos varphp"><?php echo "Event prévue le : " . $event['dateEvenement']; ?></div> <br>
                        <div class="infos varphp"><?php echo $event['description']; ?></div><br>
                        <div class="infos varphp boldred"><i><?php echo $auteur; ?></i></div><br>
                    </article>

                <?php endforeach ?>

            <?php } else {
                echo "Bouton submit non cliqué (onsubmit bloqué) - Affichage de TOUTES LES SORTIES :<br /> " . print_r($_POST) . "<br />";
            ?>

                <h1>Liste des Evènements</h1>


                <?php

                $option = ' WHERE idLieu=1';
                $events = getEvents($option);

                $x = 0;
                foreach ($events as $event) :
                    $numEvent = $numEvent + 1;
                    $auteur = $event['designation'];
                    $lieu = $event['nomLieu'];
                ?>

                    <article class="event">
                        <h2><?php echo $numEvent; ?>
                            <div class="infos intitule varphp"><?php echo $event['titre']; ?></div>
                        </h2>
                        <div class="infos lieu">
                            <h3 class="lieu infos_lieu boldred"><?php echo $lieu['nomLieu']; ?></h3>
                            <p class="infos infos_lieu"><?php echo $lieu['adresse']; ?>
                            </p>

                        </div>

                        <div class="infos varphp"><?php echo "Event prévue le : " . $event['dateEvenement'] ?></div> <br>
                        <div class="infos varphp"><?php echo $event['description']; ?></div><br>
                        <div class="infos varphp boldred"><i><?php echo $auteur['designation']; ?></i></div><br>
                    </article>

                <?php endforeach ?>

        </div>

    <?php } ?>

</div>

<?php } else {
        echo "Vous ne pouvez pas accéder à cette page.";
    }
?>