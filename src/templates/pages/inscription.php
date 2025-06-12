<div class="h-full  flex flex-col items-center opacity-80 w-full container_accueil relative z-10">
    <div class="max-sm:w-1/2 w-1/3 grid grid-cols-1 pt-6 my-6 pb-4 px-12 justify-center gap-4 items-center backdrop-blur-md border-[1px] border-white/20 bg-white/10 rounded-2xl p-6 shadow-lg">

        <div class=" h-full  w-full py-4 ">
            <h1 class="text-indigo-500  justify-self-center text-3xl font-extrabold" style="font-family: 'Neon Club Music','Corben','Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; padding-bottom: 0.8rem;">Créer un compte</h1>
            <?php if (!empty($error_message)): ?>
                <div class="alert alert-danger p-4 text-center mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"> <span class="font-medium">Erreur : </span><span><?= $error_message ?></span></div>
            <?php endif; ?>
            <?php if (!empty($message)): ?>
                <div class="alert alert-info text-center p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400">
                    <span class="font-medium">Succès !</span> <span><?= $message ?></span>
                </div>
            <?php endif; ?>
            <p class="" style="font-family: 'Rimouski Sb Regular','Corben','Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; color:lightsteelblue; font-weight:300;">Déjà inscrit ? <a href="<?= $GLOBALS['rootUrl'] . "/index.php?page=connexion" ?>" class="text-yellow underline">Connectez-vous</a>.</p>
        </div>

        <form action="<?= $GLOBALS['rootUrl'] . "/index.php?page=inscription" ?>" method="post" class="signup_form" autocomplete="off">
            <div class="text-white">
                <label for="prenom">Prénom</label>
                <div class="bg-gradient-to-r from-indigo-500 h-12 rounded-[15px] via-purple-500 to-pink-500 p-px">
                    <input id="prenom" type="text" name="prenom" id="prenom" class="px-4 w-full h-full outline-none bg-[#09061e] p-2   rounded-[15px] ">
                </div>
            </div>
            <div class="text-white">
                <label class="nom">Nom</label>
                <div class="bg-gradient-to-r from-indigo-500 h-12 rounded-[15px] via-purple-500 to-pink-500 p-px">
                    <input id="nom" type="text" name="nom" class="px-4 w-full h-full outline-none bg-[#09061e] p-2   rounded-[15px] ">
                </div>
            </div>


            <div class="text-white">
                <label for="email">Email</label>
                <div class="bg-gradient-to-r from-indigo-500 h-12 rounded-[15px] via-purple-500 to-pink-500 p-px">
                    <input type="text" name="email" id="email" class="px-4 w-full h-full outline-none bg-[#09061e] p-2   rounded-[15px] ">
                </div>
            </div>
            <div class="text-white">
                <label for="motDePasse">Mot de passe</label>
                <div class="bg-gradient-to-r from-indigo-500 h-12 rounded-[15px] via-purple-500 to-pink-500 p-px">
                    <input id="motDePasse" type="password" name="motDePasse" id="motDePasse" class="px-4 w-full h-full outline-none bg-[#09061e] p-2 rounded-[15px] ">
                </div>
            </div>
            <div class="text-white">
                <label for="confirm">Confirmation du mot de passe</label>
                <div class="bg-gradient-to-r from-indigo-500 h-12 rounded-[15px] via-purple-500 to-pink-500 p-px">
                    <input id="confirm" type="password" name="confirm" class="px-4 w-full h-full outline-none bg-[#09061e] p-2 rounded-[15px] ">
                </div>
            </div>


            <div class="text-white my-4">
                <p class="mb-2" style="font-family: var(--rimouski); font-weight: 300;">Rôle</p>
                <div class="flex flex-col gap-2">
                    <label for="organisateur_checkbox" class="text-[13px] text-[#d8c9ff] flex items-center gap-2">
                        <input type="checkbox" name="roles[]" id="organisateur_checkbox" value="Organisateur" style="font-family: 'Rimouski Sb Regular','Corben','Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;"> Organisateur
                    </label>
                    <label for="utilisateur_checkbox" class="text-[13px] text-[#d8c9ff] flex items-center gap-2">
                        <input type="checkbox" name="roles[]" id="utilisateur_checkbox" value="Utilisateur" style="font-family: 'Rimouski Sb Regular','Corben','Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;"> Utilisateur
                    </label>
                    <label for="administrateur_checkbox" class="text-[13px] text-[#d8c9ff] flex items-center gap-2">
                        <input type="checkbox" name="roles[]" id="administrateur_checkbox" value="Administrateur" style="font-family: 'Rimouski Sb Regular','Corben','Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;"> Administrateur
                    </label>
                </div>
            </div>


            <div id="designation_input" class="text-white hidden">
                <label for="designation">Désignation de l'Organisation</label>
                <div class="bg-gradient-to-r from-indigo-500 h-12 rounded-[15px] via-purple-500 to-pink-500 p-px">
                    <input type="text" name="designation" id="designation" class="px-4 w-full h-full outline-none bg-[#09061e] p-2   rounded-[15px] ">
                </div>
            </div>

            <div class="max-sm:w-1/2 w-1/3 pt-4 mx-auto">

                <button type="submit" class="rounded px-4 h-12 bg-indigo-800 text-white font-semibold hover:filter hover:brigthness-125 active:filter active:brightness-90 transition-all" name="submit_inscription">Inscription</button>
            </div>

        </form>
    </div>

</div>