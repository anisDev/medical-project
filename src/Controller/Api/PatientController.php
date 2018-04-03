<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;


class PatientController extends Controller
{
	/**
	 * @SWG\Tag(name="list_patients")
	 * @Route("/api/patients", methods={"GET"})
	 * @SWG\Response( response=200,description="Returns all patients" )
	 */
	public function listPatientsAction(){
		$patients = $this->getDoctrine()->getRepository('App:Patient')->findAll();
		$data = [];
		foreach ($patients as $patient) {
			$data[] = [
				'id'     => $patient->getId(),
				'fullName'     => $patient->getFullName(),
				'sexe'  => $patient->getSexe(),
				'dataNaissance' => $patient->getDateNaissance(),
				'mobile' => $patient->getMobile(),
				'email' => $patient->getEmail(),
			];
		}

		return new JsonResponse($data);
	}

}