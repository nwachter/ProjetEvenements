<div class="mb-8 max-w-xl mx-auto bg-gray-900 p-6 rounded-lg shadow-lg border border-blue-500">
    <div class="message_error mb-4">
        <p class="p_info text-blue-300 font-bold"></p>
        <p id="messageId" class="text-blue-300 font-bold"></p>
    </div>

    <?php if (isset($message)): ?>
        <div>
            <p class="text-red-500 font-bold">
                <?= $message ?>
            </p>
        </div>
    <?php endif; ?>

    <div>
        <h1 class="text-2xl font-extrabold text-white mb-2">Organiser un évènement</h1>
        <p class="text-gray-400 mb-4">
            Ici, vous pouvez organiser un évènement (si vous avez besoin de plus d'informations sur le fonctionnement du site, veuillez nous contacter via la page Contact).
        </p>
    </div>

    <?php if ($loggedIn): ?>
        <div>
            <?php include_once($GLOBALS['rootPath'] . '/src/templates/template-parts/_event_form.php'); ?>
        </div>
    <?php else: ?>
        <div>
            <p class="text-red-500">Veuillez vous connecter pour organiser un évènement.</p>
        </div>
    <?php endif; ?>

</div>