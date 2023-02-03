<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

use App\Repository\VinylMixRepository;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;

class VinylController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function index(): Response
    {
       return $this->render('index.html.twig');
    }

    // #[Route('/browse')]
    // public function browse(): Response
    // {
    //    return new Response('browse - main ');
    // }

    #[Route('/browse/{genre}', methods: ['GET'])]
    public function browse(VinylMixRepository $mixRepository, Request $request, string $genre = null): Response
    {
        $queryBuilder = $mixRepository->createOrderedByVotesQueryBuilder($genre);

        $adapter = new QueryAdapter($queryBuilder);
        $pagerfanta = Pagerfanta::createForCurrentPageWithMaxPerPage(
            $adapter,
            $request->query->get('page', 1),
            5
        );        

        return $this->render('vinyl/browse.html.twig', [
            'pager' => $pagerfanta,            
        ]);
    }

    #[Route('/mix/{id}')]
    public function show($id, VinylMixRepository $mixRepository): Response
    {
        
        $mix = $mixRepository->find($id);
        dd($mix);
    }

}

