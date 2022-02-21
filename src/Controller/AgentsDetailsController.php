<?php

namespace App\Controller;

use App\Entity\Agents;
use App\Entity\Missions;
use App\Entity\Skills;
use App\Form\AgentType;
use App\Form\MissionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AgentsDetailsController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }
    #[Route('/agents/details/{id}', name: 'agents_details')]
    public function index($id): Response
    {
        $agents = $this->entityManager->getRepository(Agents::class)->findOneBy(array('id' => $id));
        return $this->render('agents_details/index.html.twig', [
            'agents' => $agents,
        ]);
    }

    #[Route('/agents/new', name: 'agent_add', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $agent = new Agents();
        $form = $this->createForm(AgentType::class, $agent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($agent);
            $this->entityManager->flush();
            $this->addFlash('success', "L'agent : ". $agent->getAlias()." à bien été créé !");
            return $this->redirectToRoute('agents');
        }

        return $this->render('agents_details/new.html.twig', [
            'agent' => $agent,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/agents/editer/{id}', name: 'agent_modify', methods: ['GET', 'POST'])]
    public function edit(Request $request, Agents $agent): Response
    {
        $form = $this->createForm(AgentType::class, $agent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('success', "L'agent : ". $agent->getAlias()." à bien été modifiée !");
            return $this->redirectToRoute('agents');
        };

        return $this->render('agents_details/edit.html.twig', [
            'agent' => $agent,
            'form' => $form->createView()
        ]);
    }
    #[Route('/agents/supprimer/{id}', name: 'agent_delete', methods: ['GET', 'DELETE'])]
    public function delete(Request $request, Agents $agents): Response
    {
        if ($this->isCsrfTokenValid('delete' . $agents->getId(), $request->request->get('_token'))) {
            $this->entityManager->remove($agents);
            $this->entityManager->flush();
            $this->addFlash('success', "L'agent : ". $agents->getAlias()." à bien été supprimé !");
        }

        return $this->redirectToRoute('agents');
    }
}
