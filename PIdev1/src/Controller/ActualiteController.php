<?php

namespace App\Controller;

use App\Entity\Actualite;
use App\Form\ActualiteType;
use App\Repository\ActualiteRepository;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Form\Extension\Core\Type\TextType; 
use Symfony\Component\Form\Extension\Core\Type\FileType; 
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use AppBundle\Form\FormValidationType; 

// use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route; 





use DateTimeImmutable;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/actualite')]
class ActualiteController extends AbstractController
{
    #[Route('/', name: 'app_actualite_index', methods: ['GET'])]
    public function index(ActualiteRepository $actualiteRepository): Response
    {
        return $this->render('admin/actualites.html.twig', [
            'actualites' => $actualiteRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_actualite_new', methods: ['GET', 'POST'])]
    public function new(Request $request,  ActualiteRepository $actualiteRepository, EntityManagerInterface $entityManager): Response
    {
        $actualite = new Actualite();
        $actualite->setDateActualite(new DateTimeImmutable());
        $form = $this->createForm(ActualiteType::class, $actualite);
        $form->handleRequest($request);
        

        if ($form->isSubmitted() && $form->isValid()) {
            // /** @var UploadedFile $imageFile */
             $imageFile=$form->get('imageFile')->getData();
             if($imageFile){
                 $newFilename=md5(uniqid(). '.' .$imageFile->guessExtension());
            }
            try{
                 $imageFile->move(
                    $this->getParameter('media'),
                    $newFilename
               );
             }
             catch(FileException $e){

             }
             $actualite->setImageFile($newFilename);
             $entityManager->persist($actualite);
             $entityManager->flush();


        //     $file = $actualite->getImg(); 
        //  $fileName = md5(uniqid()).'.'.$file->guessExtension(); 
        //  $file->move($this->getParameter('photos_directory'), $fileName); 
        //  $actualite->setImg($fileName); 
        //  return new Response("User photo is successfully uploaded."); 

            // $imagefile=$form->get('image')->getData();
            // if ($imagefile) {
            //     $imageName = $fileUploader->upload($imagefile);
            //     $actualite->setImage($imageName);
            // }
            // $actualiteRepository->save($actualite, true);

            return $this->redirectToRoute('app_actualite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('actualite/new.html.twig', [
            'actualite' => $actualite,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_actualite_show', methods: ['GET'])]
    public function show(Actualite $actualite): Response
    {
        return $this->render('actualite/show.html.twig', [
            'actualite' => $actualite,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_actualite_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Actualite $actualite, ActualiteRepository $actualiteRepository, ): Response
    {
        $form = $this->createForm(ActualiteType::class, $actualite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile=$form->get('imageFile')->getData();
             if($imageFile){
                 $newFilename=md5(uniqid(). '.' .$imageFile->guessExtension());
            }
            $actualiteRepository->save($actualite, true);

            return $this->redirectToRoute('app_actualite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('actualite/edit.html.twig', [
            'actualite' => $actualite,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_actualite_delete', methods: ['POST'])]
    public function delete(Request $request, Actualite $actualite, ActualiteRepository $actualiteRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$actualite->getId(), $request->request->get('_token'))) {
            $actualiteRepository->remove($actualite, true);
        }

        return $this->redirectToRoute('app_actualite_index', [], Response::HTTP_SEE_OTHER);
    }

   
}
