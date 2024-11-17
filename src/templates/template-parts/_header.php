<header class="rounded-2xl bg-[#05031b]  bg-opacity-80  relative z-[2]  h-full flex flex-col w-full">
    <div class="header_menu grid grid-cols-6 justify-between items-center py-4 px-8">
        <img id="logo" src="<?= $GLOBALS['rootUrl'] . "/public/assets/images/logo_black.png" ?>" class="object-contain shrink col-span-1 h-20" />

        <nav class="w-full col-span-5 text-white">
            <ul class="flex items-center justify-end space-x-8 text-lg font-medium">
                <li><a class="hover:text-[#fdb20b] transition-all" href="<?= $GLOBALS['rootUrl'] . "/accueil" ?>">Accueil</a></li>
                <li><a class="hover:text-[#fdb20b] transition-all" href="<?= $GLOBALS['rootUrl'] . "/nous_contacter" ?>">Nous contacter</a></li>

                <li class="relative">
                    <button id="userMenuButton" class="flex items-center focus:outline-none hover:text-[#fdb20b] transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                        </svg>
                    </button>
                    <ul id="userMenu" class="hidden absolute right-0 mt-2 w-48 bg-[#05031b] text-white border border-[#fdb20b] rounded-lg shadow-lg z-10">
                        <?php if (!$loggedIn): ?>
                            <li><a class="block px-4 py-2 hover:bg-[#fdb20b] hover:text-[#05031b] transition-all" href="<?= $GLOBALS['rootUrl'] . "/connexion" ?>">Connexion</a></li>
                            <li><a class="block px-4 py-2 hover:bg-[#fdb20b] hover:text-[#05031b] transition-all" href="<?= $GLOBALS['rootUrl'] . "/inscription" ?>">Inscription</a></li>
                        <?php endif; ?>
                        <?php if (isset($_SESSION['session_id'])) : ?>
                            <li><a class="block px-4 py-2 hover:bg-[#fdb20b] hover:text-[#05031b] transition-all" href="<?= $GLOBALS['rootUrl'] . "/profil" ?>">Profil</a></li>
                            <li><a class="block px-4 py-2 hover:bg-[#fdb20b] hover:text-[#05031b] transition-all" href="<?= $GLOBALS['rootUrl'] . "/index.php?page=" . $page . "&deconnexion=true" ?>">Déconnexion</a></li>
                        <?php endif; ?>

                    </ul>
                </li>

                <?php if (isset($_SESSION['session_id']) && in_array('Administrateur', $_SESSION['roles'])) : ?>
                    <li><a class="hover:text-[#fdb20b] transition-all" href="<?= $GLOBALS['rootUrl'] . "/administration" ?>">Administration</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
    <!-- <div class="header_hero grid grid-cols-1 items-center justify-center w-full h-full bg-[#05031b] bg-opacity-80">
        <h1 class="text-7xl w-full font-neon-club-music text-center animate-pulse  pb-6 text-white">Nin(j)a Events</h1>
        <div class="text-4xl font-wavefont text-white hover:text-[#fdb20b] transition-all"> -->
    <div class="header_hero flex flex-col items-center justify-center w-full pb-10 pt-10 old:bg-gradient-to-b old:from-[#05031b] old:to-[#0a0919]">
        <!-- <p class=" pr-[40%]  font-[500] text-5xl uppercase text-aero opacity-40 py-6">Bienvenue chez</p> -->
        <h1 class="text-7xl font-neon-club-music text-center  animate-pulse pb-6 text-white">Nin(j)a Events</h1>
        <div class="text-4xl hover:text-[#fdb20b] transition-all duration-300 text-white">
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:0;">O</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:1;">p</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:2;">e</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:3;">n</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:4;"> </span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:5;">y</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:6;">o</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:7;">u</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:8;">r</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:9;"> </span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:10;">m</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:11;">o</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:12;">u</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:13;">t</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:14;">h</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:15;"> </span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:16;">w</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:17;">i</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:18;">d</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:19;">e</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:20;"> </span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:21;">A</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:22;"> </span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:23;">u</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:24;">n</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:25;">i</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:26;">v</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:27;">e</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:28;">r</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:29;">s</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:30;">a</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:31;">l</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:32;"> </span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:33;">s</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:34;">i</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:35;">g</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:36;">h</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:37;"> </span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:38;">A</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:39;">n</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:40;">d</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:41;"> </span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:42;">w</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:43;">h</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:44;">i</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:45;">l</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:46;">e</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:47;"> </span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:48;">t</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:49;">h</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:50;">e</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:51;"> </span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:52;">o</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:53;">c</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:54;">e</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:55;">a</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:56;">n</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:57;"> </span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:58;">b</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:59;">l</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:60;">o</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:61;">o</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:62;">m</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:63;">s</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:64;"> </span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:65;">I</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:66;">t</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:67;">'s</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:68;"> </span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:69;">w</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:70;">h</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:71;">a</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:72;">t</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:73;"> </span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:74;">k</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:75;">e</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:76;">e</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:77;">p</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:78;">s</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:79;"> </span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:80;">m</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:81;">e</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:82;"> </span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:83;">a</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:84;">l</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:85;">i</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:86;">v</span>
            <span class="letter font-wavefont hover:text-[#fdb20b] transition-all" style="--i:87;">e</span>
        </div>
    </div>

</header>