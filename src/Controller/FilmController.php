<?php

namespace App\Controller;

use App\Entity\Film;
use App\Form\FilmType;
use App\Repository\FilmsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry; 
use Symfony\Component\HttpFoundation\JsonResponse;
#[Route('/film')]
class FilmController extends AbstractController
{
    #[Route('/', name: 'app_film_index', methods: ['GET'])]
    public function index(FilmsRepository $filmsRepository, PersistenceManagerRegistry $doctrine,Request $currentPage): Response
    {
		
		
		 $currentPage=$currentPage->query->get("thisPage");
		 if ($currentPage == ''){
		$currentPage = 1;
		}
		 $pageSize=3;
	     $limit = 5;
		 $films = $doctrine
        ->getRepository(Film::class)
        ->getAllPers($currentPage, $limit);
	
		$filmsResultado = $films['paginator'];
        $filmsQueryCompleta =  $films['query'];
        $maxPages = ceil($films['paginator']->count() / $limit);
		
		return $this->render('film/index.html.twig', array(
        'films' => $filmsResultado,
        'maxPages'=>$maxPages,
        'thisPage' => $currentPage
        
    ) );
		
        return $this->render('film/index.html.twig', [
            'films' => $filmsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/search", name="app_film_search", methods={"GET","POST"})
     */	
  public function search(Request $request,  PersistenceManagerRegistry $doctrine)
    {
   // $request = $this->getRequest();
	$request = $this->container->get('request_stack')->getCurrentRequest();
    $data = $request->request->get('search');

    //$em = $this->getDoctrine()->getManager();
	$em = $doctrine->getManager();
	$entityManager = $doctrine->getManager();
    $query = $em->createQuery('SELECT  a FROM App:Film a WHERE a.title LIKE :data')
                ->setParameter('data', '%'.$data.'%');

    $result = $query->getResult();

    return $this->render('film/index.html.twig', array('results' => $result));
}

    #[Route('/new', name: 'app_film_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,  PersistenceManagerRegistry $doctrine): Response
    {
		
		  $em = $doctrine->getManager();
	      $entityManager = $doctrine->getManager();
		  

	
        $film = new Film();
        $form = $this->createForm(FilmType::class, $film);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($film);
            $entityManager->flush();

            return $this->redirectToRoute('app_film_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('film/new.html.twig', [
            'film' => $film,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_film_show', methods: ['GET'])]
    public function show(Film $film): Response
    {
        return $this->render('film/show.html.twig', [
            'film' => $film,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_film_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Film $film, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FilmType::class, $film);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_film_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('film/edit.html.twig', [
            'film' => $film,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_film_delete', methods: ['POST'])]
    public function delete(Request $request, Film $film, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$film->getId(), $request->request->get('_token'))) {
            $entityManager->remove($film);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_film_index', [], Response::HTTP_SEE_OTHER);
    }
}
