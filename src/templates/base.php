<!DOCTYPE html>
<html lang="en">

<?php include './src/templates/template-parts/_head.php'; ?>

<body class="relative m-0 p-0 w-full min-h-screen bg-[#05031b]  z-0">
    <div class="absolute inset-0 w-full opacity-20  h-full z-0">
        <video loop muted autoplay id="plasma_waves" class="w-screen h-screen fixed object-cover">
            <source src="<?= $GLOBALS['rootUrl'] ?>/public/assets/videos/plasma_waves.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>

    <?php include TEMPLATE_PARTS . '/_header.php'; ?>



    <main class="flex-grow w-full relative z-0">
        <?php include $pagePath; ?>
    </main>

    <?php include TEMPLATE_PARTS . '/_footer.php' ?>
</body>

</html>