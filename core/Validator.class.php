<?php

//declare (strict_types=1);

class Validator
{

    public $errors = [];
    public $mail = [];

    /**
     * 
     * verifiaction des champs dans un formualaire. Stock les erreurs dans $errors si il y en as
     * 
     * @param array $config	formulaire
     * @param array $data	valeurs des champs du formulaire
     * 
     * 
     * 
     */

    public function __construct($config, $data)
    {

        //1er vérification : le nb de champs
        if (count($data) != count($config["data"]) && !isset($config["data"]["title-create-superadmin"])) {
            die("Tentative : faille XSS");
        }

        foreach ($config["data"] as $name => $info) {

            //Isset
            if (!isset($data[$name]) && $name != "title-create-superadmin" && $name != "template") {
                die("Tentative : faille XSS");
            } else {

                //!empty if required - method
                if (($info["required"] ?? false) && !self::notEmpty($data[$name])) {
                    $this->errors[] = $info["error"];
                }


                //minlength  - method
                if (isset($info["minlength"]) && !self::minLength($data[$name], $info["minlength"])) {
                    $this->errors[] = $info["error"];
                }

                //maxlength - method
                if (isset($info["maxlength"]) && !self::maxLength($data[$name], $info["maxlength"])) {
                    $this->errors[] = $info["error"];
                }

                //email - method
                if (@$info["type"] == "email" && !self::checkEmail($data[$name])) {
                    $this->errors[] = $info["error"];
                }

                //confirm 
                if (isset($info["confirm"]) && $data[$name] != $data[$info["confirm"]]) {
                    $this->errors[] = $info["error"];
                }
                //password : maj min et chiffres - method
                else if (@$info["type"] == "password" && !self::checkPassword($data[$name])) {
                    $this->errors[] = $info["error"];
                }

                //nom de domaine - champ
                if (@$info["id"] == "domain-name" && !self::checkDomainName($data[$name])) {
                    $this->errors[] = $info["error"];
                }

                //port - champ
                if (@$info["id"] == "port" && !self::checkPort($data[$name])) {
                    $this->errors[] = $info["error"];
                }
            }
        }
    }

    /**
     * 
     * verifie si champs vide ou non
     * 
     * @param string $string valeur dans le formulaire
     * 
     * @return bool	true si non vide et false si vide
     * 
     * 
     */

    public static function notEmpty($string)
    {
        return !empty(trim($string));
    }

    /**
     * 
     * verifie la taille minimal d un champ
     * 
     * @param string $string	valeur du champ
     * @param integer $length	valeur min
     * 
     * @return bool	true si valeur superieur ou false si inferieur
     * 
     * 
     */

    public static function minLength($string, $length)
    {
        return strlen(trim($string)) >= $length;
    }

    /**
     * 
     * verifie la taille maximal d un champ
     * 
     * @param string $string	valeur du champ
     * @param integer $length	valeur max
     * 
     * @return bool	true si valeur inferieur ou false si inferieur
     * 
     * 
     */

    public static function maxLength($string, $length)
    {
        return strlen(trim($string)) <= $length;
    }

    /**
     * 
     * verifie la forme d un mail
     * 
     * @param string $string	valeur du champ
     * 
     * @return bool	true si mail correct et false si incorrect
     * 
     * 
     */

    public static function checkEmail($string)
    {
        return filter_var(trim($string), FILTER_VALIDATE_EMAIL);
    }

    /**
     * 
     * verifie si le mot de passe comprend au moins : 1 lettre min / 1 mettre maj / 1 numero
     * 
     * @param string $string	valeur du champ
     * 
     * @return bool	true si respect des consignes et false si non respect des consignes
     * 
     * 
     */

    public static function checkPassword($string)
    {
        return (preg_match("#[a-z]#", $string) &&
            preg_match("#[A-Z]#", $string) &&
            preg_match("#[0-9]#", $string));
    }

    /**
     * 
     * verifie si port comprend bien que des numeros
     * 
     * @param string $string	valeur du champ
     * 
     * @return bool	true si comprend que des numero et false si ne comprend pas que des numeros
     * 
     * 
     */

    public static function checkPort($string)
    {
        return preg_match("#[0-9]#", $string);
    }

    /**
     * 
     * verifie si nom de domaine valide
     * 
     * @param string $string	valeur du champ
     * 
     * @return bool	true si nom de domaine valide et false si non valide
     * 
     * 
     */

    public static function checkDomainName($string)
    {
        return preg_match("/\b((http|https):\/\/?)[^\s()<>]+(?:\([\w\d]+\)|\/)/", $string);
    }
}
