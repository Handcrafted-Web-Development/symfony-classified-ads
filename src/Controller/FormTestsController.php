<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FormTestsController extends AbstractController
{
    #[Route('/form/tests', name: 'app_form_tests')]
    public function index(): Response
    {
        return $this->render('form_tests/index.html.twig', [
            'controller_name' => 'FormTestsController',
        ]);
    }
}
