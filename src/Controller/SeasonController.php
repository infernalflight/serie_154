<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Season;
use App\Form\SeasonType;

#[Route('/season', name: 'season')]
final class SeasonController extends AbstractController
{

    #[Route('/create', name: '_create')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $season = new Season();
        $form = $this->createForm(SeasonType::class, $season);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($season);
            $em->flush();

            $this->addFlash('success', 'Season created!');

            return $this->redirectToRoute('serie_detail', ['id' => $season->getSerie()->getId()]);
        }

        return $this->render('season/edit.html.twig', [
            'form' => $form,
        ]);
    }
}
