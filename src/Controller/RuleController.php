<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RuleController extends AbstractController
{
    #[Route('/rule', name: 'app_rule')]
    public function index(): Response
    {
        return $this->render('rule/index.html.twig', [
            'controller_name' => 'RuleController',
        ]);
    }
}
