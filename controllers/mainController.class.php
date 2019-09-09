<?php
class mainController
{

	/*
	*
	*
	************************************************************************************
	*
	*
	***
		action Home page
	**/
	public function homeAction()
	{
		$v = new View("home", "front");
	}

	/*
	*
	*
	************************************************************************************
	*
	*
	***
		display candidate form and advert admins in candidate section
	**/
	public function candidatesAction()
	{

		$candidate = new Candidates();

		$v = new View("jobs", "front");

		//Formulaire de changement d'Email'
		$candidateForm = $candidate->getCandidateBoosterForm();

		$method = strtoupper($candidateForm["config"]["method"]);
		$data = $GLOBALS["_" . $method];

		if ($_SERVER['REQUEST_METHOD'] == $method && !empty($data)) {
			$validator = new Validator($candidateForm, $data);
			$candidateForm["errors"] = $validator->errors;

			if (empty($validator->errors)) {
				$candidate->setNickname($data['nickname']);
				$candidate->setFaceit_link($data['faceit_link']);
				$candidate->setEsea_link($data['esea_link']);
				$candidate->setDescription($data['description']);
				$candidate->setEmail($data['email']);
				$candidate->setSkype($data['skype']);
				$candidate->postCandid();
			} else {
				$validator->errors = ["champs incorrects"];
				$candidateForm["errors"] = $candidate->errors;
			}
		}

		$v->assign("formCandidates", $candidateForm);
	}
}
