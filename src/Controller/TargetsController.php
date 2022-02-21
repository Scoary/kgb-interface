<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\Agents;
use App\Entity\Targets;
use App\Form\SearchDataType;
use App\Repository\TargetsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TargetsController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    #[Route('/cibles', name: 'targets')]
    public function index(Request $request, TargetsRepository $repository): Response
    {
        $targets = $this->entityManager->getRepository(Targets::class)->findAll();

        $data = new SearchData();
        $data->page = $request->get('page', 1);
        $form = $this->createForm(SearchDataType::class, $data);
        $form->handleRequest($request);
        $targets = $repository->findSearch($data);
        return $this->render('targets/index.html.twig', [
            'targets' => $targets,
            'form' => $form->createView()
        ]);
    }
}
