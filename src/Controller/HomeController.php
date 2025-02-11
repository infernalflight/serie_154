<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'title' => 'Home',
        ]);
    }

    #[Route('/about', name: 'app_about')]
    public function about(): Response
    {
        return $this->render('home/about.html.twig', [
            'title' => 'About',
        ]);
    }

    #[Route('/test', name: 'app_test')]
    public function test(): Response
    {
        $students = ['tim', 'said', 'soto', 'amelie'];

//        dump($students);
        dd($students);

        return $this->render('home/test.html.twig', [
            'title' => 'Test',
            'promo' => $students,
        ]);
    }
}
