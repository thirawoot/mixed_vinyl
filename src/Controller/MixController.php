<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\VinylMixRepository;
use App\Entity\VinylMix;
use Doctrine\ORM\EntityManagerInterface;

class MixController extends AbstractController
{
    #[Route('/mix', name: 'app_mix')]
    public function index(): Response
    {
        return $this->render('mix/index.html.twig', [
            'controller_name' => 'MixController',
        ]);
    }

    #[Route('/mix/{id}', name: 'app_mix_show')]
    public function show(VinylMix $mix): Response
    {
        //if ($mix = $mixRepository->find($id)) {
            //dump($mix);
            return $this->render('mix/index.html.twig', [
                'mix' => $mix,
            ]);
        //}

        //throw $this->createNotFoundException();
    }

    #[Route('/mix/{id}/vote', name: 'app_mix_vote', methods: ['POST'])]
    public function vote(VinylMix $mix, Request $request, EntityManagerInterface $entityManager): Response
    {
        $direction = $request->request->get('direction', 'up');
        if ($direction === 'up') {
            $mix->upVote();
        } else {
            $mix->downVote();
        }
        $entityManager->flush();
        $this->addFlash('success', 'Vote counted!');
        
        return $this->redirectToRoute('app_mix_show', [
            'id' => $mix->getId(),
        ]);

    }

    
}
