<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\Contacts;
use App\Entity\Targets;
use App\Form\SearchDataType;
use App\Repository\ContactsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactsController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    #[Route('/contacts', name: 'contacts')]
    public function index(ContactsRepository $repository, Request $request ): Response
    {
        $contacts = $this->entityManager->getRepository(Contacts::class)->findAll();
        $data = new SearchData();
        $data->page = $request->get('page', 1);
        $form = $this->createForm(SearchDataType::class, $data);
        $form->handleRequest($request);
        $contacts = $repository->findSearch($data);
        return $this->render('contacts/index.html.twig', [
            'contacts' => $contacts,
            'form' => $form->createView()
        ]);
    }
}
