<div class="container mx-auto p-8 bg-gray-900 text-white rounded-lg shadow-lg">
    <h1 class="text-3xl font-bold mb-6">Profil</h1>
    <div class="w-full mb-4">
        <div class="text-center text-lg text-red-500 mb-4"><?php if (isset($error_message)) echo $error_message; ?></div>
        <div class="text-center text-lg text-aero mb-4"><?php if (isset($message)) echo $message; ?></div>
    </div>

    <div class="grid gap-8 grid-cols-1 md:grid-cols-2">
        <div class="w-full max-w-4xl mx-auto p-4 sm:p-6 bg-gray-800 bg-opacity-70 rounded-lg shadow-lg text-white">
            <h3 class="text-3xl font-semibold mb-6 text-center text-melon">Profil Utilisateur</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                <?php
                $icons = [
                    'idUtilisateur' => 'fa-solid fa-id-card',
                    'nom' => 'fa-solid fa-signature',
                    'prenom' => 'fa-solid fa-face-smile',
                    'email' => 'fa-solid fa-envelope',
                    'designation' => 'fa-solid fa-building',
                    'roles' => 'fa-solid fa-list',
                ];

                foreach ($userInfo[0] as $key => $value):
                    $icon = $icons[$key] ?? $icons['nom'];
                ?>
                    <div class="flex items-center p-4 bg-gray-700 rounded-lg transition-all hover:bg-gray-600">
                        <i class="text-melon mr-4 text-2xl h-[24px] w-[24px] sm:text-xl sm:h-[20px] sm:w-[20px] <?php echo $icon; ?>"></i>

                        <div class="min-w-0">
                            <p class="text-sm text-gray-400 capitalize sm:text-xs hyphens-auto"><?php echo $key; ?></p>
                            <p class="text-lg font-semibold sm:text-base break-words hyphens-auto">
                                <?php
                                if (is_array($value)) {
                                    echo implode(', ', $value);
                                } else {
                                    echo htmlspecialchars($value);
                                }
                                ?>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="bg-gray-800 p-6 rounded-lg shadow-md">
            <h3 class="text-2xl font-semibold text-melon mb-4">Modifier le Mot de Passe</h3>
            <form action="/index.php?page=profil" id="motDePasse_form" name="motDePasse_form" method="POST">
                <fieldset class="space-y-4">

                    <div class="flex flex-col space-y-2">
                        <label for="old_motDePasse" class="text-sm">Ancien mot de passe</label>
                        <input type="password" id="old_motDePasse" name="old_motDePasse" class="p-2 bg-gray-700 text-white rounded-lg outline-none focus:ring-2 focus:ring-indigo-500">

                        <label for="new_motDePasse" class="text-sm">Nouveau mot de passe</label>
                        <input type="password" id="new_motDePasse" name="new_motDePasse" class="p-2 bg-gray-700 text-white rounded-lg outline-none focus:ring-2 focus:ring-indigo-500">

                        <label for="confirm_motDePasse" class="text-sm">Confirmation mot de passe</label>
                        <input type="password" id="confirm_motDePasse" name="confirm_motDePasse" class="p-2 bg-gray-700 text-white rounded-lg outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div class="text-center mt-4">
                        <input type="submit" name="submit_motDePasse" value="Modifier le mot de passe" class="bg-gradient-to-r from-auburn to-persian-red text-white px-6 py-2 font-semibold rounded-lg shadow-md hover:brightness-110 transition duration-300">
                    </div>
                </fieldset>
            </form>
        </div>
    </div>

    <?php if (isset($eventsOrganizedByUser) && $eventsOrganizedByUser != null): ?>
        <div class=" mt-12 w-full">
            <h2 class="text-4xl font-semibold  font-caudex text-melon mb-6">Événements organisés</h2>

            <?php foreach ($eventsOrganizedByUser as $event): ?>
                <div class="bg-gradient-to-br from-gray-800 to-gray-900 p-6 rounded-lg shadow-lg mb-6 transition-transform hover:scale-105 hover:shadow-xl duration-300">
                    <article>
                        <div class="flex gap-4 w-full min-w-0 items-center">
                            <h3 class="text-2xl flex-none basis-[90%] font-bold mb-2">
                                <div class="font-bentham text-selective-yellow">
                                    <span class="text-sm hyphens-auto break-words text-gray-500 pr-2">
                                        (<?= $event['idEvenement'] ?>)
                                    </span>
                                    <?= htmlspecialchars($event['titre']); ?>
                                </div>
                            </h3>
                            <div class="<?= $event['actif'] ? "text-mint border-mint border-[1px]" : "text-auburn border-auburn border-[1px]"; ?> text-[12px] rounded-full basis-auto text-center mr-3 px-2 py-1 w-fit italic mt-2">
                                <?= $event['actif'] ? "Actif" : "En attente"; ?>
                            </div>
                        </div>

                        <div class="mb-2.5">
                            <h4 class="text-lg font-medium opacity-80 text-aero"><?= htmlspecialchars($event['nomLieu']); ?></h4>
                            <p class="text-gray-300 text-[14px]"><?= htmlspecialchars($event['description']); ?></p>
                        </div>
                        <div class="flex gap-4 w-full min-w-0 items-center">
                            <div class="text-gray-400 italic text-sm hyphens-auto break-words "><?= htmlspecialchars($event['nom'] . " " . $event['prenom']); ?></div>
                            <div class="text-gray-400 text-sm hyphens-auto break-words">
                                Événement prévu le : <span class="text-white"><?= htmlspecialchars($event['dateEvenement']); ?></span>
                            </div>
                        </div>



                        <form action="index.php?page=modifier_evenement<?php echo "&idEvenement=" . $event['idEvenement']; ?>" method="POST" id="form_modifier" class="mt-4">
                            <input type="hidden" name="idEvenement" id="idEvenement" value="<?= $event['idEvenement'] ?>">
                            <input type="submit" name="submit_modifier" id="submit_modifier" value="Modifier l'événement" class="bg-gradient-to-r font-semibold from-melon to-selective-yellow text-white px-6 py-2 rounded-lg shadow-md hover:brightness-110 transition duration-300">
                        </form>
                    </article>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>


    <div class="w-full pt-6">
        <div class="flex w-[50%] mx-auto h-8 rounded justify-center gap-2 items-center">
            <?php foreach (range(0, $totalPagesEvents - 1) as $page) {
            ?>

                <a href="<?= $GLOBALS['rootUrl'] . '/index.php?page=profil&nb=' . ($page + 1) ?>" class="<?= (int)$nb === (int)$page + 1 ? "bg-selective-yellow/10 hover:border-selective-yellow text-selective-yellow" : "bg-slate-100/10 text-slate-100 hover:border-slate-100" ?> hover:border-x-[1px] cursor-pointer flex items-center rounded  justify-center text-[13px] font-semibold hover:filter hover:brightness-125 hover:bg-opacity-[15%] active:filter active:brightness-90 transition-all w-8 h-8 "><?= $page + 1 ?></a>
            <?php } ?>
        </div>
    </div>