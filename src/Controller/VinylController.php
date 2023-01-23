<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

use App\Repository\VinylMixRepository;

class VinylController extends AbstractController
{
    #[Route('/')]
    public function index(): Response
    {
       return $this->render('index.html.twig');
    }

    // #[Route('/browse')]
    // public function browse(): Response
    // {
    //    return new Response('browse - main ');
    // }

    #[Route('/browse/{slug}', methods: ['GET'])]
    public function browse(VinylMixRepository $mixRepository, $slug = null): Response
    {
        //SluggerInterface

        $mixes = $mixRepository->findAllOrderedByVotes();
        return new Response('browse: ' . $slug);
    }
}

