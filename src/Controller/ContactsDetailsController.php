<?php

namespace App\Controller;

use App\Entity\Contacts;
use App\Entity\Targets;
use App\Form\ContactType;
use App\Form\TargetType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactsDetailsController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    #[Route('/contacts/details/{id}', name: 'contacts_details')]
    public function index($id): Response
    {
        $contacts = $this->entityManager->getRepository(Contacts::class)->findOneBy(array('id' => $id));

        return $this->render('contacts_details/index.html.twig', [
            'contacts' => $contacts,
        ]);
    }

    #[Route('/contacts/new', name: 'contact_add', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $contact = new Contacts();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($contact);
            $this->entityManager->flush();
            $this->addFlash('success', "Le contact : ". $contact->getCodeName()." à bien été créé !");
            return $this->redirectToRoute('contacts');
        }

        return $this->render('contacts_details/new.html.twig', [
            'contact' => $contact,
            'form' => $form->createView(),
        ]);
    }
    #[Route('/contacts/editer/{id}', name: 'contact_modify', methods: ['GET', 'POST'])]
    public function edit(Request $request, Contacts $contact): Response
    {
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('success', "Le contact : ". $contact->getCodeName()." à bien été modifié !");
            return $this->redirectToRoute('contacts');
        };

        return $this->render('contacts_details/edit.html.twig', [
            'contact' => $contact,
            'form' => $form->createView()
        ]);
    }

    #[Route('/contacts/supprimer/{id}', name: 'contact_delete', methods: ['GET', 'DELETE'])]
    public function delete(Request $request, Contacts $contact): Response
    {
        if ($this->isCsrfTokenValid('delete' . $contact->getId(), $request->request->get('_token'))) {
            $this->entityManager->remove($contact);
            $this->entityManager->flush();
            $this->addFlash('success', "Le contact : ". $contact->getCodeName()." à bien été supprimé !");
        }

        return $this->redirectToRoute('contacts');
    }
}
