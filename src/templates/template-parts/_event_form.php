<form class="form_evenement space-y-4" id="form_evenement" name="form_evenement" action="<?php $GLOBALS['rootUrl'] . $actionPath ?>" method="POST" enctype="multipart/form-data" onsubmit="return validateEvent()">
    <fieldset class="border border-blue-500 rounded-lg p-4">
        <legend class="text-lg font-bold text-white">Organiser un évènement</legend>

        <div class="flex flex-col">
            <label for="nomLieu" class="text-white">Adresse</label>
            <input type="text" name="nomLieu" id="nomLieu" minlength="3" required class="mt-1 bg-gray-800 text-white border border-blue-400 rounded-md focus:ring focus:ring-blue-300">
            <span class="form_error_msg text-red-500" id="error_lieu"></span>

            <label for="titre" class="text-white mt-4">Titre de l'évènement</label>
            <input type="text" name="titre" id="titre" minlength="3" required class="mt-1 bg-gray-800 text-white border border-blue-400 rounded-md focus:ring focus:ring-blue-300">
            <span class="form_error_msg text-red-500" id="error_titre"></span>

            <label for="dateEvenement" class="text-white mt-4">Date</label>
            <input type="datetime-local" name="dateEvenement" id="dateEvenement" required class="mt-1 bg-gray-800 text-white border border-blue-400 rounded-md focus:ring focus:ring-blue-300">
            <span class="form_error_msg text-red-500" id="error_date"></span>

            <label for="description" class="text-white mt-4">Description</label>
            <textarea name="description" id="description" placeholder="Détails de l'évènement" required class="mt-1 bg-gray-800 text-white border border-blue-400 rounded-md focus:ring focus:ring-blue-300"></textarea>
            <span class="form_error_msg text-red-500" id="error_description"></span>

            <label for="nbPlaces" class="text-white mt-4">Nombre de places</label>
            <input type="number" name="nbPlaces" id="nbPlaces" required class="mt-1 bg-gray-800 text-white border border-blue-400 rounded-md focus:ring focus:ring-blue-300">
            <span class="form_error_msg text-red-500" id="error_nbPlaces"></span>

            <label for="image" class="text-white mt-4">Image</label>
            <input type="file" name="image" id="image" accept="image/*" required class="mt-1 bg-gray-800 text-white border border-blue-400 rounded-md focus:ring focus:ring-blue-300">
            <span class="form_error_msg text-red-500" id="error_image"></span>
        </div>

        <div class="mt-6 flex flex-col space-y-2">
            <input type="submit" value="Envoyer" name="submit_evenement" id="submit_evenement" class="bg-blue-600 hover:bg-blue-500 text-white font-bold py-2 rounded-md transition duration-300">
            <input type="reset" value="Réinitialiser" class="bg-gray-700 hover:bg-gray-600 text-white font-bold py-2 rounded-md transition duration-300">

            <input type="button" value="Affichage Form" name="display" id="btn_display" class="bg-blue-600 hover:bg-blue-500 text-white font-bold py-2 rounded-md transition duration-300" onclick="return affichageForm(this)">
        </div>
    </fieldset>
</form>