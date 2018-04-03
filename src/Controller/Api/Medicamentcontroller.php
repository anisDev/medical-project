<?php

namespace App\Controller\Api;

use App\Entity\Medicament;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;


class Medicamentcontroller extends Controller
{
	/**
	 * @SWG\Tag(name="list_medicaments")
	 * @Route("/api/medicaments", methods={"GET"})
	 * @SWG\Response( response=200,description="Returns all the medicaments" )
	 */
	public function testAction(){
		$medicaments = $this->getDoctrine()->getRepository('App:Medicament')->findAll();
		$data = [];
		foreach ($medicaments as $medicament) {
			$data[] = [
				'id'     => $medicament->getId(),
				'name'     => $medicament->getName(),
				'price'  => $medicament->getPrice(),
				'description' => $medicament->getDescription(),
			];
		}

		return new JsonResponse($data);
	}

	/**
	 * @SWG\Tag(name="add_medicament")
	 * @Route("/api/medicaments", methods={"POST"})
	 * @SWG\Response( response=200,description="add new medicament" )
	 * @SWG\Parameter(name="name", in="query", type="string", description="medicament name", required=true)
	 * @SWG\Parameter(name="price", in="query", type="number", description="medicament price", required=true)
	 * @SWG\Parameter(name="description", in="query", type="string", description="medicament description",
	 *     required=true)
	 */
	public function addMedicamentAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$medicament = new Medicament();
		$medicament->setName($request->query->get('name'));
		$medicament->setPrice($request->query->get('price'));
		$medicament->setDescription($request->query->get('description'));
		$em->persist($medicament);
		$em->flush();
		return new JsonResponse('done');
	}

	/**
	 * @SWG\Tag(name="edit_medicament")
	 * @Route("/api/medicaments", methods={"PUT"})
	 * @SWG\Response( response=200,description="edit existing medicament" )
	 * @SWG\Parameter(name="id", in="query", type="number", description="medicament id", required=true)
	 * @SWG\Parameter(name="name", in="query", type="string", description="medicament name")
	 * @SWG\Parameter(name="price", in="query", type="number", description="medicament price")
	 * @SWG\Parameter(name="description", in="query", type="string", description="medicament description")
	 */
	public function editMedicalAction(Request $request)
	{
		$id = $request->query->get('id');
		$em = $this->getDoctrine()->getManager();
		$medicament = $em->getRepository(Medicament::class)
			->findOneBy(array('id' => $id));

		if(!$medicament)
			throw $this->createNotFoundException('Unable to find medicament entity');

		if($request->query->get('name'))
			$medicament->setName($request->query->get('name'));
		if($request->query->get('price'))
			$medicament->setPrice($request->query->get('price'));
		if($request->query->get('description'))
			$medicament->setDescription($request->query->get('description'));

		$em->persist($medicament);
		$em->flush();

		return new JsonResponse('done');
	}

}