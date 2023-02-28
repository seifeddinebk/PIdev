<?php


namespace App\Controller;


use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Assurance;
use App\Entity\Region;
use App\Serializer\CircularReferenceHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Validator\Constraints\Json;
use App\Repository\RegionRepository;

use Symfony\Component\Serializer\SerializerInterface;

use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;


class Region_Controller extends  AbstractController
{


    /******************Ajouter Region*****************************************/
    /**
     * @Route("/addRegion", name="add_Region")
     * @Method("POST")
     */

    public function ajouterRegionAction(Request $request)
    {
        $Region = new Region();
        $regione = $request->query->get("region");
        $adresse = $request->query->get("adresse");

        $em = $this->getDoctrine()->getManager();


        $Region->setRegion($regione);
        $Region->setAdresse($adresse);



        $em->persist($Region);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($Region);
        return new JsonResponse($formatted);

    }

    /******************Supprimer Region*****************************************/

    /**
     * @Route("/deleteRegion", name="delete_Region")
     * @Method("DELETE")
     */

    public function deleteRegionAction(Request $request) {
        $id = $request->get("id");

        $em = $this->getDoctrine()->getManager();
        $Region = $em->getRepository(Region::class)->find($id);
        if($Region!=null ) {
            $em->remove($Region);
            $em->flush();

            $serialize = new Serializer([new ObjectNormalizer()]);
            $formatted = $serialize->normalize("Region a ete supprimee avec success.");
            return new JsonResponse($formatted);

        }
        return new JsonResponse("id Region invalide.");


    }

    /******************Modifier Region*****************************************/
    /**
     * @Route("/updateRegion", name="update_Region")
     * @Method("POST")
     */

    public function modifierRegionAction(RegionRepository $regionRepository,Request $request) {
        /* $em = $this->getDoctrine()->getManager();
         $Article = $this->getDoctrine()->getManager()
                         ->getRepository(Article::class)
                         ->find($request->get("id"));

          $Article->setImage($request->get('image'));
          $Article->setNom($request->get('nom'));
           $Article->setDescription($request->get('Description'));
           $Article->setEtat('desarchive');
            $Article->setPrix($request->get('prix'));

         $em->persist($Article);
         $em->flush();
         $serializer = new Serializer([new ObjectNormalizer()]);
         $formatted = $serializer->normalize($Article);
         return new JsonResponse("Article a ete modifiee avec success.");*/

        $em = $this->getDoctrine()->getManager();

        $region = $regionRepository->find($request->get('id'));


        $region->setRegion($request->get('region'));

        $region->setAdresse($request->get('adresse'));

        $em->persist($region);
        $em->flush();

        return new JsonResponse($region);

    }





    /******************Detail Region*****************************************/

    /**
     * @Route("/detailRegion", name="detail_Region")
     * @Method("GET")
     */

    //Detail Region
    public function detailRegionAction(Request $request)
    {
        $id = $request->get("id");

        $em = $this->getDoctrine()->getManager();
        $Region = $this->getDoctrine()->getManager()->getRepository(Region::class)->find($id);
        return $this->json([
            'data'=>$Region
        ],200,[],[ObjectNormalizer::CIRCULAR_REFERENCE_HANDLER => function()
            {return 'symfony4';}]
        );
    }


    /**
     * @Route("/displayRegion", name="display_region_json")
     *  * @Method("GET")
     */
    public function allRecAction( SerializerInterface $serializer ,RegionRepository $repository):JsonResponse
    {

        /*$article = $repository->findAll();
         $serializer = new Serializer([new ObjectNormalizer()]);
         $formatted = $serializer->normalize($article);

         return new JsonResponse($formatted);*/
         $regions = $repository->findAll();
         $json=$serializer->serialize($regions,'json',[AbstractNormalizer::IGNORED_ATTRIBUTES=>['adresse'],]);
        /* $encoder = new JsonEncoder();
         $normalizer = new ObjectNormalizer();
          ObjectNormalizer::CIRCULAR_REFERENCE_HANDLER => function()
          {return 'symfony4';};
         $serializer = new Serializer( $normalizer,[$encoder]);
         $formatted = $serializer->normalize($articles);*/
return new JsonResponse($json,200,[],true);
    //    return $this->json([
           // 'data'=>$regions
     //   ],200,[],[ObjectNormalizer::CIRCULAR_REFERENCE_HANDLER => function()
       //     {return 'symfony4';}]
     //   );



    }



}