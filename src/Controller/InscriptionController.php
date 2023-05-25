<?php

namespace App\Controller;

use App\Entity\Role;
use App\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormFactoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\Extension\Core\Type\{TextType,ButtonType,EmailType,HiddenType,PasswordType,TextareaType,SubmitType,NumberType,DateType,MoneyType,BirthdayType};

class InscriptionController extends AbstractController
{
    /**
    * @Route("/inscription")
    * Method({"GET", "POST"})
    */
    public function inscription(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        // Fetch roles from the database
        $roles = $entityManager->getRepository(Role::class)->findAll();

        if ($request->isMethod('POST')) {
            // Retrieve form data
            $nom = $request->request->get('nom');
            $email = $request->request->get('email');
            $role = $entityManager->getRepository(Role::class)->find($request->request->get('role'));

            // Create a new Utilisateur entity
            $utilisateur = new Utilisateur();
            $utilisateur->setNom($nom);
            $utilisateur->setEmail($email);
            $utilisateur->setRole($role);

            // Persist the entity
            $entityManager->persist($utilisateur);
            $entityManager->flush();

            // Redirect to a success page or perform any other desired actions
            return $this->redirectToRoute('inscription_success');
        }

        return $this->render('inscription.twig', [
            'roles' => $roles,
        ]);
    }

    #[Route('/inscription/success', name: 'inscription_success')]
    public function inscriptionSuccess(): Response
    {
        return $this->render('inscription_success.twig');
    }
}
