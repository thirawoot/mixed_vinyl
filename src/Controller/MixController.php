<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\VinylMixRepository;
use App\Entity\VinylMix;
use Doctrine\ORM\EntityManagerInterface;

class MixController extends AbstractController
{
    #[Route('/mix', name: 'app_mix')]
    public function index(VinylMixRepository $mixRepository): Response
    {
        if (!$mix = $mixRepository->findAll()) {
            $mix = new VinylMix;    //throw $this->createNotFoundException();
        }

        return $this->render('mix/index.html.twig', [
            'mix' => $mix,
        ]);
    }

    #[Route('/mix/new')]
    public function new(EntityManagerInterface $entityManager): Response
    {
        $genres = ['pop', 'rock'];

        $mix = new VinylMix();
        $mix->setTitle('Do you Remember... Phil Collins?!');
        $mix->setDescription('A pure mix of drummers turned singers!');
        $mix->setGenre($genres[array_rand($genres)]);
        $mix->setTrackCount(rand(5, 20));
        $mix->setVotes(rand(-50, 50));
        $entityManager->persist($mix);
        $entityManager->flush();

        return new Response(sprintf(
            'Mix %d is %d tracks of pure 80\'s heaven',
            $mix->getId(),
            $mix->getTrackCount()
        ));
    }

    #[Route('/mix/{slug}', name: 'app_mix_show')]
    public function show(VinylMix $mix): Response
    {
        //if ($mix = $mixRepository->find($id)) {
            //dump($mix);
            return $this->render('mix/show.html.twig', [
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
            'slug' => $mix->getSlug(),
            //'id' => $mix->getId(),
        ]);

    }

    
}
