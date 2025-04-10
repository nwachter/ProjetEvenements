<!DOCTYPE html>
<html lang="en">

<?php include './src/templates/template-parts/_head.php'; ?>

<body class="relative m-0 p-0 w-full min-h-screen bg-[#05031b] z-0 font-roboto">
    <div class="absolute inset-0 w-full h-full z-0">
        <div class="absolute inset-0 bg-[#05031b]/70 backdrop-blur-sm z-1"></div>
        <video loop muted autoplay id="plasma_waves" class="w-screen h-screen fixed object-cover opacity-30">
            <source src="<?= $GLOBALS['rootUrl'] ?>/public/assets/videos/plasma_waves.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>

    <div class="relative z-10 flex flex-col min-h-screen old:max-w-[1440px] w-full ">
        <?php include TEMPLATE_PARTS . '/_header.php'; ?>

        <main class="flex-grow w-full">
            <?php include $pagePath; ?>
        </main>

        <?php include TEMPLATE_PARTS . '/_footer.php' ?>
    </div>

    <div class="fixed inset-0 pointer-events-none z-[5] opacity-[0.03]" style="background-image: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIzMDAiIGhlaWdodD0iMzAwIj48ZmlsdGVyIGlkPSJhIiB4PSIwIiB5PSIwIj48ZmVUdXJidWxlbmNlIGJhc2VGcmVxdWVuY3k9Ii43NSIgc3RpdGNoVGlsZXM9InN0aXRjaCIgdHlwZT0iZnJhY3RhbE5vaXNlIi8+PGZlQ29sb3JNYXRyaXggdHlwZT0ic2F0dXJhdGUiIHZhbHVlcz0iMCIvPjwvZmlsdGVyPjxwYXRoIGQ9Ik0wIDBoMzAwdjMwMEgweiIgZmlsdGVyPSJ1cmwoI2EpIiBvcGFjaXR5PSIuMDUiLz48L3N2Zz4=');"></div>
</body>

</html>