<nav class="w-full bg-[#05031b]/90 backdrop-blur-md border-b border-[#fdb20b]/10 py-4 px-6 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto">
        <div class="flex items-center justify-between">
            <a href="<?= $GLOBALS['rootUrl'] . "/index.php" ?>" class="flex items-center">
                <img src="<?= $GLOBALS['rootUrl'] . "/public/assets/images/logo_black.png" ?>" alt="Ninja Events Logo" class="h-12 w-auto">
            </a>

            <div class="hidden md:flex items-center space-x-8">
                <a href="<?= $GLOBALS['rootUrl'] . "/index.php" ?>" class="text-white hover:text-[#fdb20b] transition-all duration-300 font-medium relative after:absolute after:bottom-0 after:left-0 after:h-[2px] after:w-0 after:bg-[#fdb20b] after:transition-all hover:after:w-full">Accueil</a>
                <a href="<?= $GLOBALS['rootUrl'] . "/index.php?page=evenements.php" ?>" class="text-white hover:text-[#fdb20b] transition-all duration-300 font-medium relative after:absolute after:bottom-0 after:left-0 after:h-[2px] after:w-0 after:bg-[#fdb20b] after:transition-all hover:after:w-full">Événements</a>
                <a href="<?= $GLOBALS['rootUrl'] . "/index.php?page=contact.php" ?>" class="text-white hover:text-[#fdb20b] transition-all duration-300 font-medium relative after:absolute after:bottom-0 after:left-0 after:h-[2px] after:w-0 after:bg-[#fdb20b] after:transition-all hover:after:w-full">Nous contacter</a>

                <?php if (!isset($_SESSION['util_id'])) : ?>
                    <a href="<?= $GLOBALS['rootUrl'] . "/index.php?page=connexion.php" ?>" class="bg-[#fdb20b] hover:bg-[#fdb20b]/80 text-[#05031b] px-4 py-2 rounded-lg font-medium transition-all duration-300 transform hover:translate-y-[-2px] hover:shadow-lg hover:shadow-[#fdb20b]/20">Connexion</a>
                <?php else : ?>
                    <a href="<?= $GLOBALS['rootUrl'] . "/index.php?page=profil" ?>" class="flex items-center text-white hover:text-[#fdb20b] transition-all duration-300 font-medium">
                        <img src="<?= $GLOBALS['rootPath'] ?>/public/assets/images/pastille_util.png" alt="Profil" class="w-8 h-8 rounded-full mr-2">
                        Profil
                    </a>
                    <a href="<?= $GLOBALS['rootUrl'] . "/index.php?deconnexion=true" ?>" class="text-white hover:text-[#fdb20b] transition-all duration-300 font-medium">Déconnexion</a>
                <?php endif; ?>

                <?php if (isset($_SESSION['session_id']) && $_SESSION['util_groupe'] == 1) : ?>
                    <a href="<?= $GLOBALS['rootUrl'] . "/index.php?page=administration.php" ?>" class="text-white hover:text-[#fdb20b] transition-all duration-300 font-medium">Administration</a>
                <?php endif; ?>
            </div>

            <button id="mobile-menu-button" class="md:hidden text-white hover:text-[#fdb20b] transition-all duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <div id="mobile-menu" class="md:hidden hidden pt-4 pb-2">
            <div class="flex flex-col space-y-4">
                <a href="<?= $GLOBALS['rootUrl'] . "/index.php" ?>" class="text-white hover:text-[#fdb20b] transition-all duration-300 font-medium py-2">Accueil</a>
                <a href="<?= $GLOBALS['rootUrl'] . "/index.php?page=evenements.php" ?>" class="text-white hover:text-[#fdb20b] transition-all duration-300 font-medium py-2">Événements</a>
                <a href="<?= $GLOBALS['rootUrl'] . "/index.php?page=contact.php" ?>" class="text-white hover:text-[#fdb20b] transition-all duration-300 font-medium py-2">Nous contacter</a>

                <?php if (!isset($_SESSION['util_id'])) : ?>
                    <a href="<?= $GLOBALS['rootUrl'] . "/index.php?page=connexion.php" ?>" class="bg-[#fdb20b] hover:bg-[#fdb20b]/80 text-[#05031b] px-4 py-2 rounded-lg font-medium transition-all duration-300 text-center">Connexion</a>
                <?php else : ?>
                    <a href="<?= $GLOBALS['rootUrl'] . "/index.php?page=profil" ?>" class="flex items-center text-white hover:text-[#fdb20b] transition-all duration-300 font-medium py-2">
                        <img src="<?= $GLOBALS['rootPath'] ?>/public/assets/images/pastille_util.png" alt="Profil" class="w-8 h-8 rounded-full mr-2">
                        Profil
                    </a>
                    <a href="<?= $GLOBALS['rootUrl'] . "/index.php?deconnexion=true" ?>" class="text-white hover:text-[#fdb20b] transition-all duration-300 font-medium py-2">Déconnexion</a>
                <?php endif; ?>

                <?php if (isset($_SESSION['session_id']) && $_SESSION['util_groupe'] == 1) : ?>
                    <a href="<?= $GLOBALS['rootUrl'] . "/index.php?page=administration.php" ?>" class="text-white hover:text-[#fdb20b] transition-all duration-300 font-medium py-2">Administration</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>