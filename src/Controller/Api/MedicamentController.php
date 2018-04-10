<?php

namespace App\Controller\Api;

use App\Entity\Medicament;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;


class MedicamentController extends Controller
{
	/**
	 * @SWG\Tag(name="list_medicaments")
	 * @Route("/api/medicaments", methods={"GET"})
	 * @SWG\Response( response=200,description="Returns all the medicaments" )
	 */
	public function listMedicamentAction(){
		$medicaments = $this->getDoctrine()->getRepository('App:Medicament')->findAll();
		$data = [];
		foreach ($medicaments as $medicament) {
			$data[] = [
				'id'     => $medicament->getId(),
				'nom'     => $medicament->getNom(),
				'posologie'  => $medicament->getPosologie(),
				'contreIndication' => $medicament->getContreIndication(),
			];
		}

		return new JsonResponse($data);
	}

	/**
	 * @SWG\Tag(name="add_medicament")
	 * @Route("/api/medicaments", methods={"POST"})
	 * @SWG\Response( response=200,description="add new medicament" )
	 * @SWG\Parameter(name="nom", in="query", type="string", description="medicament nom", required=true)
	 * @SWG\Parameter(name="posologie", in="query", type="string", description="medicament posologie", required=true)
	 * @SWG\Parameter(name="contreIndication", in="query", type="string", description="medicament contre indication",
	 *     required=true)
	 */
	public function addMedicamentAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$medicament = new Medicament();
		$medicament->setNom($request->query->get('nom'));
		$medicament->setPosologie($request->query->get('posologie'));
		$medicament->setContreIndication($request->query->get('contreIndication'));
		$em->persist($medicament);
		$em->flush();
		return new JsonResponse('done');
	}

	/**
	 * @SWG\Tag(name="edit_medicament")
	 * @Route("/api/medicaments", methods={"PUT"})
	 * @SWG\Response( response=200,description="edit existing medicament" )
	 * @SWG\Parameter(name="id", in="query", type="number", description="medicament id", required=true)
	 * @SWG\Parameter(name="nom", in="query", type="string", description="medicament nom")
	 * @SWG\Parameter(name="posologie", in="query", type="string", description="medicament posologie")
	 * @SWG\Parameter(name="contreIndication", in="query", type="string", description="medicament contre indication")
	 */
	public function editMedicalAction(Request $request)
	{
		$id = $request->query->get('id');
		$em = $this->getDoctrine()->getManager();
		$medicament = $em->getRepository(Medicament::class)
			->findOneBy(array('id' => $id));

		if(!$medicament)
			throw $this->createNotFoundException('Unable to find medicament entity');

		if($request->query->get('nom'))
			$medicament->setNom($request->query->get('nom'));
		if($request->query->get('posologie'))
			$medicament->setPosologie($request->query->get('posologie'));
		if($request->query->get('contreIndication'))
			$medicament->setContreIndication($request->query->get('contreIndication'));

		$em->persist($medicament);
		$em->flush();

		return new JsonResponse('done');
	}

	/**
	 * @SWG\Tag(name="delete_medicament")
	 * @Route("/api/medicaments", methods={"DELETE"})
	 * @SWG\Response( response=200,description="delete existing medicament" )
	 * @SWG\Parameter(name="id", in="query", type="number", description="medicament id")
	 */
	public function deleteMedicamentAction(Request $request)
	{
		$id      = $request->query->get('id');
		$em      = $this->getDoctrine()->getManager();
		$medicament = $em->getRepository(Medicament::class)
			->findOneBy(['id' => $id]);

		if (!$medicament) {
			throw $this->createNotFoundException('Unable to find medicament entity');
		}

		$em->remove($medicament);
		$em->flush();
	}

}