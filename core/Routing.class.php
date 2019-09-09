<?php

//declare (strict_types=1);

class Routing
{

    /**
     * 
     * recherche de page correspondant au slug dans les tables : pages / annonces et dans le fichier slugs.yml. Si aucune page trouvé on redirige vers page 404
     * 
     * @param string $slug	slug dans l url
     * 
     * @return array nom du controller / nom de l action / chemin du fichier controller
     * 
     * 
     */

    public static function getRoute($slug)
    {
        //récuperer toutes les routes dans le fichier yml

        $routes = yaml_parse_file(ROUTE_FILE);
        if (isset($routes[$slug])) {
            if (empty($routes[$slug]["controller"]) || empty($routes[$slug]["action"])) {
                die("Il y a une erreur dans le fichier slug.yml");
            }
            $c = $routes[$slug]["controller"] . "Controller";
            $a = $routes[$slug]["action"] . "Action";
            $cPath = "controllers/" . $c . ".class.php";

            return ["c" => $c, "a" => $a, "cPath" => $cPath];
        } else {
            return ["c" => null, "a" => null, "cPath" => null];
        }
        return ["c" => $c, "a" => $a, "cPath" => $cPath];
    }

    /**
     * 
     * recuperation des slugs dans le fichier slugs.yml
     * 
     * @param string $c	controller dans le fichier yml
     * @param string $a action dans le fichier yml
     * 
     * @return string si slug trouve alors retourne slug
     * @return null si slug non trouvé
     * 
     * 
     */

    public static function getSlug($c, $a)
    {
        $routes = yaml_parse_file(ROUTE_FILE);

        foreach ($routes as $slug => $cAndA) {

            if (
                !empty($cAndA["controller"]) &&
                !empty($cAndA["action"]) &&
                $cAndA["controller"] == $c &&
                $cAndA["action"] == $a
            ) {
                return $slug;
            }
        }

        return null;
    }
}
