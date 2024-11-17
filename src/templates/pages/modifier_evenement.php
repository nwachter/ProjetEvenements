<div class="min-h-screen bg-gradient-to-br from-purple-900 via-gray-900 to-indigo-900 font-sans">
    <div class="container mx-auto px-4 py-8">
        <?php if ($loggedIn && isset($event)):    ?>

            <?php if (!$isEventUpdated): ?>
                <div>
                    <div class="mb-12 text-center">
                        <h1 class="text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-pink-500 to-purple-500 mb-4">Modifier un Événement</h1>
                    </div>

                    <div class="bg-gray-900 rounded-2xl shadow-2xl p-8 mb-12">
                        <h2 class="text-3xl font-bold mb-6 text-purple-300">Événement à modifier</h2>
                        <div class="space-y-8">
                            <?php // foreach ($events as $event): 
                            ?>
                            <article class="event bg-gray-700 rounded-lg p-6 transform transition duration-300 hover:scale-105 hover:shadow-xl">
                                <h2 class="text-2xl font-semibold text-pink-400 mb-2">
                                    <?= $event['titre']; ?> <span class="text-sm text-gray-400">(<?= $event['idEvenement'] ?>)</span>
                                </h2>
                                <div class="mb-4">
                                    <h3 class="text-xl text-purple-300"><?= $event['nomLieu']; ?></h3>
                                </div>
                                <div class="text-indigo-300 mb-2"><?= "Événement prévu le : " . $event['dateEvenement']; ?></div>
                                <div class="text-gray-300 mb-4"><?= $event['description']; ?></div>
                                <div class="text-sm text-pink-300 italic"><?= $event['designationOrganisateur']; ?></div>
                            </article>
                            <?php // endforeach; 
                            ?>
                        </div>
                    </div>

                    <div class="bg-gray-900 rounded-lg shadow-2xl p-8">
                        <h2 class="text-3xl font-bold mb-6 text-purple-300">Formulaire de modification</h2>
                        <div class="bg-gray-700 rounded-lg p-6">
                            <?php include_once($GLOBALS['rootPath'] . '/src/templates/template-parts/_event_form.php'); ?>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="bg-green-800 text-green-100 p-4 rounded-lg mb-8">
                        <?= $message . "test"; ?>
                    </div>
                <?php endif; ?>


            <?php elseif (!isset($event)): ?>
                <div class="bg-red-900 text-red-100 p-4 rounded-lg mb-8">L'événement n'est pas accessible</div>
            <?php else: ?>
                <div class="bg-red-900 text-red-100 p-4 rounded-lg mb-8">Vous n'avez pas accès à cette page</div>
            <?php endif; ?>

            <div class="mt-8 text-center">
                <a href="<?= $lastPageLink ?>" class="inline-block px-6 py-3 bg-purple-600 text-white rounded-full transition duration-300 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-opacity-50">
                    Revenir à la page précédente
                </a>
            </div>

                </div>