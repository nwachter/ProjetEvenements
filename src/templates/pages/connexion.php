<?php var_dump($loggedIn) ?>

<div class="h-full flex flex-col items-center opacity-80 w-full container_accueil relative z-10">
    <div class="w-1/3 grid grid-cols-1 p-4 justify-center gap-4 items-center">
        <div class=" h-full  w-full py-4">
            <h1 class="text-indigo-500  justify-self-center text-3xl font-extrabold" style="font-family: 'Neon Club Music','Corben','Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;padding-bottom: 0.8rem;">Connexion</h1>

            <?php if (!empty($error_message)): ?>
                <div class=" p-4  text-center mb-4 text-sm text-red-800 rounded-lg bg-red-200 dark:bg-gray-800 dark:text-red-400"> <span class="font-medium">Erreur : </span><?= $error_message ?></div>
            <?php endif; ?>


            <?php
            if (isset($success_message)):
            ?>
                <div class="p-4 text-center mb-4 text-sm text-emerald-800 bg-emerald-200 border border-emerald-300 rounded-lg dark:bg-gray-800 dark:text-emerald-400">
                    <span class="font-medium text-slate-900">Succès !</span> <?= $success_message ?>
                </div>
            <?php
            endif;
            ?>


            <?php
            if (!empty($message)):
            ?>
                <!-- Info Alert -->
                <div class="p-4 mb-4 text-sm  border text-blue-700  bg-blue-300 border-blue-400 rounded-lg dark:bg-gray-800 dark:text-blue-400" role="alert">
                    <span class="font-medium"></span> <?= $message ?>
                </div>
            <?php
            endif;
            ?>


        </div>

        <?php if ($loggedIn === false): ?>
            <div>
                <!-- Si clic sur Inscrivez-vous, envoie vers inscription.php -->
                <p class="message-neutral" style="font-family: 'Rimouski Sb Regular','Corben','Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; color:lightsteelblue; font-weight:300;">Pas inscrit ? <a href="<?= $GLOBALS['rootUrl'] . "/index.php?page=inscription" ?>" class="text-yellow underline">Inscrivez-vous</a>.</p>
                <form action="<?= $GLOBALS['rootUrl'] . "/index.php?page=connexion " ?>" method="post" class="signin_form pt-3">

                    <div class="text-white">
                        <label for="email">Email</label>
                        <div class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 h-12 rounded-[15px] p-px">
                            <input type="text" name="email" id="email" class="w-full h-full outline-none bg-black p-2 rounded-[15px]">
                        </div>
                    </div>
                    <div class="text-white">
                        <label for="motDePasse">Mot de passe</label>
                        <div class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 h-12 rounded-[15px] p-px">
                            <input id="motDePasse" type="password" name="motDePasse" class="w-full h-full outline-none bg-black p-2 rounded-[15px]">
                        </div>
                    </div>

                    <div class="w-1/3 pt-4 mx-auto">
                        <button type="submit" class="w-[20rem] h-12 bg-indigo-800 text-white font-semibold hover:filter hover:brigthness-125 active:filter active:brightness-90 transition-all" name="submit_connexion" id="submit_connexion">Connexion</button>
                    </div>

                </form>

            </div>
        <?php else:  ?>
            <div class="pt-3 mx-auto bg-slate-700 border-[0.5px]  border-slate-600 rounded-md bg-opacity-35 w-full h-[20vh] flex justify-center items-center">
                <p class="text-sm text-slate-200">Vous êtes déjà connecté !</p>
            </div>
        <?php endif; ?>

    </div>

</div>