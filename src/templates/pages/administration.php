<div id="admin_container" class="old:bg-purple-300 py-10 my-10 px-10  bg-[#05031b] bg-opacity-70 old:bg-opacity-5 mx-4 text-gray-200 rounded-lg shadow-md">
    <?php if (isset($error_message)): ?>
        <div class="bg-auburn text-white border border-red-500 p-4 mb-4 rounded">
            <?= $error_message ?>
        </div>
    <?php endif; ?>

    <?php if (isset($message)): ?>
        <div class=" bg-custom-green-700 text-white border border-mint p-4 mb-4 rounded">
            <?= $message ?>
        </div>
    <?php endif; ?>


    <div class="administration_zone">
        <h1 class="text-5xl font-bold opacity-90  text-selective-yellow mb-4 border-b font-bentham  border-gray-700 pb-2">Zone d'Administration</h1>
        <div class="mb-8">
            <h1 class="text-3xl font-bold mb-6 text-melon-50 border-b border-melon pb-2"><a id="utilisateurs">Utilisateurs</a></h1>
            <div class="grid grid-cols-1 gap-3">
                <?php foreach ($users as $user): ?>
                    <div class=" bg-white bg-opacity-10 rounded-lg overflow-hidden shadow-md transition-all duration-300 hover:shadow-indigo-500/30 hover:bg-gray-750 transition-all">
                        <div class="px-3 py-2 flex justify-between items-center">
                            <div class="flex-grow">
                                <h3 class="text-[15px] font-semibold text-indigo-200">
                                    <?= $user['prenom'] . ' ' . $user['nom'] ?>
                                    <span class="text-[14px] font-normal text-gray-400 ml-1">#<?= $user['idUtilisateur'] ?></span>
                                </h3>
                                <p class="text-[14px] text-gray-400 mt-0.5">
                                    Roles : <?= implode(', ', $user['roles']) ?>
                                </p>
                            </div>
                            <button class="text-indigo-300 hover:text-indigo-100 transition-colors duration-200" onclick="toggleForm(<?= $user['idUtilisateur'] ?>)">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                        </div>
                        <div id="form_<?= $user['idUtilisateur'] ?>" class="hidden p-3 bg-gray-750 border-t border-gray-700 transition-all">
                            <form action="index.php?page=administration&idUtilisateur=<?= $user['idUtilisateur'] ?>" method="POST" class="space-y-2 transition-all">
                                <div>
                                    <label for="roles_<?= $user['idUtilisateur'] ?>" class="block text-xs font-medium text-indigo-300 mb-1">Changer de rôle</label>
                                    <select name="roles[]" id="roles_<?= $user['idUtilisateur'] ?>" class="w-full p-1 text-xs bg-gray-700 text-gray-200 border border-gray-600 rounded focus:outline-none focus:ring-1 focus:ring-indigo-500" multiple>
                                        <?php foreach ($roles as $role): ?>
                                            <?php $isSelected = in_array($role, $user['roles'], true); ?>
                                            <option value="<?= htmlspecialchars($role); ?>" class="<?= $isSelected ? 'bg-indigo-600 text-white' : ''; ?>" <?= $isSelected ? 'selected' : ''; ?>>
                                                <?= htmlspecialchars($role); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="flex space-x-2">
                                    <button type="submit" name="updateRoles" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white py-1 px-2 rounded text-xs transition-colors duration-200">
                                        Changer
                                    </button>
                                    <button type="submit" name="deleteUser" class="flex-1 bg-red-600 hover:bg-red-700 text-white py-1 px-2 rounded text-xs transition-colors duration-200">
                                        Supprimer
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="w-full pt-6">
                <div class="flex w-[50%] mx-auto h-8 rounded justify-center gap-2 items-center">
                    <?php foreach (range(0, $totalPagesUsers - 1) as $page) {
                    ?>

                        <a href="<?= $GLOBALS['rootUrl'] . '/index.php?page=administration&nb=' . ($page + 1)  . '#utilisateurs' ?>" class="<?= (int)$nb === (int)$page + 1 ? "bg-selective-yellow/10 hover:border-selective-yellow text-selective-yellow" : "bg-slate-100/10 text-slate-100 hover:border-slate-100" ?> hover:border-x-[1px] cursor-pointer flex items-center rounded  justify-center text-[13px] font-semibold hover:filter hover:brightness-125 hover:bg-opacity-[15%] active:filter active:brightness-90 transition-all w-8 h-8 "><?= $page + 1 ?></a>
                    <?php } ?>
                </div>
            </div>
        </div>

        <script>
            function toggleForm(userId) {
                const form = document.getElementById(`form_${userId}`);
                form.classList.toggle('hidden');
            }
        </script>

        <div class="w-full">
            <?php if ($activeEvents != null || $inactiveEvents != null): ?><h1 class="text-3xl font-bold mb-4  text-melon-50 border-b border-melon">Evenements
                </h1>
            <?php endif; ?>
            <?php if ($inactiveEvents != null): ?>
                <div class="w-full">
                    <h2 class="text-xl font-bold mb-4 mt-8 text-indigo-300 border-b border-indigo-700"><a id="evenements_inactifs">Evenements en cours de vérification</a>
                    </h2>
                    <table class="w-full table-auto text-left border-separate border-spacing-y-2 mb-6  border-spacing-x-1 shadow-md">
                        <thead class="bg-gray-700 text-gray-300 tracking-wider">
                            <tr>
                                <th class="p-2 capitalize rounded-tl-lg w-1/12">Ref</th>
                                <th class="p-2 capitalize w-2/12">Titre</th>
                                <th class="p-2 capitalize w-1/12">Lieu</th>
                                <th class="p-2 capitalize w-1/12">Date</th>
                                <th class="p-2 capitalize w-3/12">Informations</th>
                                <th class="p-2 capitalize w-2/12">Auteur</th>
                                <th class="p-2 capitalize rounded-tr-lg w-2/12">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-gray-800 hover:filter hover:brightness-125 active:filter active:brightness-90 transition-all">
                            <?php foreach ($inactiveEvents as $inactiveEvent): ?>
                                <tr class="text-sm text-slate-300">
                                    <td class="p-2 rounded-l-lg"><?= $inactiveEvent['idEvenement'] ?></td>
                                    <td class="p-2"><?= $inactiveEvent['titre'] ?></td>
                                    <td class="p-2"><?= $inactiveEvent['nomLieu'] ?></td>
                                    <td class="p-2"><?= $inactiveEvent['dateEvenement'] ?></td>
                                    <td class="p-2 w-3/12">
                                        <div class="line-clamp-2 overflow-hidden text-ellipsis">
                                            <?= $inactiveEvent['description'] ?>
                                        </div>
                                    </td>
                                    <td class="p-2"><i><?= $inactiveEvent['designationOrganisateur'] ?></i></td>
                                    <td class="p-2 rounded-r-lg">
                                        <div class="flex space-x-2">
                                            <form action="<?= $GLOBALS['rootUrl'] . "/index.php?page=administration" ?>" method="POST">
                                                <input type="hidden" name="idEvenement" value="<?= htmlspecialchars($inactiveEvent['idEvenement']); ?>">
                                                <button type="submit" name="validateEvent" value="validate" class="bg-green-600 hover:bg-green-700 text-white py-1 px-3 rounded cursor-pointer">
                                                    Valider
                                                </button>
                                            </form>
                                            <form action="<?= $GLOBALS['rootUrl'] . "/index.php?page=administration" ?>" method="POST">
                                                <input type="hidden" name="idEvenement" value="<?= htmlspecialchars($inactiveEvent['idEvenement']); ?>">
                                                <button type="submit" name="deleteEvent" value="delete" class="bg-red-600 hover:bg-red-700 text-white py-1 px-3 rounded cursor-pointer">
                                                    Supprimer
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="w-full pt-6">
                        <div class="flex w-[50%] mx-auto h-8 rounded justify-center gap-2 items-center">
                            <?php foreach (range(0, $totalPagesInactiveEvents - 1) as $page) {
                            ?>

                                <a href="<?= $GLOBALS['rootUrl'] . '/index.php?page=administration&nb_ina=' . ($page + 1)  . '#evenements_inactifs' ?>" class="<?= (int)$nb_ina === (int)$page + 1 ? "bg-selective-yellow/10 hover:border-selective-yellow text-selective-yellow" : "bg-slate-100/10 text-slate-100 hover:border-slate-100" ?> hover:border-x-[1px] cursor-pointer flex items-center rounded  justify-center text-[13px] font-semibold hover:filter hover:brightness-125 hover:bg-opacity-[15%] active:filter active:brightness-90 transition-all w-8 h-8 "><?= $page + 1 ?></a>
                            <?php } ?>
                        </div>
                    </div>

                </div>
            <?php endif; ?>

            <?php if ($activeEvents != null): ?>
                <div class="w-full">

                    <h2 class="text-xl font-bold mb-4  text-indigo-300 border-b border-indigo-700"><a id="evenements_actifs">Evenements actifs</a>
                    </h2>
                    <table class="w-full table-auto text-left border-separate border-spacing-y-2 border-spacing-x-1 shadow-md">
                        <thead class="bg-gray-700 text-gray-300 tracking-wider">
                            <tr>
                                <th class="p-2 capitalize rounded-tl-lg w-1/12">Ref</th>
                                <th class="p-2 capitalize w-2/12">Titre</th>
                                <th class="p-2 capitalize w-1/12">Lieu</th>
                                <th class="p-2 capitalize w-1/12">Date</th>
                                <th class="p-2 capitalize w-3/12">Informations</th>
                                <th class="p-2 capitalize w-2/12">Auteur</th>
                                <th class="p-2 capitalize rounded-tr-lg w-2/12">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-gray-800 hover:filter hover:brightness-125 active:filter active:brightness-90 transition-all">
                            <?php foreach ($activeEvents as $index => $activeEvent): ?>
                                <tr class="text-sm text-slate-300">
                                    <td class="p-2 rounded-l-lg"><?= $activeEvent['idEvenement'] ?></td>
                                    <td class="p-2"><?= $activeEvent['titre'] ?></td>
                                    <td class="p-2"><?= $activeEvent['nomLieu'] ?></td>
                                    <td class="p-2"><?= $activeEvent['dateEvenement'] ?></td>
                                    <td class="p-2 w-3/12">
                                        <div class="line-clamp-2 overflow-hidden text-ellipsis">
                                            <?= $activeEvent['description'] ?>
                                        </div>
                                    </td>
                                    <td class="p-2"><i><?= $activeEvent['designationOrganisateur'] ?></i></td>
                                    <td class="p-2 rounded-r-lg">
                                        <div class="flex space-x-2">
                                            <form action="administration.php" method="POST">
                                                <input type="hidden" name="idEvenement" value="<?= $activeEvent['idEvenement'] ?>">
                                                <input type="submit" name="deleteEvent" value="Supprimer" class="bg-red-600 hover:bg-red-700 text-white py-1 px-3 rounded cursor-pointer">
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="w-full pt-6">
                        <div class="flex w-[50%] mx-auto h-8 rounded justify-center gap-2 items-center">
                            <?php foreach (range(0, $totalPagesActiveEvents - 1) as $page) {
                            ?>

                                <a href="<?= $GLOBALS['rootUrl'] . '/index.php?page=administration&nb_act=' . ($page + 1) . '#evenements_actifs' ?>" class="<?= (int)$nb_act === (int)$page + 1 ? "bg-selective-yellow/10 hover:border-selective-yellow text-selective-yellow" : "bg-slate-100/10 text-slate-100 hover:border-slate-100" ?> hover:border-x-[1px] cursor-pointer flex items-center rounded  justify-center text-[13px] font-semibold hover:filter hover:brightness-125 hover:bg-opacity-[15%] active:filter active:brightness-90 transition-all w-8 h-8 "><?= $page + 1 ?></a> <?php } ?>
                        </div>
                    </div>

                </div>
            <?php endif; ?>
        </div>






    </div>
</div>