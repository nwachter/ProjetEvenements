<form class="form_evenement w-full max-w-2xl mx-auto" id="form_evenement" name="form_evenement" action="<?php $GLOBALS['rootUrl'] . $actionPath ?>" method="POST" enctype="multipart/form-data" onsubmit="return validateEvent()">
    <div class="bg-[#0a0627]/80 backdrop-blur-md border border-[#fdb20b]/20 rounded-xl p-6 md:p-8 shadow-xl shadow-[#fdb20b]/5">
        <h2 class="text-md font-light text-white/60 mb-6 flex items-center">
            Organisez un évènement, et faites-le connaître à tous !
        </h2>

        <div class="space-y-6">
            <!-- Adresse -->
            <div class="space-y-2">
                <label for="nomLieu" class="block text-white font-medium">Adresse</label>
                <div class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-3 top-1/2 transform -translate-y-1/2 text-[#fdb20b]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <input type="text" name="nomLieu" id="nomLieu" minlength="3" required
                        class="w-full bg-[#05031b]/70 text-white border border-[#fdb20b]/30 rounded-lg py-3 pl-10 pr-4 focus:outline-none focus:ring-2 focus:ring-[#fdb20b]/50 focus:border-transparent transition-all duration-300">
                </div>
                <span class="form_error_msg text-[#ff4d6d] text-sm font-medium hidden" id="error_lieu">Veuillez entrer une adresse valide</span>
            </div>

            <!-- Titre -->
            <div class="space-y-2">
                <label for="titre" class="block text-white font-medium">Titre de l'évènement</label>
                <div class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-3 top-1/2 transform -translate-y-1/2 text-[#fdb20b]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    <input type="text" name="titre" id="titre" minlength="3" required
                        class="w-full bg-[#05031b]/70 text-white border border-[#fdb20b]/30 rounded-lg py-3 pl-10 pr-4 focus:outline-none focus:ring-2 focus:ring-[#fdb20b]/50 focus:border-transparent transition-all duration-300">
                </div>
                <span class="form_error_msg text-[#ff4d6d] text-sm font-medium hidden" id="error_titre">Veuillez entrer un titre valide</span>
            </div>

            <!-- Date -->
            <div class="space-y-2">
                <label for="dateEvenement" class="block text-white font-medium">Date</label>
                <div class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-3 top-1/2 transform -translate-y-1/2 text-[#fdb20b]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <input type="datetime-local" name="dateEvenement" id="dateEvenement" required
                        class="w-full bg-[#05031b]/70 text-white border border-[#fdb20b]/30 rounded-lg py-3 pl-10 pr-4 focus:outline-none focus:ring-2 focus:ring-[#fdb20b]/50 focus:border-transparent transition-all duration-300">
                </div>
                <span class="form_error_msg text-[#ff4d6d] text-sm font-medium hidden" id="error_date">Veuillez sélectionner une date valide</span>
            </div>

            <!-- Description -->
            <div class="space-y-2">
                <label for="description" class="block text-white font-medium">Description</label>
                <div class="relative">
                    <textarea name="description" id="description" placeholder="Détails de l'évènement" required rows="4"
                        class="w-full bg-[#05031b]/70 text-white border border-[#fdb20b]/30 rounded-lg py-3 px-4 focus:outline-none focus:ring-2 focus:ring-[#fdb20b]/50 focus:border-transparent transition-all duration-300"></textarea>
                </div>
                <span class="form_error_msg text-[#ff4d6d] text-sm font-medium hidden" id="error_description">Veuillez entrer une description</span>
            </div>

            <!-- Nombre de places -->
            <div class="space-y-2">
                <label for="nbPlaces" class="block text-white font-medium">Nombre de places</label>
                <div class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-3 top-1/2 transform -translate-y-1/2 text-[#fdb20b]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <input type="number" name="nbPlaces" id="nbPlaces" required min="1"
                        class="w-full bg-[#05031b]/70 text-white border border-[#fdb20b]/30 rounded-lg py-3 pl-10 pr-4 focus:outline-none focus:ring-2 focus:ring-[#fdb20b]/50 focus:border-transparent transition-all duration-300">
                </div>
                <span class="form_error_msg text-[#ff4d6d] text-sm font-medium hidden" id="error_nbPlaces">Veuillez entrer un nombre de places valide</span>
            </div>

            <!-- Image -->
            <div class="space-y-2">
                <label for="image" class="block text-white font-medium">Image</label>
                <div class="relative">
                    <div class="flex items-center justify-center w-full">
                        <label for="image" class="flex flex-col items-center justify-center w-full h-32 border-2 border-[#fdb20b]/30 border-dashed rounded-lg cursor-pointer bg-[#05031b]/50 hover:bg-[#05031b]/70 transition-all duration-300">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-3 text-[#fdb20b]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                <p class="mb-2 text-sm text-white"><span class="font-semibold">Cliquez pour envoyer une image</span> ou glissez-déposez</p>
                                <p class="text-xs text-white/60">Formats : SVG, PNG, JPG, GIF</p>
                            </div>
                            <input id="image" name="image" type="file" accept="image/*" class="hidden" required />
                        </label>
                    </div>
                </div>
                <span class="form_error_msg text-[#ff4d6d] text-sm font-medium hidden" id="error_image">Veuillez sélectionner une image</span>
            </div>

            <!-- Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 pt-4">
                <button type="submit" name="submit_evenement" id="submit_evenement"
                    class="flex-1 bg-[#fdb20b] hover:bg-[#fdb20b]/80 text-[#05031b] font-bold py-3 px-6 rounded-lg transition-all duration-300 transform hover:translate-y-[-2px] hover:shadow-lg hover:shadow-[#fdb20b]/20 focus:outline-none focus:ring-2 focus:ring-[#fdb20b]/50">
                    <span class="flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Créer l'événement
                    </span>
                </button>
                <button type="reset"
                    class="flex-1 bg-transparent hover:bg-white/10 text-white border border-white/20 font-bold py-3 px-6 rounded-lg transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-white/30">
                    <span class="flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Réinitialiser
                    </span>
                </button>
            </div>
        </div>
    </div>
</form>