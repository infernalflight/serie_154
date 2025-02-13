<?php

namespace App\Controller;

use App\Entity\Serie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/serie', name: 'app_serie_')]
final class SerieController extends AbstractController
{
    #[Route('/', name: 'list', methods: ['GET'])]
    public function index(EntityManagerInterface $em): Response
    {
        $serieRepo = $em->getRepository(Serie::class);
//        $series = $serieRepo->findAll();
//        $serie = $serieRepo->find(5);

        // TODO Pensez à regarder les requête SQL générée histoire d'optimiser si nécessaire
//        $serie = $serieRepo->findBy(['name' => 'pif']);
//        $series = $serieRepository->findBy([], ['popularity' => 'DESC', 'vote' => 'DESC'], 30);

        // Get DQL Method From Repository
        $series = $serieRepo->getOnlyBestSeriesDQL();

        return $this->render('serie/index.html.twig', [
            'title' => 'Serie',
            'series' => $series,
        ]);
    }

    #[Route('/create', name: 'new', methods: ['GET'])]
    public function new(EntityManagerInterface $em): Response
    {
        // Emulate New Serie Form
        $serie = new Serie();
        // hydrate toutes les propriétés
        $serie->setName('golum');
        $serie->setBackdrop('dafsd');
        $serie->setPoster('barry-73107.jpg');
        $serie->setCreatedAt(new \DateTimeImmutable());
        $serie->setFirstAirDate(new \DateTime("-1 year"));
        $serie->setLastAirDate(new \DateTime("-6 month"));
        $serie->setGenres('drama');
        $serie->setOverview('bla bla bla');
        $serie->setPopularity(1.5);
        $serie->setVote(4);
        $serie->setStatus('Report');
        $serie->setTmdbId(329432);

        // 1st step
        dump($serie);

        // 2nd Step
        $em->persist($serie);

        dump($serie);

        // 3rd Stp
        $em->flush(); // 2
//        dump('after flush', $serie);
//
//        // Test remove
//        $em->remove($serie);
//        $em->flush();
//
//        dump('after remove flush', $serie);

        dd('end test');
        return $this->render('serie/new.html.twig', [
            'title' => 'Add Serie',
        ]);
    }

    #[Route('/{id}', name: 'detail', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(int $id, EntityManagerInterface $em): Response
    {
        return $this->render('serie/show.html.twig', [
            'title' => 'Serie Detail',
            'serie' => $em->getRepository(Serie::class)->find($id),
        ]);
    }
}
