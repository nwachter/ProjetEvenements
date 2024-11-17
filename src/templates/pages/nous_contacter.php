<?php
$message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $thoughts = $_POST['thoughts'] ?? '';


    $message = "Merci pour votre message, $name! Nous vous contacterons bientôt.";
}
?>

<div class="text-white min-h-screen flex flex-col">
    <div class="container mx-auto px-4 flex-grow">

        <div class="py-12">
            <div class="flex flex-wrap -mx-4">
                <div class=" w-full md:w-1/2 px-4 mb-8 md:mb-0">

                    <form action="" method="POST" class="space-y-6" name="form_contact">
                        <?php if (!isset($_SESSION['email'])): ?>
                            <div class="rounded-xl bg-gradient-to-r from-indigo-500 to-pink-500 p-px">
                                <label for="name" class="sr-only"></label>
                                <input type="text" name="name" id="name" placeholder="Votre nom" required

                                    class="rounded-xl px-2 w-full bg-[#05021a] border-b border-gray-700 py-2 focus:outline-none focus:border-yellow-400 transition">
                            </div>

                            <div class="rounded-xl bg-gradient-to-r from-indigo-500 to-pink-500 p-px">
                                <label for="email" class="sr-only"></label>
                                <input type="email" name="email" id="email" placeholder="Votre email" required

                                    class="rounded-xl px-2 w-full bg-[#05021a] border-b border-gray-700 py-2 focus:outline-none focus:border-yellow-400 transition">
                            </div>
                        <?php endif; ?>

                        <div class="rounded-xl bg-gradient-to-r from-indigo-500 to-pink-500 p-px">
                            <label for="sujet" class="sr-only"></label>
                            <input type="sujet" name="sujet" id="sujet" placeholder="Le sujet du message" required

                                class="rounded-xl px-2 w-full bg-[#05021a] border-b border-gray-700 py-2 focus:outline-none focus:border-yellow-400 transition">
                        </div>

                        <div class="rounded-xl bg-gradient-to-r from-indigo-500 to-pink-500 p-px">
                            <label for="message" class="sr-only"></label>
                            <textarea name="message" id="message" placeholder="Ecrivez votre message ici" rows="4" required

                                class="rounded-xl px-2 w-full bg-[#05021a] border-b border-gray-700 py-2 focus:outline-none focus:border-yellow-400 transition"></textarea>
                        </div>
                        <button type="submit" name="submit_contact" class="rounded-lg px-6 py-2 bg-gradient-to-r from-blue-500 to-purple-500 text-white font-semibold rounded hover:opacity-90 transition">
                            Envoyer
                        </button>

                    </form>
                    <?php if ($message): ?>
                        <div class="mt-4 p-4 bg-green-800 text-white rounded">
                            <?php echo htmlspecialchars($message); ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="w-full md:w-1/2 px-4">
                    <div class="rounded-lg relative p-8">
                        <h2 class="animate-chromatic-title  opacity-80 font-echo-deco text-4xl font-[100] mb-6 relative inline-block">
                            Contactez-nous
                            <span class="absolute bottom-0 left-0 w-1/2 h-1 bg-gradient-to-r from-blue-500 to-purple-500"></span>
                        </h2>

                        <svg class="absolute inset-0 w-[30rem] h-[30rem]" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                            <path fill="none" stroke="rgba(255,255,255,0.1)"
                                d="M 100, 100 m -75, 0 a 75,75 0 1,0 150,0 a 75,75 0 1,0 -150,0"
                                stroke-width="2"></path>
                        </svg>
                        <p class="mb-6">Il est très important pour nous de rester en contact avec vous. Nous sommes toujours prêts à répondre à toutes vos questions. N'hésitez pas !</p>
                        <div class="space-y-2 font-roboto">
                            <p class=""><strong>Téléphone:</strong> +33 1 23 45 67 89</p>
                            <p class=""><strong>Email:</strong> contact@ninjaevents.com</p>
                            <p class=""><strong>Adresse:</strong> 123 Rue des Ninjas, 75001 Paris, France</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>