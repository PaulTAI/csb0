<?php

class ConnectBDD
{

    public $pdo;
    private $table;
    public $errors = [];

    public function __construct()
    {

        $fileConfDb = CONF_DB_FILE;
        if (file_exists($fileConfDb)) {
            try {
                $this->pdo = new PDO(DBDRIVER . ":host=" . DBHOST . ";port=" . DBPORT . ";dbname=" . DBNAME, DBUSER, DBPWD);

                //$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (Exception $e) {
                die("Erreur SQL : " . $e->getMessage());
            }

            $this->table = get_called_class();
        } //else {

        //     $slug = new GetCurrentSlug();

        //     if ($slug->slug != "zz-config-cms")
        //         header('Location: zz-config-cms');
        // }
    }

    /**
     * 
     * 	Fonction d insertion en base de données
     * 
     * 
     */

    public function insert()
    {

        $connectClass = new ConnectBDD();

        $dataObject = get_object_vars($this);
        $dataChild = array_diff_key($dataObject, get_class_vars(get_class($connectClass)));

        $search = array("__"); // les variables contenant "__" signifie qu elles correspondent a des noms de tables avec un "-" dedans. On remplace donc "__" par "-" 
        $replace = array("-");

        $values = implode(",", array_values($dataChild));

        $values = explode(",", $values);

        $replacedString = str_replace($search, $replace, array_keys($dataChild));

        $valuesString = [];
        foreach (array_keys($dataChild) as $key => $value) {
            $valuesString[$key] = "?";
        }

        $fieldsString = [];
        foreach ($replacedString as $key => $value) {
            $fieldsString[$key] = '"' . $value . '"';
        }

        $req_insert = "INSERT INTO " . strtolower($this->table) . " (" .
            implode(",", $fieldsString) . ") VALUES (" .
            implode(",", $valuesString) . ")";
        $insert = $this->pdo->prepare($req_insert);
        $insert->execute($values);
    }

    /**
     * 
     * 	Fonction de mise a jour en base de données
     * 
     * 	@param array $set	elements a modifier
     * 	@param array $where	conditions de modifications
     * 
     */

    public function update($set, $where = NULL)
    {

        $setKey = array_keys($set);
        $setValues = array_values($set);

        $setUpdate = [];
        foreach ($setKey as $key => $value) {
            $setUpdate[] .= $value . " = ?";
        }

        $set = implode(",", $setUpdate);
        $setValues = implode(",", $setValues);

        $values = $setValues;

        $req_update = "UPDATE " . strtolower($this->table) . " SET " . $set . "";

        $whereUpdate = [];
        if ($where != NULL) {

            $whereKey = array_keys($where);
            $whereValues = array_values($where);

            foreach ($whereKey as $key => $value) {
                $whereUpdate[] .= $value;
            }

            $where = implode(" ", $whereUpdate);
            $whereValues = implode(",", $whereValues);

            $req_update .= " WHERE " . $where . "";
            $values .= "," . $whereValues;
        }

        $values = explode(",", $values);

        $update = $this->pdo->prepare($req_update);
        $update->execute($values);
    }

    /**
     * 
     * 	Fonction de suppression en base de données
     * 
     * 	@param array $where	conditions de suppression
     * 
     */

    public function delete($where = NULL)
    {

        $req_delete = "DELETE FROM " . strtolower($this->table) . "";

        if ($where != NULL) {

            $whereKey = array_keys($where);
            $whereValues = array_values($where);

            $whereDelete = [];
            foreach ($whereKey as $key => $value) {
                $whereDelete[] .= $value;
            }

            $where = implode(" ", $whereDelete);

            $whereValues = implode(",", $whereValues);

            $req_delete .= " WHERE " . $where . "";

            $whereValues = explode(",", $whereValues);
        }

        $delete = $this->pdo->prepare($req_delete);
        if ($where != NULL)
            $delete->execute($whereValues);
        else
            $delete->execute();
    }

    /**
     * 
     * 	Fonction de sélection en base de données
     * 
     * 	@param array $select elements a selectionner
     * 	@param array $where conditions de selection
     * 	@param array $orderBy_limit_offset	ordre d affichage / limite / offset
     * 	@param array $innerJoin	jointure
     * 	@param string $tag	tag de la table
     * 
     * 	@return array liste éléments
     * 
     * 
     */

    public function select($select, $where = NULL, $orderBy_limit_offset = NULL, $innerJoin = NULL, $tag = NULL)
    {

        $select = implode(",", $select);

        $req_select = "SELECT " . $select . " FROM " . strtolower($this->table) . "";

        if ($tag != NULL)
            $req_select .= " " . $tag . "";

        if ($innerJoin != NULL) {

            $innerJoin = implode(" INNER JOIN ", $innerJoin);
            $req_select .= " INNER JOIN " . $innerJoin . "";
        }

        if ($where != NULL) {

            $whereKey = array_keys($where);
            $whereValues = array_values($where);

            $whereSelect = [];
            foreach ($whereKey as $key => $value) {
                $whereSelect[] .= $value;
            }

            $where = implode(" ", $whereSelect);

            $whereValues = implode(",", $whereValues);

            $req_select .= " WHERE " . $where . "";

            $whereValues = explode(",", $whereValues);
        }

        if ($orderBy_limit_offset != NULL) {

            $orderBy_limit_offset = implode("", $orderBy_limit_offset);
            $req_select .= " " . $orderBy_limit_offset;
        }

        $select = $this->pdo->prepare($req_select);

        if ($where != NULL)
            $select->execute($whereValues);
        else
            $select->execute();

        return $select->fetchAll(PDO::FETCH_ASSOC);
    }
}
