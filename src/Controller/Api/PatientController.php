<?php

namespace App\Controller\Api;

use App\Entity\Patient;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;


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

	/**
	 * @SWG\Tag(name="add_patient")
	 * @Route("/api/patients", methods={"POST"})
	 * @SWG\Response( response=200,description="add new patient" )
	 * @SWG\Parameter(name="fullname", in="query", type="string", description="patient_fullname", required=true)
	 * @SWG\Parameter(name="sexe", in="query", type="string", description="patient sexe", required=true)
	 * @SWG\Parameter(name="dataNaissance", in="query", type="string", description="patient datanaissance",
	 *     required=true)
	 * @SWG\Parameter(name="mobile", in="query", type="string", description="patient mobile", required=true)
	 * @SWG\Parameter(name="email", in="query", type="string", description="patient email", required=true)
	 */
	public function addPatientAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$patient = new Patient();
		$patient->setFullName($request->query->get('fullname'));
		$patient->setSexe($request->query->get('sexe'));
		$patient->setDateNaissance($request->query->get('dateNaissance'));
		$patient->setMobile($request->query->get('mobile'));
		$patient->setEmail($request->query->get('email'));

		$em->persist($patient);
		$em->flush();
		return new JsonResponse('done');
	}

	/**
	 * @SWG\Tag(name="edit_patient")
	 * @Route("/api/patients", methods={"PUT"})
	 * @SWG\Response( response=200,description="edit existing patient" )
	 * @SWG\Parameter(name="id", in="query", type="number", description="patient id")
	 * @SWG\Parameter(name="fullname", in="query", type="string", description="patient_fullname")
	 * @SWG\Parameter(name="sexe", in="query", type="string", description="patient sexe")
	 * @SWG\Parameter(name="dataNaissance", in="query", type="string", description="patient datanaissance")
	 * @SWG\Parameter(name="mobile", in="query", type="string", description="patient mobile")
	 * @SWG\Parameter(name="email", in="query", type="string", description="patient email")
	 */
	public function editPatientAction(Request $request)
	{
		$id = $request->query->get('id');
		$em = $this->getDoctrine()->getManager();
		$patient = $em->getRepository(Patient::class)
			->findOneBy(array('id' => $id));

		if(!$patient)
			throw $this->createNotFoundException('Unable to find patient entity');

		if($request->query->get('fullname'))
			$patient->setFullName($request->query->get('fullname'));
		if($request->query->get('sexe'))
			$patient->setSexe($request->query->get('sexe'));
		if($request->query->get('datenaissance'))
			$patient->setDateNaissance($request->query->get('datenaissance'));
		if($request->query->get('mobile'))
			$patient->setMobile($request->query->get('mobile'));
		if($request->query->get('email'))
			$patient->setEmail($request->query->get('email'));

		$em->persist($patient);
		$em->flush();

		return new JsonResponse('done');
	}

	/**
	 * @SWG\Tag(name="delete_patient")
	 * @Route("/api/patients", methods={"DELETE"})
	 * @SWG\Response( response=200,description="delete existing patient" )
	 * @SWG\Parameter(name="id", in="query", type="number", description="patient id")
	 */
	public function deletePatientAction(Request $request)
	{
		$id = $request->query->get('id');
		$em = $this->getDoctrine()->getManager();
		$patient = $em->getRepository(Patient::class)
			->findOneBy(array('id' => $id));

		if(!$patient)
			throw $this->createNotFoundException('Unable to find patient entity');

		$em->remove($patient);
		$em->flush();

		return new JsonResponse('done');
	}

}