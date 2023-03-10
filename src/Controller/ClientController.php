<?php

namespace App\Controller;
use Dompdf\Dompdf;
use App\Entity\Assurance;
use App\Form\AssuranceType;
use App\Repository\AssuranceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;

#[Route('/Client')]
class ClientController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function home(): Response
    {
        return $this->render('client/home.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }
    #[Route('/header', name: 'app_header')]
    public function header(): Response
    {
        return $this->render('client/header.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }

    #[Route('/Contactus', name: 'app_Contactus')]
    public function contactus(): Response
    {
        return $this->render('client/Contactus.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }


    #[Route('/Aboutus', name: 'app_Aboutus')]
    public function Aboutus(): Response
    {
        return $this->render('client/Aboutus.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }

    #[Route('/E404', name: 'app_E404')]
    public function E404(): Response
    {
        return $this->render('client/E404.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }
    #[Route('/Actualites', name: 'app_Actualites')]
    public function Actualites(): Response
    {
        return $this->render('client/Actualites.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }


    #[Route('/ActualiteInfo', name: 'app_ActualiteInfo')]
    public function ActualiteInfo(): Response
    {
        return $this->render('client/ActualiteInfo.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }


    #[Route('/EspaceClient', name: 'app_EspaceClient')]
    public function EspaceClient(): Response
    {
        return $this->render('client/EspaceClient.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }


    #[Route('/EspaceVeterinaire', name: 'app_EspaceVeterinaire')]
    public function EspaceVeterinaire(): Response
    {
        return $this->render('client/EspaceVeterinaire.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }
    
    /*  #[Route('/afficher', name: 'app_assurance_afficher')]
   public function afficher(AssuranceRepository $assuranceRepository): Response
    {
        return $this->render('client/afficher.html.twig', [
            'assurances' => $assuranceRepository->findAll(),
        ]);
        
    }*/
    #[Route('/afficher', name: 'app_assurance_afficher')]
    public function afficher(Request $request, AssuranceRepository $assuranceRepository,PaginatorInterface $paginator): Response
{
    
    $query = $request->query->get('query');
    
    if ($query) {
        $donnees = $assuranceRepository->search($query);
        $assurances = $paginator->paginate(
            $donnees,
            $request->query->getInt('page',1),
            3
        );
    } else {
        $donnees = $assuranceRepository->findAll();
        $assurances = $paginator->paginate(
            $donnees,
            $request->query->getInt('page',1),
            3
        );
    }
    return $this->render('client/afficher.html.twig', [
        'assurances' => $assurances,
    ]);
}



#[Route('/{id}', name: 'app_pdf', methods: ['GET'])]
public function pdf(Request $request, AssuranceRepository $assuranceRepository, int $id): Response
{
    
    $assurances = $this->getDoctrine()
    ->getRepository(Assurance::class)
    ->find($id);
   

    $html= $this->render('client/show.html.twig', [
        'assurances' => $assurances,
    ]);
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);

    // (Optional) Setup the paper size and orientation
    $dompdf->setPaper('A4', 'portrait');

    // Render the HTML as PDF
    $dompdf->render();

    // Output the generated PDF to the browser
    $output = $dompdf->output();
    $response = new Response($output);
    $response->headers->set('Content-Type', 'application/pdf');

    return $response;
       
    }
/*#[Route('/afficher', name: 'app_assurance_afficher')]
public function findByNomAndRegion(string $nom, string $region)
{
    $qb = $this->createQueryBuilder('assurance')
        ->leftJoin('assurance.region', 'region')
        ->where('assurance.nom LIKE :nom')
        ->andWhere('region.region LIKE :region')
        ->setParameter('nom', '%' . $nom . '%')
        ->setParameter('region', '%' . $region . '%')
        ->getQuery();

    return $qb->execute();
}*/



}
