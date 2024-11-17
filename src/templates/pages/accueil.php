<div class="relative  w-full pb-8 px-4 z-[2] ">
    <div class="relative text-white w-full">


        <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger p-4 text-center mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"> <span class="font-medium">Erreur : </span><span><?= $error_message ?></span></div>
        <?php endif; ?>
        <?php if (!empty($message)): ?>
            <div class="alert alert-info text-center p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400">
                <span class="font-medium">Succès !</span> <span><?= $message ?></span>
            </div>
        <?php endif; ?>

        <div class="w-full mb-10">
            <form action="<?= $GLOBALS['rootUrl'] . "/index.php?page=accueil" ?>" class="w-full max-w-4xl items-center mx-auto max-md:flex-col flex gap-6 max-md:gap-2" name="search" method="POST">
                <div class=" md:basis-[20%] max-md:w-[50%]">
                    <label for="date" class="block text-lg font-medium mb-1">Date</label>
                    <div class="bg-gradient-to-r from-indigo-500 to-pink-500 rounded-[15px] p-px">
                        <input type="date" name="date" value="" class="w-full h-12 bg-[#05031b] text-white px-2 py-2 rounded-[15px] outline-none" placeholder="Entrez une date">
                    </div>

                </div>

                <div class=" md:basis-[20%] max-md:w-[50%]">
                    <label for="location" class="block text-lg font-medium mb-1">Lieu</label>
                    <div class="bg-gradient-to-r from-indigo-500 to-pink-500 rounded-[15px] p-px">
                        <select name="location" id="location" class="w-full h-12 px-2 bg-[#05031b] text-white rounded-[15px] outline-none">
                            <option value="">Tous</option>
                            <?php foreach ($locations as $location) : ?>
                                <option value="<?= htmlspecialchars($location['nomLieu']); ?>">
                                    <?= htmlspecialchars($location['nomLieu']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class=" md:basis-[20%] max-md:w-[50%]">
                    <label for="organizer" class="block text-lg font-medium mb-1">Organisateur</label>
                    <div class="bg-gradient-to-r from-indigo-500 to-pink-500 rounded-[15px] p-px">
                        <select name="organizer" id="organizer" class="w-full h-12 px-2 bg-[#05031b] text-white rounded-[15px] outline-none">
                            <option value="">Tous</option>
                            <?php foreach ($organizers as $organizer) : ?>
                                <option value="<?= $organizer['idUtilisateur']; ?>">
                                    <?= htmlspecialchars($organizer['designation']) . " - " . htmlspecialchars($organizer['email']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class=" md:basis-[30%] max-md:w-[50%]">
                    <label for="keywords" class="block text-lg font-medium mb-1">Mots-clés</label>
                    <div class="bg-gradient-to-r from-indigo-500 to-pink-500 rounded-[15px] p-px">
                        <input name="keywords" value="" class="w-full h-12 bg-[#05031b] text-white py-2 px-2  rounded-[15px] outline-none" placeholder="Entrez des mots-clés">
                    </div>
                </div>

                <div class="self-center md:basis-[10%] max-md:w-[40%] max-md:min-w-[40%]">
                    <label class="block text-lg font-medium mb-1 h-[1.75rem] w-full"></label>
                    <button type="submit" name="search" class="bg-gradient-to-r w-full from-indigo-500 to-pink-500 border-[1px] border-white/50 rounded-[15px] p-px px-2 h-12 py-2 flex hover:filter hover:brightness-125 active:filter active:brightness-90 transition-all items-center justify-center cursor-pointer" id="search-button">Rechercher</button>
                </div>
            </form>

        </div>

        <h1 class="pl-10 text-5xl font-bold font-cabin text-melon-100 old:border-y-2 py-10 old:border-spacing-y-40 w-full opacity-90">Tous les Evenements</h1>


        <?php if ($loggedIn && in_array('Organisateur', $_SESSION['roles'])) : ?>
            <div class="pb-6">
                <form method="POST" id="form_organiser" name="form_organiser" action="<?= $GLOBALS['rootUrl'] . "/index.php?page=organiser" ?>" class="w-full flex justify-center items-center h-auto mt-6">
                    <button type="submit" name="submit_organiser" id="submit_organiser" class=" font-allan  outline-double outline-melon bg-melon/10 bg-opacity-55 rounded-[15px] border-1  shadow-2xl hover:filter hover:brightness-125 animate-chromatic-title active:filter active:brightness-90 transition-all w-[15rem] h-[5rem] min-w-[12rem] max-h-[4rem]  text-center text-melon-50 font-bold text-xl" value="Rejoindre l'Evènement">Organiser un Evènement</button>
                </form>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 px-6 w-full">
            <?php foreach ($events as $event) :  ?>

                <article class="flex h-full flex-col md:flex-row bg-gray-800 bg-opacity-70 p-4 rounded-lg shadow-lg mb-4 w-full ">
                    <img src="<?= $GLOBALS['rootUrl'] . $event['image']; ?>" alt="event image"
                        class="w-full md:w-1/3 h-[400px] md:h-auto md:mr-4 rounded-lg object-cover mb-4 md:mb-0">

                    <div class="flex-1 flex flex-col h-full">
                        <div class="relative">
                            <h2 class="text-xl w-fit relative font-bold mb-2">
                                <a class="font-bentham text-selective-yellow  hover:underline hover:filter hover:brightness-110 font-[300] active:filter active:brightness-90 transition-all" href="<?= $GLOBALS['rootUrl'] ?>?page=evenement&idEvenement=<?= $event['idEvenement'] ?>">
                                    <?= htmlspecialchars($event['titre']); ?>
                                </a>
                                <span class="title-underline absolute top-[1.5rem] left-0 h-[2px] bg-selective-yellow w-[40%] [box-shadow:_2px_1px_0_#DB324D,_-1px_-2px_0_#5BC0EB]"></span>
                            </h2>


                            <div class="text-base text-melon-50 leading-normal font-cabin opacity-90 text-[13px] mb-2"><?= htmlspecialchars($event['description']); ?></div>
                            <div class="text-base font-cabin text-[13px] opacity-80  mb-2">
                                Organisé par : <span class="font-cabin text-melon-50"><?= htmlspecialchars($event['designationOrganisateur'] ?? 'Autre'); ?></span>
                            </div>
                            <div class="text-base text-[13px] font-cabin opacity-80  mb-2">Date : <span class="font-cabin"><?= htmlspecialchars($event['dateEvenement']); ?></span></div>
                            <div class="opacity-80 text-[13px] font-cabin  text-base"><?= "Inscrits : " . $event['nbInscrits'] . " / " . htmlspecialchars($event['nbPlaces']); ?></div>
                        </div>

                        <div class="h-full w-full flex items-center justify-center">
                            <?php
                            if (isset($_SESSION['session_id'])) {
                                if (($_SESSION['roles'] === 'Utilisateur' || in_array('Utilisateur', $_SESSION['roles'])) && !isset($event['idUtilisateur'])) { ?>
                                    <div class="w-full h-full flex items-end justify-center">
                                        <div class=" h-[5rem] pt-4 w-full rounded-md">
                                            <form method="POST" id="form_inscrire" class="w-full flex justify-center items-end h-auto" name="form_inscrire" action="<?= $GLOBALS['rootUrl'] . '/index.php?page=accueil&idEvenement=' . $event['idEvenement']; ?>">

                                                <button type="submit" name="submit_inscrire" id="submit_inscrire" class=" font-echo-deco outline-double outline-melon/70 bg-melon/10 bg-opacity-85 rounded-[15px]  shadow-2xl hover:filter border-transparent hover:border-melon-50/20 border-dotted border-spacing-7 hover:border-2 hover:brightness-125 active:filter active:brightness-90 transition-all w-[10rem] h-[2.5rem] min-w-[10rem] max-h-[4rem]  text-center text-melon-50 font-light text-xl" value="Rejoindre l'Evènement">Participer</button>
                                            </form>
                                        </div>
                                    </div>

                                <?php
                                } elseif ($event['idUtilisateur'] && in_array("Utilisateur", $_SESSION['roles'])) { ?>
                                    <div class="alert alert-info text-center p-4 text-sm text-mint border-[0.5px] border-mint/20 rounded-lg bg-green-50 items-center flex gap-3   dark:bg-emerald-950/40  old:dark:bg-gray-800 dark:text-green-400">
                                        <p class="enrollment-msg hyphens-auto w-full">Vous êtes inscrit à cet évènement</p>
                                        <form method="POST" name="form_desinscrire" action="<?= $GLOBALS['rootUrl'] . '/index.php?page=accueil&idEvenement=' . $event['idEvenement']; ?>">
                                            <button name="submit_desinscrire" id="submit_desinscrire"><img src="<?= $GLOBALS['rootUrl'] . '/public/assets/images/icons/trashbin_icon.svg' ?>" alt="Unenroll trashbin icon" class="w-6 h-6 hover:filter hover:brightness-125 active:filter active:brightness-90 transition-all cursor-pointer text-auburn"></button>
                                        </form>

                                    </div>
                                <?php
                                }
                            } else { ?>
                                <div class="h-full flex items-center justify-center">
                                    <p class="bg-yellow-200 text-[#0a0919] rounded-xl text-sm border-1 border-slate-400 p-3 text-center">
                                        Connectez-vous pour vous inscrire aux évènements.
                                    </p>
                                </div>

                            <?php } ?>
                        </div>



                    </div>
                </article>

            <?php endforeach; ?>
        </div>
        <div class="w-full pt-6">
            <div class="flex w-[50%] mx-auto h-8 rounded justify-center gap-2 items-center">
                <?php foreach (range(0, $totalPagesEvents - 1) as $page) {
                ?>

                    <a href="<?= $GLOBALS['rootUrl'] . '/index.php?page=accueil&nb=' . ($page + 1) ?>" class="<?= (int)$nb === (int)$page + 1 ? "bg-selective-yellow/10 hover:border-selective-yellow text-selective-yellow" : "bg-slate-100/10 text-slate-100 hover:border-slate-100" ?> hover:border-x-[1px] cursor-pointer flex items-center rounded  justify-center text-[13px] font-semibold hover:filter hover:brightness-125 hover:bg-opacity-[15%] active:filter active:brightness-90 transition-all w-8 h-8 "><?= $page + 1 ?></a>
                <?php } ?>
            </div>
        </div>
    </div>
</div>