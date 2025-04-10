<div class="w-full max-w-5xl mx-auto py-12">
    <?php if ($loggedIn && isset($event)): ?>
        <?php if (!$isEventUpdated): ?>
            <!-- Page header with glow effect -->
            <div class="text-center mb-10">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4 relative inline-block">
                    Modifier un évènement
                    <div class="absolute -inset-1 blur-xl bg-[#fdb20b]/10 rounded-full -z-10"></div>
                </h1>
                <p class="text-gray-300 max-w-2xl mx-auto">
                    Modifiez les détails de votre évènement ci-dessous.
                </p>
            </div>

            <!-- Event details card -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-white mb-6 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-[#fdb20b]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Évènement à modifier
                </h2>

                <div class="bg-[#0a0627]/80 backdrop-blur-md border border-[#fdb20b]/20 rounded-xl p-6 shadow-xl shadow-[#fdb20b]/5">
                    <article class="relative overflow-hidden group">
                        <!-- Subtle glow effect on hover -->
                        <div class="absolute inset-0 bg-gradient-to-r from-[#fdb20b]/0 to-[#fdb20b]/0 opacity-0 group-hover:opacity-10 transition-opacity duration-500 rounded-lg"></div>

                        <h3 class="text-2xl font-bold text-[#fdb20b] mb-2 flex items-center">
                            <?= $event['titre']; ?>
                            <span class="text-sm text-gray-400 ml-2">(ID: <?= $event['idEvenement'] ?>)</span>
                        </h3>

                        <div class="mb-4">
                            <div class="flex items-center text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#fdb20b]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <?= $event['nomLieu']; ?>
                            </div>
                        </div>

                        <div class="flex items-center text-gray-300 mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#fdb20b]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <?= "Événement prévu le : " . $event['dateEvenement']; ?>
                        </div>

                        <div class="text-gray-300 mb-4 border-l-2 border-[#fdb20b]/30 pl-4">
                            <?= $event['description']; ?>
                        </div>

                        <div class="text-sm text-[#fdb20b] italic flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <?= $event['designationOrganisateur']; ?>
                        </div>
                    </article>
                </div>
            </div>

            <!-- Edit form -->
            <div>
                <h2 class="text-2xl font-bold text-white mb-6 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-[#fdb20b]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Formulaire de modification
                </h2>

                <?php include_once($GLOBALS['rootPath'] . '/src/templates/template-parts/_event_form.php'); ?>
            </div>
        <?php else: ?>
            <!-- Success message -->
            <div class="bg-[#13ce66]/20 border border-[#13ce66]/30 text-[#13ce66] rounded-lg p-6 backdrop-blur-sm mb-8">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <h3 class="font-bold text-xl mb-1">Modification réussie!</h3>
                        <p><?= $message ?></p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php elseif (!isset($event)): ?>
        <!-- Event not found error -->
        <div class="bg-[#ff4d6d]/20 border border-[#ff4d6d]/30 text-[#ff4d6d] rounded-lg p-6 backdrop-blur-sm mb-8">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <div>
                    <h3 class="font-bold text-xl mb-1">Événement non trouvé</h3>
                    <p>L'événement n'est pas accessible ou n'existe pas.</p>
                </div>
            </div>
        </div>
    <?php else: ?>
        <!-- Access denied error -->
        <div class="bg-[#ff4d6d]/20 border border-[#ff4d6d]/30 text-[#ff4d6d] rounded-lg p-6 backdrop-blur-sm mb-8">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                <div>
                    <h3 class="font-bold text-xl mb-1">Accès refusé</h3>
                    <p>Vous n'avez pas accès à cette page.</p>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Back button -->
    <div class="mt-12 text-center">
        <a href="<?= $lastPageLink ?>" class="inline-flex items-center bg-[#0a0627] hover:bg-[#0a0627]/80 text-white border border-[#fdb20b]/30 font-medium py-3 px-6 rounded-lg transition-all duration-300 hover:border-[#fdb20b]">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Revenir à la page précédente
        </a>
    </div>
</div>