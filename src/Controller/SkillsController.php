<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\Skills;
use App\Form\SearchDataType;
use App\Form\SkillType;
use App\Repository\SkillsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SkillsController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    #[Route('/competences', name: 'skills')]
    public function index(Request $request, SkillsRepository $repository): Response
    {
        $skills = $this->entityManager->getRepository(Skills::class)->findAll();
        $data = new SearchData();
        $data->page = $request->get('page', 1);
        $form = $this->createForm(SearchDataType::class, $data);
        $form->handleRequest($request);
        $skills = $repository->findSearch($data);
        return $this->render('skills/index.html.twig', [
            'skills' => $skills,
            'form' => $form->createView()
        ]);
    }

    #[Route('/competences/new', name: 'skill_add', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $skill = new Skills();
        $form = $this->createForm(SkillType::class, $skill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($skill);
            $this->entityManager->flush();
            $this->addFlash('success', "La compétence : ". $skill->getSkill()." à bien été créée !");

            return $this->redirectToRoute('skills');
        }

        return $this->render('skills/new.html.twig', [
            'skill' => $skill,
            'form' => $form->createView(),
        ]);
    }
    #[Route('/competences/editer/{id}', name: 'skill_modify', methods: ['GET', 'POST'])]
    public function edit(Request $request, Skills $skill): Response
    {
        $form = $this->createForm(SkillType::class, $skill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('success', "La compétence : ". $skill->getSkill()." à bien été modifiée !");
            return $this->redirectToRoute('skills');
        };

        return $this->render('skills/edit.html.twig', [
            'skill' => $skill,
            'form' => $form->createView()
        ]);
    }
    #[Route('/competences/supprimer/{id}', name: 'skill_delete', methods: ['GET', 'DELETE'])]
    public function delete(Request $request, Skills $skill): Response
    {
        if ($this->isCsrfTokenValid('delete' . $skill->getId(), $request->request->get('_token'))) {
            $this->entityManager->remove($skill);
            $this->entityManager->flush();
            $this->addFlash('success', "La compétence : ". $skill->getSkill()." à bien été supprimée !");
        }

        return $this->redirectToRoute('skills');
    }
}
