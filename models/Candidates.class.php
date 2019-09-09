<?php

//declare (strict_types=1);
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Candidates extends ConnectBDD
{
    public $nickname;
    public $faceit_link;
    public $esea_link = "";
    public $description;
    public $email;
    public $skype;

    public function setNickname($nickname)
    {
        $this->nickname = trim($nickname);
    }

    public function getNickname()
    {
        return $this->nickname;
    }

    public function setFaceit_link($faceit_link)
    {
        $this->faceit_link = trim($faceit_link);
    }

    public function getFaceit_link()
    {
        return $this->faceit_link;
    }

    public function setEsea_link($esea_link)
    {
        $this->esea_link = trim($esea_link);
    }

    public function getEsea_link()
    {
        return $this->esea_link;
    }

    public function setDescription($description)
    {
        $this->description = trim($description);
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setEmail($email)
    {
        $this->email = trim($email);
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setSkype($skype)
    {
        $this->skype = trim($skype);
    }

    public function getSkype()
    {
        return $this->skype;
    }

    /**
     * 
     * 
     * Form booster candidate (jobs)
     * 
     * 
     * @return array formulaire
     * 
     * 
     */
    public function getCandidateBoosterForm()
    {

        return [
            "config" => [
                "method" => "POST",
                "action" => Routing::getSlug("main", "candidateBoosters"),
                "class" => "todo",
                "id" => "todo",
                "submit" => "Send"
            ],

            "data" => [

                "nickname" => [
                    "type" => "text",
                    "placeholder" => "Enter a nickname",
                    "id" => "nickname",
                    "name" => "nickname",
                    "class" => "todo",
                    "maxlength" => 50,
                    "required" => true,
                    "error" => "The nickname as to be under 50"
                ],

                "faceit_link" => [
                    "type" => "text",
                    "placeholder" => "Enter a faceit link",
                    "id" => "faceit",
                    "name" => "faceit",
                    "class" => "todo",
                    "maxlength" => 200,
                    "required" => true,
                    "error" => "The link is not valid, please enter a faceit link"
                ],

                "esea_link" => [
                    "type" => "text",
                    "placeholder" => "Enter a esea link",
                    "id" => "esea",
                    "name" => "esea",
                    "class" => "todo",
                    "maxlength" => 200,
                    "required" => false,
                    "error" => "The link is not valid, please enter an esea link"
                ],

                "description" => [
                    "type" => "text",
                    "placeholder" => "Type a description. Put some links, describe yourself and your achivements.",
                    "id" => "description",
                    "name" => "description",
                    "class" => "todo",
                    "maxlength" => 750,
                    "required" => true,
                    "error" => "Description need to do at least 150"
                ],

                "email" => [
                    "type" => "email",
                    "placeholder" => "exemple@mail.com",
                    "id" => "email",
                    "name" => "email",
                    "class" => "todo",
                    "maxlength" => 50,
                    "required" => true,
                    "error" => "Email invalid"
                ],

                "skype" => [
                    "type" => "text",
                    "placeholder" => "skype here",
                    "id" => "skype",
                    "name" => "skype",
                    "class" => "todo",
                    "maxlength" => 50,
                    "required" => true,
                    "error" => "Skype username cant be more than 50"
                ]


            ]
        ];
    }

    /**
     * 
     * 
     * Insert in db the candid and post it to the admins
     * 
     * 
     * 
     * 
     */
    public function postCandid()
    {
        try {
            $this->insert();
        } catch (Exception $e) {
            die("Erreur lors de l'enregistrement : " . $e->getMessage());
        }
    }
}
