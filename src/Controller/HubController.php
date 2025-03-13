<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HubController extends AbstractController
{
//    #[Route('', name: 'app_index')]
//    public function index(): Response
//    {
//        return $this->render('hub/index.html.twig');
//    }
    #[Route('/aboutUs', name: 'app_about_us')]
    public function aboutUs(): Response
    {
        return $this->render('hub/aboutUs.html.twig');
    }
    #[Route('/reseaux', name: 'app_reseaux')]
    public function reseaux(): Response
    {
        return $this->render('hub/reseaux.html.twig');
    }
}
