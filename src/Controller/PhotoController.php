<?php

namespace App\Controller;

use App\Entity\Photo;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

    #[Route('/photo-store', name: 'store_photo')]
    public function store(EntityManagerInterface $entityManager)
    {
        $t = time();
        $photo = new Photo();
        $photo->setName('photo-'.$t.'.png');
        $photo->setPath('/photos/photo-'.$t.'.png');
        $photo->setHeight(800);
        $photo->setWidth(1200);
        $photo->setCreatedAt(new \DateTime());
        $photo->setUpdatedAt(new \DateTime());
        $entityManager->persist($photo);
        $entityManager->flush();
        return new Response('Saved new photo with id '.$photo->getId());
    }
}
