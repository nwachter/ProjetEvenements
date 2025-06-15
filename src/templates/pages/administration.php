    <div id="admin_container" class="min-h-screen max-w-7xl min-w-0 mt-12  max-md:w-full sm:mx-auto bg-gradient-to-r from-[#050321]/90 via-[#05031b]/90 to-[#05031b]/70 border-[1px] backdrop-blur-md border-white/10 rounded-xl py-3 px-4 sm:px-8 sm:pt-10 pt-6">
        <div class="max-w-7xl mx-auto">

            <!-- Error and Success Messages -->
            <?php if (isset($error_message) && !empty($error_message)): ?>
                <div class="bg-red-600/20 border border-red-500/50 text-red-300 p-4 mb-4 rounded-lg">
                    <?= $error_message ?>
                </div>
            <?php endif; ?>

            <?php if (isset($message) && !empty($message)): ?>
                <div class="bg-green-600/20 border border-green-500/50 text-green-300 p-4 mb-4 rounded-lg">
                    <?= $message ?>
                </div>
            <?php endif; ?>

            <!-- Header Section -->
            <div class="mb-6 sm:mb-8">
                <h1 class="text-2xl font-cabin sm:text-4xl md:text-5xl font-bold text-white mb-2 tracking-tight">
                    Administration
                </h1>
                <p class="text-slate-400 text-base sm:text-lg">Gérez les utilisateurs et événements de l'application</p>
            </div>

            <div class="mb-12">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="sm:text-2xl text-xl font-cabin font-bold text-white mb-1" id="utilisateurs">Utilisateurs</h2>
                        <p class="text-slate-400 text-sm">Gérez les rôles et permissions des utilisateurs</p>
                    </div>
                    <div class="bg-purple-500/20 text-purple-300 font-cabin px-4 py-2 rounded-lg text-sm font-medium">
                        <?= count($users) ?> utilisateurs
                    </div>
                </div>

                <div class="grid gap-2">
                    <?php foreach ($users as $user): ?>
                        <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl overflow-hidden hover:bg-white/10 transition-all duration-300 group">
                            <div class="px-3 pt-2">
                                <div class="flex items-center justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-3 mb-2">
                                            <div class="w-8 h-8 bg-gradient-to-br  text-[11px] from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white font-bold">
                                                <p><?= strtoupper(substr($user['prenom'], 0, 1) . substr($user['nom'], 0, 1)) ?></p>

                                            </div>
                                            <div class="w-full">
                                                <div class="flex w-full justify-between items-center">
                                                    <h3 class="text-[12px] font-semibold text-white">
                                                        <?= $user['prenom'] . ' ' . $user['nom'] ?>
                                                    </h3>
                                                    <div class="flex flex-wrap gap-2">
                                                        <?php foreach ($user['roles'] as $role): ?>
                                                            <span class="bg-blue-500/20 text-blue-300 px-3 py-1 rounded-full text-[10px] font-medium">
                                                                <?= $role ?>
                                                            </span>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>

                                                <div class="text-slate-400  w-full  text-[11px]">
                                                    <p> ID: #<?= $user['idUtilisateur'] ?></P>

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <button class="text-slate-400 hover:text-white transition-colors px-2 py-1 rounded-lg hover:bg-white/10" onclick="toggleForm(<?= $user['idUtilisateur'] ?>)">
                                        <svg class="w-5 h-5 transform transition-transform duration-200" id="icon_<?= $user['idUtilisateur'] ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <div id="form_<?= $user['idUtilisateur'] ?>" class="hidden border-t border-white/10 bg-black/20">
                                <div class="px-4 py-3">
                                    <form action="index.php?page=administration&idUtilisateur=<?= $user['idUtilisateur'] ?>" method="POST" class="space-y-4">
                                        <div>
                                            <div class="flex justify-between w-full mb-2 items-center">
                                                <label for="roles_<?= $user['idUtilisateur'] ?>" class="block text-sm font-medium text-slate-300 mb-2">
                                                    Modifier les rôles
                                                </label>
                                                <div class="flex space-x-3">
                                                    <button type="submit" name="updateRoles" title="Mettre à jour les rôles"
                                                        class=" bg-purple-600 hover:bg-purple-700 text-white py-1.5 px-3 text-[12px] rounded-lg font-medium transition-colors duration-200 flex items-center justify-center space-x-2">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                        </svg>

                                                    </button>
                                                    <button type="submit" name="deleteUser" title="Supprimer l'utilisateur"
                                                        class=" bg-red-600 hover:bg-red-700 text-white py-1.5 px-3 rounded-lg text-[12px] font-medium transition-colors duration-200 flex items-center justify-center space-x-2">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>

                                                    </button>
                                                </div>
                                            </div>

                                            <select name="roles[]" id="roles_<?= $user['idUtilisateur'] ?>"
                                                class="w-full p-3 bg-white/5 border border-white/20 max-h-[3.3rem] rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent" multiple>
                                                <?php foreach ($roles as $role): ?>
                                                    <?php $isSelected = in_array($role, $user['roles'], true); ?>
                                                    <option value="<?= htmlspecialchars($role); ?>"
                                                        class="<?= $isSelected ? 'bg-white/20 font-semibold hover:bg-white/10' : 'text-slate-200/30 hover:bg-white/10 font-medium  '; ?> transition-all px-3 py-0.5 text-[13px]"
                                                        <?= $isSelected ? 'selected' : ''; ?>>
                                                        <?= htmlspecialchars($role); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Users Pagination -->
                <div class="flex justify-center mt-8">
                    <div class="flex flex-wrap gap-y-2 gap-x-2">
                        <?php foreach (range(0, $totalPagesUsers - 1) as $page): ?>
                            <a href="<?= $GLOBALS['rootUrl'] . '/index.php?page=administration&nb=' . ($page + 1) . '#utilisateurs' ?>"
                                class="<?= (int)$nb === (int)$page + 1 ? 'bg-purple-600 text-white' : 'bg-white/10 text-slate-300 hover:bg-white/20'; ?> text-white w-6 h-6 sm:w-8 sm:h-8 text-xs rounded-lg flex items-center justify-center font-medium transition-all duration-200 hover:scale-105">
                                <?= $page + 1 ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Events Section -->
            <?php if ($activeEvents != null || $inactiveEvents != null): ?>
                <div class="mb-12">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-xl sm:text-2xl font-bold font-cabin text-white mb-1">Événements</h2>
                            <p class="text-slate-400 text-sm sm:text-base">Gérez et validez les événements de la plateforme</p>
                        </div>
                    </div>

                    <!-- Inactive Events -->
                    <?php if ($inactiveEvents != null): ?>
                        <div class="mb-8">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 gap-2">
                                <div class="flex items-center space-x-3">
                                    <h3 class="text-lg sm:text-xl font-semibold text-orange-400 font-cabin" id="evenements_inactifs">En attente de validation</h3>
                                    <span class="bg-orange-500/20 text-orange-300 px-3 py-1 rounded-full text-xs sm:text-sm font-medium">
                                        <?= count($inactiveEvents) ?> événements
                                    </span>
                                </div>
                            </div>

                            <!-- Desktop Table View -->
                            <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl overflow-hidden">
                                <div class="overflow-x-auto">
                                    <table class="w-full">
                                        <thead class="bg-black/20 border-b border-white/10">
                                            <tr class="text-left">
                                                <th class="p-3 text-slate-300 font-medium text-sm">Réf</th>
                                                <th class="p-3 text-slate-300 font-medium text-sm">Titre</th>
                                                <th class="p-3 text-slate-300 font-medium text-sm hidden lg:table-cell">Lieu</th>
                                                <th class="p-3 text-slate-300 font-medium text-sm">Date</th>
                                                <th class="p-3 text-slate-300 font-medium text-sm hidden xl:table-cell">Description</th>
                                                <th class="p-3 text-slate-300 font-medium text-sm hidden lg:table-cell">Organisateur</th>
                                                <th class="p-3 text-slate-300 font-medium text-sm">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-white/10">
                                            <?php foreach ($inactiveEvents as $inactiveEvent): ?>
                                                <tr class="hover:bg-white/5 transition-colors">
                                                    <td class="p-3 text-slate-400 font-mono text-xs">#<?= $inactiveEvent['idEvenement'] ?></td>
                                                    <td class="p-3">
                                                        <div class="text-white font-medium text-sm"><?= $inactiveEvent['titre'] ?></div>
                                                        <div class="text-slate-400 text-xs lg:hidden"><?= $inactiveEvent['nomLieu'] ?></div>
                                                    </td>
                                                    <td class="p-3 text-slate-300 text-sm hidden lg:table-cell"><?= $inactiveEvent['nomLieu'] ?></td>
                                                    <td class="p-3 text-slate-300 text-sm"><?= $inactiveEvent['dateEvenement'] ?></td>
                                                    <td class="p-3 text-slate-400 max-w-xs hidden xl:table-cell">
                                                        <div class="line-clamp-2 text-xs">
                                                            <?= $inactiveEvent['description'] ?>
                                                        </div>
                                                    </td>
                                                    <td class="p-3 text-slate-300 text-sm hidden lg:table-cell"><?= $inactiveEvent['designationOrganisateur'] ?></td>
                                                    <td class="p-3">
                                                        <div class="flex space-x-1">
                                                            <form action="<?= $GLOBALS['rootUrl'] . "/index.php?page=administration" ?>" method="POST" class="inline">
                                                                <input type="hidden" name="idEvenement" value="<?= htmlspecialchars($inactiveEvent['idEvenement']); ?>">
                                                                <button type="submit" name="validateEvent" value="validate" class="bg-emerald-600 hover:bg-emerald-700 text-white px-2 py-1 rounded text-xs font-medium transition-colors duration-200 flex items-center space-x-1">
                                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                                    </svg>
                                                                    <span class="hidden md:inline">Valider</span>
                                                                </button>
                                                            </form>
                                                            <form action="<?= $GLOBALS['rootUrl'] . "/index.php?page=administration" ?>" method="POST" class="inline">
                                                                <input type="hidden" name="idEvenement" value="<?= htmlspecialchars($inactiveEvent['idEvenement']); ?>">
                                                                <button type="submit" name="deleteEvent" value="delete" class="bg-red-600 hover:bg-red-700 text-white px-2 py-1 rounded text-xs font-medium transition-colors duration-200 flex items-center space-x-1">
                                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                                    </svg>
                                                                    <span class="hidden md:inline">Refuser</span>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Pagination -->
                            <div class="flex justify-center mt-4">
                                <div class="flex space-x-1 sm:space-x-2">
                                    <?php foreach (range(0, $totalPagesInactiveEvents - 1) as $page): ?>
                                        <a href="<?= $GLOBALS['rootUrl'] . '/index.php?page=administration&nb_ina=' . ($page + 1) . '#evenements_inactifs' ?>"
                                            class="<?= (int)$nb_ina === (int)$page + 1 ? 'bg-orange-600 text-white' : 'bg-white/10 text-slate-300 hover:bg-white/20'; ?> w-6 h-6 sm:w-8 sm:h-8 text-xs rounded-lg flex items-center justify-center font-medium transition-all duration-200 hover:scale-105">
                                            <?= $page + 1 ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Active Events -->
                    <?php if ($activeEvents != null): ?>
                        <div>
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 gap-2">
                                <div class="flex items-center space-x-3">
                                    <h3 class="text-lg sm:text-xl font-semibold text-emerald-400 font-cabin" id="evenements_actifs">Événements actifs</h3>
                                    <span class="bg-emerald-500/20 text-emerald-300 px-3 py-1 rounded-full text-xs sm:text-sm font-medium">
                                        <?= count($activeEvents) ?> événements
                                    </span>
                                </div>
                            </div>

                            <!-- Desktop Table View -->
                            <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl overflow-hidden">
                                <div class="overflow-x-auto">
                                    <table class="w-full">
                                        <thead class="bg-black/20 border-b border-white/10">
                                            <tr class="text-left">
                                                <th class="p-3 text-slate-300 font-medium text-sm">Réf</th>
                                                <th class="p-3 text-slate-300 font-medium text-sm">Titre</th>
                                                <th class="p-3 text-slate-300 font-medium text-sm hidden lg:table-cell">Lieu</th>
                                                <th class="p-3 text-slate-300 font-medium text-sm">Date</th>
                                                <th class="p-3 text-slate-300 font-medium text-sm hidden xl:table-cell">Description</th>
                                                <th class="p-3 text-slate-300 font-medium text-sm hidden lg:table-cell">Organisateur</th>
                                                <th class="p-3 text-slate-300 font-medium text-sm">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-white/10">
                                            <?php foreach ($activeEvents as $activeEvent): ?>
                                                <tr class="hover:bg-white/5 transition-colors">
                                                    <td class="p-3 text-slate-400 font-mono text-xs">#<?= $activeEvent['idEvenement'] ?></td>
                                                    <td class="p-3">
                                                        <div class="text-white font-medium text-sm"><?= $activeEvent['titre'] ?></div>
                                                        <div class="text-slate-400 text-xs lg:hidden"><?= $activeEvent['nomLieu'] ?></div>
                                                    </td>
                                                    <td class="p-3 text-slate-300 text-sm hidden lg:table-cell"><?= $activeEvent['nomLieu'] ?></td>
                                                    <td class="p-3 text-slate-300 text-sm"><?= $activeEvent['dateEvenement'] ?></td>
                                                    <td class="p-3 text-slate-400 max-w-xs hidden xl:table-cell">
                                                        <div class="line-clamp-2 text-xs">
                                                            <?= $activeEvent['description'] ?>
                                                        </div>
                                                    </td>
                                                    <td class="p-3 text-slate-300 text-sm hidden lg:table-cell"><?= $activeEvent['designationOrganisateur'] ?></td>
                                                    <td class="p-3">
                                                        <form action="administration.php" method="POST" class="inline">
                                                            <input type="hidden" name="idEvenement" value="<?= $activeEvent['idEvenement'] ?>">
                                                            <button type="submit" name="deleteEvent" value="Supprimer" class="bg-red-600 hover:bg-red-700 text-white px-2 py-1 rounded text-xs font-medium transition-colors duration-200 flex items-center space-x-1">
                                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                                </svg>
                                                                <span class="hidden md:inline">Supprimer</span>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Pagination -->
                            <div class="flex justify-center mt-4">
                                <div class="flex space-x-1 sm:space-x-2">
                                    <?php foreach (range(0, $totalPagesActiveEvents - 1) as $page): ?>
                                        <a href="<?= $GLOBALS['rootUrl'] . '/index.php?page=administration&nb_act=' . ($page + 1) . '#evenements_actifs' ?>"
                                            class="<?= (int)$nb_act === (int)$page + 1 ? 'bg-emerald-600 text-white' : 'bg-white/10 text-slate-300 hover:bg-white/20'; ?> w-6 h-6 sm:w-8 sm:h-8 text-xs rounded-lg flex items-center justify-center font-medium transition-all duration-200 hover:scale-105">
                                            <?= $page + 1 ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function toggleForm(userId) {
            const form = document.getElementById(`form_${userId}`);
            const icon = document.getElementById(`icon_${userId}`);

            if (form && icon) {
                form.classList.toggle('hidden');
                icon.classList.toggle('rotate-180');
            }
        }
    </script>