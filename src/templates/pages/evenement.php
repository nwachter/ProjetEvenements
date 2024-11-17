<div class="text-white p-6 max-w-4xl h-full mx-auto">
	<div class="mb-6">
		<a href=<?= $GLOBALS['rootUrl'] . "/accueil" ?> class="text-blue-400 hover:underline">Retour à la liste des évènements</a>
	</div>

	<div class="informations mb-6">
		<?php if (!empty($error_message)): ?>
			<div class="p-4 text-center mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400">
				<span class="font-medium">Erreur : </span><span><?= $error_message ?></span>
			</div>
		<?php endif; ?>

		<?php if (isset($_POST["submit_inscrire"]) && !$hasJustEnrolledToEvent): ?>
			<div class="p-4 text-center mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400">
				<span>Il y a eu une erreur lors de votre ajout à l'évènement.</span>
			</div>
		<?php endif; ?>

		<?php if (!empty($message)): ?>
			<div class="p-4 text-center mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400">
				<span class="font-medium">Succès !</span> <span><?= $message ?></span>
			</div>
		<?php endif; ?>

		<?php if (isset($hasJustEnrolledToEvent) && $hasJustEnrolledToEvent): ?>
			<div class="p-4 text-center mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400">
				<span class="font-medium">Succès !</span> <span>Vous venez bien de rejoindre l'évènement!</span>
			</div>
		<?php endif; ?>
	</div>

	<?php foreach ($event as $eventDetails): ?>
		<div class="bg-gray-900 p-6 rounded-lg shadow-lg mb-6">
			<article>
				<div class="details_event">
					<h1 class="text-4xl font-bold mb-4"><?= $eventDetails['titre']; ?></h1>
					<div class="w-full flex justify-center"><img class="object-cover h-[400px] w-full object-cover rounded-lg mb-4" src="<?= $GLOBALS['rootUrl'] . $eventDetails['image']; ?>" alt="event image"></div>

					<div class="text-lg font-semibold text-gray-300">
						<p><?= $eventDetails['nomLieu'] ?></p>
					</div>

					<div class="mt-2 text-gray-400">Évènement prévu le : <?= $eventDetails['dateEvenement'] ?></div>
					<div class="mt-4 text-gray-300"><?= $eventDetails['description']; ?></div>
					<div class="mt-2 italic text-gray-500"><?= $eventDetails['designationOrganisateur']; ?></div>
				</div>

				<div class="participants mt-6">
					<div class="text-lg font-semibold text-gray-300">Nombre d'inscrits : <span class="font-bold"><?= $eventDetails['nbInscrits']; ?></span>/<span class="font-bold"><?= $eventDetails['nbPlaces']; ?></span></div>

					<div class="enrolled_names mt-4">
						<h3 class="text-xl font-bold mb-2">Liste des inscrits</h3>
						<?php foreach ($enrolledOfEvent as $enrolledUser): ?>
							<p class="text-gray-300"><?= $enrolledUser['prenom']; ?> <?= $enrolledUser['nom'] ?></p>
						<?php endforeach; ?>
					</div>
				</div>
			</article>

			<div class="px-6 pb-4 pt-6">
				<?php if ($loggedIn && !$isEnrolledToEvent && !$hasJustEnrolledToEvent): ?>
					<form method="POST" id="form_inscrire" name="form_inscrire" class="w-full flex justify-center items-center h-auto mt-6">
						<button type="submit" name="submit_inscrire" id="submit_inscrire" class="bg-[#fdb20b] bg-opacity-60 outline-double outline-[#eda63d] rounded-t-[15px] border-1 border-[#6d593a] shadow-2xl hover:filter hover:brightness-125 active:filter active:brightness-90 transition-all w-[10rem] h-[4rem] min-w-[10rem] max-h-[4rem] min-w-[5rem] text-center text-[#fff4dd] font-bold text-xl font-neon-club-music" value="Rejoindre l'Evènement">Participer</button>
					</form>
				<?php elseif ($loggedIn && $isEnrolledToEvent && isset($_POST["submit_inscrire"])): ?>
					<div class="alert alert-info text-center p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400">
						<p class="info-msg">Vous avez déjà rejoint l'évènement !</p>
					</div>
				<?php elseif ($loggedIn && $isEnrolledToEvent && !isset($_POST["submit_inscrire"])): ?>
					<div class="alert alert-info text-center p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400">
						<p class="info-msg">Vous êtes inscrit a cet évènement !</p>

					</div>
				<?php else: ?>
					<div class="bg-yellow-200 text-black rounded-xl border-1 border-slate-400 p-3 text-center">
						Connectez-vous pour vous inscrire aux évènements.
					</div>
				<?php endif; ?>
			</div>

		</div>
	<?php endforeach; ?>
</div>