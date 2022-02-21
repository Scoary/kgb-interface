<?php

namespace App\Controller;

use App\Entity\Agents;
use App\Entity\Missions;
use App\Entity\Skills;
use App\Entity\Targets;
use App\Form\AgentType;
use App\Form\TargetType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TargetsDetailsController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }


    #[Route('/cibles/details/{id}', name: 'targets_details')]
    public function index($id): Response
    {
        $targets = $this->entityManager->getRepository(Targets::class)->findOneBy(array('id' => $id));

        return $this->render('targets_details/index.html.twig', [
            'targets' => $targets,
        ]);
    }

    #[Route('/cibles/new', name: 'target_add', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $target = new Targets();
        $form = $this->createForm(TargetType::class, $target);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($target);
            $this->entityManager->flush();
            $this->addFlash('success', "La cible : ". $target->getAlias()." à bien été créée !");
            return $this->redirectToRoute('targets');
        }

        return $this->render('targets_details/new.html.twig', [
            'target' => $target,
            'form' => $form->createView(),
        ]);
    }
    #[Route('/cibles/editer/{id}', name: 'target_modify', methods: ['GET', 'POST'])]
    public function edit(Request $request, Targets $target): Response
    {
        $form = $this->createForm(TargetType::class, $target);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('success', "La cible : ". $target->getAlias()." à bien été modifiée !");
            return $this->redirectToRoute('targets');
        };

        return $this->render('targets_details/edit.html.twig', [
            'target' => $target,
            'form' => $form->createView()
        ]);
    }
    #[Route('/cibles/supprimer/{id}', name: 'target_delete', methods: ['GET', 'DELETE'])]
    public function delete(Request $request, Targets $target): Response
    {
        if ($this->isCsrfTokenValid('delete' . $target->getId(), $request->request->get('_token'))) {
            $this->entityManager->remove($target);
            $this->entityManager->flush();
            $this->addFlash('success', "La cible : ". $target->getAlias()." à bien été supprimée !");
        }

        return $this->redirectToRoute('targets');
    }
}
