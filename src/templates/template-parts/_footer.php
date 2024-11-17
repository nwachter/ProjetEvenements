<div class="flex flex-col items-center w-full h-fit text-[#e5e7eb] rounded-2xl bg-[#05031b] z-[2]  bg-opacity-80  px-4 py-7">
    <div class="flex sm:flex-row items-center justify-center w-[100%] max-sm:flex-col">
        <div class="flex flex-col gap-2 justify-center pl-[2%] max-md:basis-[32%] basis-[25%]">
            <div class="flex items-center w-full gap-4">
                <img src="<?= $GLOBALS['rootUrl'] . "/public/assets/images/logo_black.png" ?>" width="148" alt="Logo Ninja Events" class="opacity-80">
            </div>
            <div class="grid grid-cols-3 gap-6 w-fit p-4">
                <a href="https://www.youtube.com/watch?v=xvFZjo5PgG0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="fill-current">
                        <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"></path>
                    </svg></a> <a href="https://github.com/nwachter"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="fill-current">
                        <path d="M12 0c-6.627 0-12 5.373-12 12 0 5.303 3.438 9.801 8.205 11.388.6.111.82-.261.82-.577v-2.06c-3.338.728-4.03-1.617-4.03-1.617-.547-1.391-1.335-1.764-1.335-1.764-1.092-.747.083-.732.083-.732 1.207.085 1.839 1.24 1.839 1.24 1.071 1.83 2.809 1.302 3.495.998.107-.775.42-1.302.762-1.44-2.665-.303-5.466-1.335-5.466-5.927 0-1.306.47-2.373 1.244-3.211-.124-.303-.537-1.523.12-3.171 0 0 1.006-.317 3.291 1.247.957-.267 1.983-.4 3.003-.404 1.02.004 2.046.137 3.003.404 2.284-1.564 3.29-1.247 3.29-1.247.657 1.648.244 2.868.12 3.171.773.838 1.243 1.905 1.243 3.211 0 4.607-2.803 5.624-5.481 5.922.43.369.813 1.097.813 2.209v3.293c0 .316.219.692.827.577 4.768-1.588 8.206-6.086 8.206-11.388 0-6.627-5.373-12-12-12z"></path>
                    </svg>
                </a>
                <a href="https://x.com/fabnumpaloise"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="fill-current">
                        <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"></path>
                    </svg></a>
            </div>
        </div>
        <div class="flex max-md:flex-col md:flex-row basis-[72%]  max-md:basis-[68%] justify-end gap-6">
            <div class="grid grid-cols-10 basis-[60%] gap-4">
                <div class="flex flex-col col-span-5 basis-[40%] md:gap-4 max-md:gap-2.5">
                    <div class="font-bold uppercase  text-white">Entreprise</div>
                    <div class="flex flex-col text-[#fdb20b] gap-2">
                        <a href="#xxx" class="transition-all hover:underline">A Propos</a>
                        <a href="<?= $GLOBALS['rootUrl'] . "/index.php?page=nous_contacter" ?>" class="transition-all hover:underline">Contact</a>
                        <a href="<?= $GLOBALS['rootUrl'] . "/index.php?page=connexion" ?>" class="transition-all hover:underline">Connexion</a>
                        <a href="<?= $GLOBALS['rootUrl'] . "/index.php?page=inscription" ?>" class="transition-all hover:underline">Inscription</a>
                    </div>

                </div>
                <div class="flex flex-col col-span-5 basis-[60%] md:gap-4 max-md:gap-2.5">
                    <div class="transition-all font-bold uppercase  text-white">Mentions Légales</div>
                    <div class="flex flex-col text-[#fdb20b] gap-2">
                        <a href="#xxx" class="transition-all hover:underline">Mentions Légales</a>
                        <a href="#xxx" class="transition-all hover:underline">Politique de confidentialité</a>
                        <a href="#xxx" class="transition-all hover:underline">Conditions d'utilisation</a>
                    </div>

                </div>
            </div>
            <div class="flex flex-col basis-[40%] md:gap-4 max-md:gap-2.5">
                <div class="font-bold uppercase text-white">Newsletter</div>
                <p class="text-[#e5e7eb] mb-2">Abonnez-vous à notre Newsletter.</p>
                <form class="flex items-center">
                    <input type="email" name="email" placeholder="Entrez votre adresse email" class="w-full old:bg-gray-100 border-slate-600 border-[0.5px] bg-slate-900 old:text-gray-700 text-white rounded-l-lg py-3 px-2.5 focus:outline-none focus:ring-purple-600 focus:border-transparent" required="">
                    <button type="submit" class="bg-selective-yellow text-[#ffffff] font-semibold py-3 px-2.5 border-[0.5px] border-selective-yellow rounded-r-lg transition-colors duration-300">S'Abonner</button>
                </form>
            </div>
        </div>
    </div>
    <div class="w-full border-t border-gray-500 my-8"></div>
    <div class="text-center">© 2024 Nin(j)a Events - Tous droits reservés.</div>
</div>