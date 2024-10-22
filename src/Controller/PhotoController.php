<?php

namespace App\Controller;

use App\Entity\Photo;
use App\Form\PhotoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PhotoController extends AbstractController
{
    #[Route('/photo', name: 'app_photo')]
    public function index(): Response
    {
        return $this->render('photo/index.html.twig', [
            'controller_name' => 'PhotoController',
        ]);
    }


    #[Route('/photos/upload', name: 'create_photo', methods: ['GET'])]
    public function create()
    {
        $photo = new Photo();
        $form = $this->createForm(PhotoType::class, $photo);
        return $this->render('photo/create.html.twig', ['form' => $form]);
    }

    #[Route('/photos/store', name: 'store_photo', methods: ['POST'])]
    public function store(EntityManagerInterface $entityManager, Request $request)
    {
        $photo = new Photo();
        $form = $this->createForm(PhotoType::class, $photo);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $photo = $form->getData();
            $photo->setPath('/photos/photo-'.time().'.png');
            $entityManager->persist($photo);
            $entityManager->flush();
            $this->redirectToRoute('app_photo');
        }
        return new Response('Saved new photo with id '.$photo->getId());
    }
}
