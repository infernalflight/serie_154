<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Form\SerieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/serie', name: 'serie_')]
final class SerieController extends AbstractController
{
    #[Route('/', name: 'list', methods: ['GET'])]
    public function index(EntityManagerInterface $em): Response
    {
        $serieRepo = $em->getRepository(Serie::class);
        $series = $serieRepo->findAll();
//        $serie = $serieRepo->find(5);

        // TODO Pensez à regarder les requête SQL générée histoire d'optimiser si nécessaire
//        $serie = $serieRepo->findBy(['name' => 'pif']);
//        $series = $serieRepository->findBy([], ['popularity' => 'DESC', 'vote' => 'DESC'], 30);

        // Get DQL Method From Repository
        //$series = $serieRepo->getOnlyBestSeriesDQL();

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

    #[Route('/add', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $serie = new Serie();
        $serieForm = $this->createForm(SerieType::class, $serie);

        // Traiter le form
        $serieForm->handleRequest($request);

        // Test
        if($serieForm->isSubmitted() && $serieForm->isValid()) {

            if ($serieForm->get('poster_file')->getData() instanceOf UploadedFile) {
                $posterFile = $serieForm->get('poster_file')->getData();
                $name = $slugger->slug($serie->getName()) . '-' . uniqid() . '.' . $posterFile->guessExtension();
                $posterFile->move('uploads/posters/series', $name);
                
                $serie->setPoster($name);
            }

            $em->persist($serie);
            $em->flush();
            // Add Success Notif
            $this->addFlash('success', 'Serie has been created.');
            // Redir
            return $this->redirectToRoute('serie_detail', ['id' => $serie->getId()]);
        }

        return $this->render('serie/new.html.twig', [
            'title' => 'Add Serie',
            'serieForm' => $serieForm,
        ]);
    }

    #[Route('/update/{id}', name: 'update', requirements: ['id' => '\d+'])]
    public function update(Serie $serie, Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $serieForm = $this->createForm(SerieType::class, $serie);

        // Traiter le form
        $serieForm->handleRequest($request);

        // Test
        if($serieForm->isSubmitted() && $serieForm->isValid()) {

            if ($serieForm->get('poster_file')->getData() instanceOf UploadedFile) {
                $posterFile = $serieForm->get('poster_file')->getData();
                $name = $slugger->slug($serie->getName()) . '-' . uniqid() . '.' . $posterFile->guessExtension();
                $posterFile->move('uploads/posters/series', $name);

                if ($serie->getPoster() && file_exists('uploads/posters/series/' . $serie->getPoster())) {
                    unlink('uploads/posters/series/' . $serie->getPoster());
                }


                $serie->setPoster($name);
            }


            $em->flush();
            // Add Success Notif
            $this->addFlash('success', 'Serie has been updated.');
            // Redir
            return $this->redirectToRoute('serie_detail', ['id' => $serie->getId()]);
        }

        return $this->render('serie/new.html.twig', [
            'title' => 'Update Serie',
            'serieForm' => $serieForm,
        ]);
    }


    #[Route('/{id}', name: 'detail', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(Serie $serie): Response
    {
        return $this->render('serie/show.html.twig', [
            'title' => 'Serie Detail',
            'serie' => $serie
        ]);
    }
}
