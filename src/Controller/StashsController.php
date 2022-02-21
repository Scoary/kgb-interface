<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\Stashs;
use App\Form\SearchDataType;
use App\Repository\StashsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StashsController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    #[Route('/planques', name: 'stashs')]
    public function index(Request $request, StashsRepository $repository): Response
    {
        $stashs = $this->entityManager->getRepository(Stashs::class)->findAll();
        $data = new SearchData();
        $data->page = $request->get('page', 1);
        $form = $this->createForm(SearchDataType::class, $data);
        $form->handleRequest($request);
        $stashs = $repository->findSearch($data);
        return $this->render('stashs/index.html.twig', [
            'stashs' => $stashs,
            'form' => $form->createView()
        ]);
    }
}
