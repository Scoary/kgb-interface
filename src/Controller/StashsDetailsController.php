<?php

namespace App\Controller;

use App\Entity\Stashs;
use App\Entity\Targets;
use App\Form\StashType;
use App\Form\TargetType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StashsDetailsController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    #[Route('/planques/details/{id}', name: 'stashs_details')]
    public function index($id): Response
    {
        $stashs = $this->entityManager->getRepository(Stashs::class)->findOneBy(array('id' => $id));

        return $this->render('stashs_details/index.html.twig', [
            'stashs' => $stashs,
        ]);
    }

    #[Route('/planques/new', name: 'stash_add', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $stash = new Stashs();
        $form = $this->createForm(StashType::class, $stash);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($stash);
            $this->addFlash('success', "La planque : ". $stash->getAlias()." à bien été ajoutée !");
            $this->entityManager->flush();

            return $this->redirectToRoute('stashs');
        }

        return $this->render('stashs_details/new.html.twig', [
            'stash' => $stash,
            'form' => $form->createView(),
        ]);
    }
    #[Route('/planques/editer/{id}', name: 'stash_modify', methods: ['GET', 'POST'])]
    public function edit(Request $request, Stashs $stash): Response
    {
        $form = $this->createForm(StashType::class, $stash);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('success', "La planque : ". $stash->getAlias()." à bien été modifiée !");
            return $this->redirectToRoute('stashs');
        };

        return $this->render('stashs_details/edit.html.twig', [
            'stash' => $stash,
            'form' => $form->createView()
        ]);
    }
    #[Route('/planques/supprimer/{id}', name: 'stash_delete', methods: ['GET', 'DELETE'])]
    public function delete(Request $request, Stashs $stash): Response
    {
        if ($this->isCsrfTokenValid('delete' . $stash->getId(), $request->request->get('_token'))) {
            $this->entityManager->remove($stash);
            $this->entityManager->flush();
            $this->addFlash('success', "La planque : ". $stash->getAlias()." à bien été supprimée !");
        }

        return $this->redirectToRoute('stashs');
    }
}
