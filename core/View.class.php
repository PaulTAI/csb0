<?php
class View
{

    private $v;
    private $t;
    private $data = [];

    /**
     * 
     * attribue une view en fonction du template (back, front ou inCMS) inCMS signifie que la page est en edition 
     * et que l on ne desire donc pas recuperer certaines infos correspondant au back ou au front (head par exemple)
     * 
     * @param string $v	view demandé
     * @param string $t template demandé (back, front ou inCMS)
     * 
     * 
     */

    public function __construct($v, $t = "back")
    {
        //session_start();
        if ($t == "front") {
            $this->setViewFront($v);
        } elseif ($t == "back") {
            $this->setViewBack($v);
        }

        $this->setTemplate($t);
    }

    /**
     * 
     * attribution de la view coté back (cms). Stockage de la view dans $v
     * 
     * @param string $v	view demandé
     * 
     * 
     */

    public function setViewBack($v)
    {
        $viewPath = "views/back/" . $v . ".view.php";
        if (file_exists($viewPath)) {
            $this->v = $viewPath;
        } else {
            die("Attention le fichier view n'existe pas " . $viewPath);
        }
    }

    /**
     * 
     * attribution de la view coté front (site). Stockage de la view dans $v
     * 
     * @param string $v	view demandé
     * 
     * 
     */

    public function setViewFront($v)
    {
        $viewPath = "views/front/" . $v . ".view.php";
        if (file_exists($viewPath)) {
            $this->v = $viewPath;
        } else {
            die("Attention le fichier view n'existe pas " . $viewPath);
        }
    }

    /**
     * 
     * attribution du template. Stockage du template dans $t
     * 
     * @param string $t	template demandé
     * 
     * 
     */

    public function setTemplate($t)
    {

        $templatePath = "views/templates/" . $t . ".tpl.php";
        if (file_exists($templatePath)) {
            $this->t = $templatePath;
        } else {
            die("Attention le fichier template n'existe pas " . $templatePath);
        }
    }

    /**
     * 
     * ajout d un modal en back
     * 
     * @param string $modal	nom du modal
     * @param array $config form du modal
     * 
     * 
     */

    public function addModalBack($modal, $config = NULL)
    {
        //form.mod.php
        $modalPath = "views/back/modals/" . $modal . ".mod.php";
        if (file_exists($modalPath)) {
            include $modalPath;
        } else {
            die("Attention le fichier modal n'existe pas " . $modalPathCms);
        }
    }

    /**
     * 
     * ajout d un modal en front
     * 
     * @param string $modal	nom du modal
     * @param array $config form du modal
     * 
     * 
     */

    public function addModalFront($modal, $config = NULL)
    {
        //form.mod.php
        $modalPath = "views/front/modals/" . $modal . ".mod.php";
        if (file_exists($modalPath)) {
            include $modalPath;
        } else {
            die("Attention le fichier modal n'existe pas " . $modalPathCms);
        }
    }

    public function assign($key, $value)
    {
        $this->data[$key] = $value;
    }

    public function __destruct()
    {
        extract($this->data);
        include $this->t;
    }
}
