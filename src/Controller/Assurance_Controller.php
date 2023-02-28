<?php

namespace App\Controller;

use App\Entity\Region;
use App\Entity\Assurance;
use App\Repository\AssuranceRepository;
use App\Repository\RegionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class Assurance_Controller extends AbstractController

{
    /**
     * @Route("/Assurances/json", name="AssurancesJsonAction")
     * @throws ExceptionInterface
     */
    public function AssurancesJsonAction(AssuranceRepository $assuranceRepository,SerializerInterface $serializer ): JsonResponse
    {
        // $assurances = new Assurance();
        $assurances = $assuranceRepository->findAll();
        $json=$serializer->serialize($assurances,'json',[AbstractNormalizer::IGNORED_ATTRIBUTES=>['adresse'],]);

        return new JsonResponse($json,200,[],true);

        // return $this->json([
        //     'data'=>$assurances
        // ],200,[],[ObjectNormalizer::CIRCULAR_REFERENCE_HANDLER => function()
        //     {return 'symfony4';}]
        // );
    }

    /**
     * @Route("/assurances/json/new", name="AssurancesJsonNewAction")
     */
    public function newAssuranceJson(RegionRepository $regionRepository, Request $request): JsonResponse
    {
        $assurance = new Assurance();
        // $user = $userRepository->find($request->get('user'));
        $region = $regionRepository->find($request->get('region'));

        $em = $this->getDoctrine()->getManager();

        $assurance->setNom($request->get('nom'));
        $assurance->setTelephone($request->get('telephone'));
        $assurance->setmail($request->get('mail'));
        $assurance->setRegion($region);


        $em->persist($assurance);
        $em->flush();

        return new JsonResponse($assurance);
    }

    /**
     * @Route("/assurances/json/update", name="AssurancesJsonUpdateAction")
     */
    public function updateAssuranceJson(AssuranceRepository $assuranceRepository, Request $request): JsonResponse
    {

        $em = $this->getDoctrine()->getManager();

        $assurance = $assuranceRepository->find($request->get('id'));
        $assurance->setNom($request->get('nom'));
        $assurance->setTelephone($request->get('telephone'));
        $assurance->setmail($request->get('mail'));

        $em->flush();

        return new JsonResponse($assurance);
    }

    /**
     * @Route("/assurances/json/delete", name="deleteAssurancesJsonAction")
     * @throws ExceptionInterface
     */
    public function deleteAssurancesJsonAction(AssuranceRepository $assuranceRepository, Request $request): JsonResponse
    {
        $id = $request->get("id");

        $em = $this->getDoctrine()->getManager();
        $assurance = $em->getRepository(Assurance::class)->find($id);
        if($assurance!=null ) {
            $em->remove($assurance);
            $em->flush();

            $serialize = new Serializer([new ObjectNormalizer()]);
            $formatted = $serialize->normalize("Assurance a ete supprimee avec success.");
            return new JsonResponse($formatted);

        }
        return new JsonResponse("id Assurance invalide.");
    }

}
?>