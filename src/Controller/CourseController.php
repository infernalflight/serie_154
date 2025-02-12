<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/course', name: 'course_')]
final class CourseController extends AbstractController
{
    #[Route('/', name: 'list', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('course/index.html.twig', [
            'title' => 'Liste des cours',
        ]);
    }

    #[Route('/{id}', name: 'detail', requirements: ['id'=>'\d+'], methods: ['GET'])]
    public function show(int $id): Response
    {
        return $this->render('course/show.html.twig', [
            'title' => 'Fiche de cours',
        ]);
    }

    #[Route('/create', name: 'create', methods: ['GET', 'POST'])]
    public function add(): Response
    {
        // Form Validation

        return $this->render('course/add.html.twig', [
            'title' => 'Créer un cours',
        ]);
    }

    #[Route('/edit/{id}', name: 'edit', methods: ['GET', 'POST'], requirements: ['id'=>'\d+'])]
    public function update(int $id): Response
    {
        // Form Validation

        return $this->render('course/update.html.twig', [
            'title' => 'Mise à jour d\'un cours',
        ]);
    }
}
