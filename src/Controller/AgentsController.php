<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\Agents;
use App\Form\SearchDataType;
use App\Repository\AgentsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AgentsController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    #[Route('/agents', name: 'agents')]
    public function index(Request $request, AgentsRepository $repository): Response
    {
        $agents = $this->entityManager->getRepository(Agents::class)->findAll();

        $data = new SearchData();
        $data->page = $request->get('page', 1);
        $form = $this->createForm(SearchDataType::class, $data);
        $form->handleRequest($request);
        $agents = $repository->findSearch($data);
        return $this->render('agents/index.html.twig', [
            'agents' => $agents,
            'form' => $form->createView()
        ]);
    }
}
