<?php

class Image
{
    public $param;
    public $value;
    public $type;
    private static $imageArray = [];

    public function __construct($param, $value, $type = PDO::PARAM_STR)
    {
        $this->param = $param;
        $this->value = [];
        $this->type = $type;
        self::$imageArray[] = $this;
    }

    public static function getImageArray()
    {
        return self::$imageArray;
    }

    public static function clearImageArray()
    {
        self::$imageArray = [];
    }

    public static function encodeImages()
    {
        $rootPath = $_SERVER['DOCUMENT_ROOT'] . '/ProjetEvenements';

        $folderPath = $rootPath . '/public/assets/images/events';
        $imageFiles = glob($folderPath . '/*.{jpg,jpeg,png,gif}', GLOB_BRACE);

        $images = [];
        foreach ($imageFiles as $filePath) {
            //  Lire et encoder l'image en base64
            $imageData = file_get_contents($filePath);
            $base64Image = base64_encode($imageData);

            // Créer l'instance image
            $image = new Image(':image', $base64Image, PDO::PARAM_STR);

            $images[] = $filePath;
            echo "<p class='z-10 text-white font-extrabold'>" . $filePath . "</p>";
        }

        return $images;
    }

    public function makeLinksArray()
    {
        $rootPath = $_SERVER['DOCUMENT_ROOT'] . '/ProjetEvenements';

        $folderPath = $rootPath . '/public/assets/images/events';
        $imageFiles = glob($folderPath . '/*.{jpg,jpeg,png,gif}', GLOB_BRACE);

        $images = [];
        foreach ($imageFiles as $filePath) {

            $images[] = $filePath;
        }
        $this->value = $images;

        return ["param" => $this->param, "value" => $this->value, "type" => $this->type];
    }

    public static function makeNewLinksArray()
    {
        $rootPath = $_SERVER['DOCUMENT_ROOT'] . '/ProjetEvenements';

        $folderPath = $rootPath . '/public/assets/images/events';
        $imageFiles = glob($folderPath . '/*.{jpg,jpeg,png,gif}', GLOB_BRACE);

        $images = [];
        foreach ($imageFiles as $filePath) {
            $trimmedPath = str_replace($rootPath, '', $filePath);
            $images[] = $trimmedPath;
        }
        // $this->value = $images;

        return $images;
    }
}
