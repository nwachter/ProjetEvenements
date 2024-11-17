<nav class="w-full font-bold text-white h-full flex-none basis-7/8 h-32 px-16">
    <ul class="flex h-full items-center justify-between text-lg font-base mx-auto mb-2">
        <li class="">
            <a class="" aria-current="page" href="<?= $GLOBALS['rootUrl'] . "/index.php" ?>">Accueil</a>
        </li>
        <li class="">
            <a class="" href="<?= $GLOBALS['rootUrl'] . "/index.php?page=evenements.php" ?>">Evenements</a>
        </li>
        <li class="">
            <a class="" href="<?= $GLOBALS['rootUrl'] . "/index.php?page=connexion.php" ?>">Connexion</a>
        </li>
        <li class="">
            <a class="" href="<?= $GLOBALS['rootUrl'] . "/index.php?page=contact.php" ?>">Nous contacter</a>
        </li>
        <?php if (!isset($_SESSION['util_id'])) :     ?>
            <li class="" id="lien_connexion">
                <a class="" href="<?php $GLOBALS['rootUrl'] . "/index.php?page=connexion" ?>"> <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                    </svg></a>
            </li>
        <?php else : ?>
            <li class="">
                <a href="<?= $GLOBALS['rootUrl'] . "/index.php?page=profil" ?>" class=""><img src="<?= $GLOBALS['rootPath'] ?>/public/assets/images/pastille_util.png" id="pastille_util" placeholder="Pastille Utilisateur"></img>Profil</a>
            </li>
            <li class="">
                <a href="<?= $GLOBALS['rootUrl'] . "/index.php?deconnexion=true" ?>" class="">Deconnexion</a>
            </li>
        <?php endif; ?>
        <?php
        if (isset($_SESSION['session_id']) && $_SESSION['util_groupe'] == 1) :   ?>
            <li class="" id="lien_administration">
                <a class="" href="<?= $GLOBALS['rootUrl'] . "/index.php?page=administration.php" ?>">Administration</a>
            </li>
        <?php endif; ?>
    </ul>
</nav>