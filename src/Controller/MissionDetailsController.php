<?php

namespace App\Controller;

use App\Entity\Missions;
use App\Form\MissionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MissionDetailsController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    #[Route('/mission/detail/{id}', name: 'mission_details')]
    public function index($id): Response
    {
        $missions = $this->entityManager->getRepository(Missions::class)->findOneBy(array('id' => $id));

        return $this->render('mission_details/index.html.twig', [
            'missions' => $missions,
        ]);
    }

    #[Route('/missions/new', name: 'mission_add', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $mission = new Missions();
        $form = $this->createForm(MissionType::class, $mission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$mission->missionIsValid()) {
                $this->addFlash('error', "Votre nouvelle mission n'a pas pu être ajoutée car elle contient des erreurs. Veuillez vérifier les éléments suivants : Compétence(s) du ou des agents / Nationalité des agents ou contacts / Pays de la planque.");
                return $this->redirectToRoute('home');
            }else{
                $this->addFlash('success', "Nouvelle mission créée !");
            };
            $this->entityManager->persist($mission);
            $this->entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('mission_details/new.html.twig', [
            'mission' => $mission,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/missions/editer/{id}', name: 'mission_modify', methods: ['GET', 'POST'])]
    public function edit(Request $request, Missions $mission): Response
    {
        $form = $this->createForm(MissionType::class, $mission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$mission->missionIsValid()) {
                $this->addFlash('error', "Votre mission n'a pas pu être modifiée car elle contient des erreurs. Veuillez vérifier les éléments suivants : Compétence(s) du ou des agents / Nationalité des agents ou contacts / Pays de la planque.");
                return $this->redirectToRoute('home');
            } else{
                $this->addFlash('success', "La mission : ". $mission->getTitle()." à bien été modifiée !");
            }
            $this->entityManager->flush();
            return $this->redirectToRoute('home');
        };

        return $this->render('mission_details/edit.html.twig', [
            'missions' => $mission,
            'form' => $form->createView()
        ]);
    }

    #[Route('/missions/supprimer/{id}', name: 'mission_delete', methods: ['GET', 'DELETE'])]
    public function delete(Request $request, Missions $mission): Response
    {
        if ($this->isCsrfTokenValid('delete' . $mission->getId(), $request->request->get('_token'))) {
            $this->entityManager->remove($mission);
            $this->entityManager->flush();
            $this->addFlash('success', "La mission : ". $mission->getTitle()." à bien été supprimée !");
        }

        return $this->redirectToRoute('home');
    }
}
