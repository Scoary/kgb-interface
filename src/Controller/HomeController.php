<?php

namespace App\Controller;

use App\Entity\Missions;
use App\Form\SearchMissionType;
use App\Repository\MissionsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'home')]
    public function index(Request $request, MissionsRepository $missionsRepository): Response
    {
        $missions = $this->entityManager->getRepository(Missions::class)->findAll();

        $form = $this->createForm(SearchMissionType::class);
        $search = $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $missions = $missionsRepository->search($search->get('search')->getData());
        }

        return $this->render('home/index.html.twig', [
            'missions' => $missions,
            'form' => $form->createView()
        ]);
    }
}
