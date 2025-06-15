<div class="relative w-full pb-8 px-4 z-[2]">
    <div class="relative text-white w-full max-w-7xl mx-auto">
        <!-- Alert Messages -->
        <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger p-4 text-center mb-6 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800/60 dark:text-red-400 backdrop-blur-sm">
                <span class="font-medium">Erreur : </span><span><?= $error_message ?></span>
            </div>
        <?php endif; ?>

        <?php if (!empty($message)): ?>
            <div class="alert alert-info text-center p-4 mb-6 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800/60 dark:text-green-400 backdrop-blur-sm">
                <span class="font-medium">Succès ! </span><span><?= $message ?></span>
            </div>
        <?php endif; ?>

        <!-- Search Form with Blue Background -->
        <div class="w-full mt-6 mb-12">
            <div class=" bg-[#05031b] backdrop-blur-md rounded-xl p-6 shadow-md shadow-[#fdb20b]/5">
                <h2 class="text-2xl font-bold text-white mb-6 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-[#fdb20b]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Rechercher un événement
                </h2>

                <form action="<?= $GLOBALS['rootUrl'] . "/index.php?page=accueil" ?>" class="min-w-full w-full max-w-5xl items-center justify-center max-md:flex-col flex flex-wrap gap-6 max-md:gap-4" name="search" method="POST">
                    <div class="md:basis-[20%] max-md:w-[48%]">
                        <label for="date" class="block text-lg font-medium mb-2">Date</label>
                        <div class="bg-gradient-to-r from-indigo-500 to-pink-500 rounded-[15px] p-px">
                            <div class="relative">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-3 top-1/2 transform -translate-y-1/2 text-[#fdb20b]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <input type="date" name="date" value="" class="w-full h-12 bg-[#05031b] text-white pl-10 pr-4 py-2 rounded-[15px] outline-none focus:bg-[#05031b]/80 transition-all duration-300" placeholder="Entrez une date">
                            </div>
                        </div>
                    </div>

                    <div class="md:basis-[20%] max-md:w-[48%]">
                        <label for="location" class="block text-lg font-medium mb-2">Lieu</label>
                        <div class="bg-gradient-to-r from-indigo-500 to-pink-500 rounded-[15px] p-px">
                            <div class="relative">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-3 top-1/2 transform -translate-y-1/2 text-[#fdb20b]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <select name="location" id="location" class="w-full h-12 pl-10 pr-4 bg-[#05031b] text-white rounded-[15px] outline-none focus:bg-[#05031b]/80 transition-all duration-300 appearance-none">
                                    <option value="">Tous</option>
                                    <?php foreach ($locations as $location) : ?>
                                        <option value="<?= htmlspecialchars($location['nomLieu']); ?>">
                                            <?= htmlspecialchars($location['nomLieu']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-white">
                                    <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="md:basis-[20%] max-md:w-[48%]">
                        <label for="organizer" class="block text-lg font-medium mb-2">Organisateur</label>
                        <div class="bg-gradient-to-r from-indigo-500 to-pink-500 rounded-[15px] p-px">
                            <div class="relative">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-3 top-1/2 transform -translate-y-1/2 text-[#fdb20b]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <select name="organizer" id="organizer" class="w-full h-12 pl-10 pr-4 bg-[#05031b] text-white rounded-[15px] outline-none focus:bg-[#05031b]/80 transition-all duration-300 appearance-none">
                                    <option value="">Tous</option>
                                    <?php foreach ($organizers as $organizer) : ?>
                                        <option value="<?= $organizer['idUtilisateur']; ?>">
                                            <?= htmlspecialchars($organizer['designation']) . " - " . htmlspecialchars($organizer['email']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-white">
                                    <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="md:basis-[25%] max-md:w-[48%]">
                        <label for="keywords" class="block text-lg font-medium mb-2">Mots-clés</label>
                        <div class="bg-gradient-to-r from-indigo-500 to-pink-500 rounded-[15px] p-px">
                            <div class="relative">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-3 top-1/2 transform -translate-y-1/2 text-[#fdb20b]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                </svg>
                                <input name="keywords" value="" class="w-full h-12 bg-[#05031b] text-white py-2 pl-10 pr-4 rounded-[15px] outline-none focus:bg-[#05031b]/80 transition-all duration-300" placeholder="Entrez des mots-clés">
                            </div>
                        </div>
                    </div>

                    <div class="self-end flex justify-center items-center md:basis-auto max-md:w-full">
                        <button type="submit" name="search" class="bg-gradient-to-r max-sm:w-1/2 w-auto from-indigo-500 to-pink-500 border-[1px] border-white/50 rounded-[15px] p-px h-12 py-2 flex hover:filter hover:brightness-125 active:filter active:brightness-90 transition-all items-center justify-center cursor-pointer" id="search-button">
                            <span class="flex items-center px-4 justify-center text-white font-medium">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="flex flex-col md:flex-row justify-between items-center mb-10 px-4">
            <h1 class="pl-0 md:pl-10 text-4xl md:text-5xl font-bold font-cabin text-melon-100 mb-6 md:mb-0 relative">
                Tous les Événements
                <span class="absolute bottom-0 left-0 md:left-10 h-[2px] w-[40%] bg-selective-yellow"></span>
            </h1>

            <?php if ($loggedIn && in_array('Organisateur', $_SESSION['roles'])) : ?>
                <div class="pb-0 md:pb-6">
                    <form method="POST" id="form_organiser" name="form_organiser" action="<?= $GLOBALS['rootUrl'] . "/index.php?page=organiser" ?>" class="w-full flex justify-center items-center h-auto">
                        <button type="submit" name="submit_organiser" id="submit_organiser" class="font-allan outline-double outline-melon bg-melon/10 bg-opacity-55 rounded-[15px] border-1 shadow-2xl hover:filter hover:brightness-125 animate-chromatic-title active:filter active:brightness-90 transition-all w-[15rem] h-[4rem] min-w-[12rem] text-center text-melon-50 font-bold text-xl" value="Rejoindre l'Evènement">
                            Organiser un Evènement
                        </button>
                    </form>
                </div>
            <?php endif; ?>
        </div>

        <!-- Events  -->
        <div class="grid grid-cols-1 lg:grid-cols-2 sm:gap-4 gap-3 px-4 w-full mb-10">
            <?php foreach ($events as $event) : ?>
                <article class="bg-[#05031b] bg-opacity-70 rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 hover:translate-y-[-3px] group">
                    <div class="relative h-64 overflow-hidden">
                        <img src="<?= $GLOBALS['rootUrl'] . $event['image']; ?>" alt="<?= htmlspecialchars($event['titre']); ?>"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">

                        <div class="absolute inset-0 bg-gradient-to-t from-[#05031b] to-transparent opacity-70"></div>

                        <div class="absolute top-4 right-4 bg-[#fdb20b] text-[#05031b] px-3 py-1 rounded-full font-medium text-sm flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <?= date('d M Y', strtotime($event['dateEvenement'])); ?>
                        </div>

                        <div class="absolute bottom-4 right-4 bg-[#05031b]/80 text-white px-3 py-1 rounded-full text-sm flex items-center backdrop-blur-sm border border-white/10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-[#fdb20b]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <?= $event['nbInscrits'] . " / " . htmlspecialchars($event['nbPlaces']); ?>
                        </div>
                    </div>

                    <div class="p-6">
                        <h2 class="text-[1.45rem] w-fit sm:min-h-[4rem] leading-tight relative font-bold mb-3">
                            <a class="font-bentham text-selective-yellow hover:filter  hover:brightness-110 font-[300] active:filter active:brightness-90 transition-all [text-shadow:_1px_0_0_#DB324D,_-1px_0_0_#5BC0EB]" href="<?= $GLOBALS['rootUrl'] ?>?page=evenement&idEvenement=<?= $event['idEvenement'] ?>">
                                <?= htmlspecialchars($event['titre']); ?>
                            </a>
                            <span class="title-underline absolute top-[1.5rem] left-0 h-[2px] bg-selective-yellow w-[40%] [box-shadow:_2px_1px_0_#DB324D,_-1px_-2px_0_#5BC0EB]"></span>
                        </h2>

                        <div class="text-base text-melon-50 leading-normal font-cabin opacity-90 text-[14px] mb-4 line-clamp-3">
                            <?= htmlspecialchars($event['description']); ?>
                        </div>

                        <div class="grid grid-cols-2 gap-3 mb-6">
                            <div class="flex items-center text-base font-cabin text-[14px] opacity-80">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-selective-yellow" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <span class="font-cabin text-melon-50"><?= htmlspecialchars($event['designationOrganisateur'] ?? 'Autre'); ?></span>
                            </div>

                            <div class="flex items-center text-base text-[14px] font-cabin opacity-80">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-selective-yellow" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span class="font-cabin"><?= htmlspecialchars($event['nomLieu']); ?></span>
                            </div>
                        </div>

                        <div class="mt-auto">
                            <?php if (isset($_SESSION['session_id'])) { ?>
                                <?php if (($_SESSION['roles'] === 'Utilisateur' || in_array('Utilisateur', $_SESSION['roles'])) && !isset($event['idUtilisateur'])) { ?>
                                    <div class="w-full flex items-end justify-center">
                                        <form method="POST" id="form_inscrire" class="w-full" name="form_inscrire" action="<?= $GLOBALS['rootUrl'] . '/index.php?page=accueil&idEvenement=' . $event['idEvenement']; ?>">
                                            <button type="submit" name="submit_inscrire" id="submit_inscrire" class="w-full font-echo-deco outline-double outline-melon/70 bg-melon/10 bg-opacity-85 rounded-[15px] shadow-2xl hover:filter border-transparent hover:border-melon-50/20 border-dotted border-spacing-7 hover:border-2 hover:brightness-125 active:filter active:brightness-90 transition-all h-[2.5rem] text-center text-melon-50 font-light text-xl" value="Rejoindre l'Evènement">
                                                Participer
                                            </button>
                                        </form>
                                    </div>
                                <?php } elseif ($event['idUtilisateur'] && in_array("Utilisateur", $_SESSION['roles'])) { ?>
                                    <div class="alert alert-info text-center p-4 text-sm text-mint border-[0.5px] border-mint/20 rounded-lg bg-green-50 items-center flex gap-3 dark:bg-emerald-950/40 dark:text-green-400">
                                        <p class="enrollment-msg hyphens-auto w-full">Vous êtes inscrit à cet évènement</p>
                                        <form method="POST" name="form_desinscrire" action="<?= $GLOBALS['rootUrl'] . '/index.php?page=accueil&idEvenement=' . $event['idEvenement']; ?>">
                                            <button name="submit_desinscrire" id="submit_desinscrire">
                                                <img src="<?= $GLOBALS['rootUrl'] . '/public/assets/images/icons/trashbin_icon.svg' ?>" alt="Unenroll trashbin icon" class="w-6 h-6 hover:filter hover:brightness-125 active:filter active:brightness-90 transition-all cursor-pointer text-auburn">
                                            </button>
                                        </form>
                                    </div>
                                <?php } ?>
                            <?php } else { ?>
                                <div class="bg-yellow-200 text-[#0a0919] rounded-xl text-sm border-1 border-slate-400 p-3 text-center">
                                    Connectez-vous pour vous inscrire aux évènements.
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

        <?php if ($totalPagesEvents > 1): ?>
            <div class="w-full pt-6">
                <div class="flex w-[50%] mx-auto h-8 rounded justify-center gap-2 items-center">
                    <?php foreach (range(0, $totalPagesEvents - 1) as $page): ?>
                        <a href="<?= $GLOBALS['rootUrl'] . '/index.php?page=accueil&nb=' . ($page + 1) ?>"
                            class="<?= (int)$nb === (int)$page + 1
                                        ? "bg-selective-yellow/10 hover:border-selective-yellow text-selective-yellow"
                                        : "bg-slate-100/10 text-slate-100 hover:border-slate-100" ?> 
                                hover:border-x-[1px] cursor-pointer flex items-center rounded justify-center text-[13px] font-semibold hover:filter hover:brightness-125 hover:bg-opacity-[15%] active:filter active:brightness-90 transition-all w-8 h-8">
                            <?= $page + 1 ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>