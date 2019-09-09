<?php

require("PHPMailer/src/PHPMailer.php");
require("PHPMailer/src/SMTP.php");
require("PHPMailer/src/Exception.php");

$fileProperties = "properties.php";
if (file_exists($fileProperties))
    include $fileProperties;

spl_autoload_register(function ($class) {

    $classPath = "core/" . $class . ".class.php";
    if (file_exists($classPath)) {
        include $classPath;
    }
    /**
     *
     *	Appelle des class model pour le CMS
     *
     **/
    $classModel = "models/" . $class . ".class.php";
    if (file_exists($classModel)) {
        include $classModel;
    }
    /**
     *
     *	Appelle des class de PHPMailer
     *
     **/
    $classPHPMailer = "PHPMailer/src/" . $class . ".php";
    if (file_exists($classPHPMailer)) {
        include $classPHPMailer;
    }
});

spl_autoload_register(function ($traitName) {
    /**
     *
     *	Appelle des traits
     *
     **/
    $traits = "models/traits/" . $traitName . ".trait.php";
    if (file_exists($traits)) {
        include $traits;
    }
});

//spl_autoload_register("myAutoloader");

$slug = $_SERVER["REQUEST_URI"];

//pour palier aux paramètres GET
$slugExploded = explode("?", $slug);
$slug = $slugExploded[0];

$fileConfDb = CONF_DB_FILE;


$routes = Routing::getRoute($slug);
extract($routes);

//vérifier l'existence du fichier et de la class controller
if (file_exists($cPath)) {
    include $cPath;
    if (class_exists($c)) {
        //instancier dynamiquement le controller
        $cObject = new $c();
        //vérifier que la méthode (l'action) existe
        if (method_exists($cObject, $a)) {
            //appel dynamique de la méthode	
            $cObject->$a();
        } else {
            die("La methode " . $a . " n'existe pas");
        }
    } else {
        die("La class controller " . $c . " n'existe pas");
    }
}
