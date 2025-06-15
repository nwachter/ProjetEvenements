<div class="w-full max-w-3xl mx-auto py-12">

    <div class="text-center mb-10">
        <h1 class="text-4xl md:text-5xl font-cabin font-bold text-white/90 mb-4 relative inline-block">
            Organiser un évènement

        </h1>
        <p class="text-gray-300 max-w-2xl mx-auto">
            Ici, vous pouvez organiser un évènement. Si vous avez besoin de plus d'informations sur le fonctionnement du site, veuillez nous contacter via la page Contact.
        </p>
    </div>

    <div class="mb-6">
        <?php if (isset($message)): ?>
            <div class="bg-[#ff4d6d]/20 border border-[#ff4d6d]/30 text-[#ff4d6d] rounded-lg p-4 backdrop-blur-sm">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <p class="font-medium"><?= $message ?></p>
                </div>
            </div>
        <?php endif; ?>

        <div class="message_error hidden">
            <div class="bg-[#5BC0EB]/20 border border-[#5BC0EB]/30 text-[#5BC0EB] rounded-lg p-4 backdrop-blur-sm">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="p_info font-medium"></p>
                </div>
            </div>
        </div>

        <div id="messageId" class="hidden"></div>
    </div>

    <!-- Content based on login status -->
    <?php if ($loggedIn): ?>
        <?php include_once($GLOBALS['rootPath'] . '/src/templates/template-parts/_event_form.php'); ?>
    <?php else: ?>
        <div class="bg-[#0a0627]/80 backdrop-blur-md border border-[#fdb20b]/20 rounded-xl p-8 shadow-xl shadow-[#fdb20b]/5 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-[#fdb20b] mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
            <h2 class="text-2xl font-bold text-white mb-4">Connexion requise</h2>
            <p class="text-gray-300 mb-6">Veuillez vous connecter pour organiser un évènement.</p>
            <a href="<?= $GLOBALS['rootUrl'] . "/connexion" ?>" class="inline-flex items-center bg-[#fdb20b] hover:bg-[#fdb20b]/80 text-[#05031b] font-bold py-3 px-6 rounded-lg transition-all duration-300 transform hover:translate-y-[-2px] hover:shadow-lg hover:shadow-[#fdb20b]/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
                Se connecter
            </a>
        </div>
    <?php endif; ?>
</div>