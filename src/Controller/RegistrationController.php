<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\LoginFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class RegistrationController extends AbstractController
{   
    private $authenticationUtils;

    public function __construct(AuthenticationUtils $authenticationUtils)
    {
        $this->authenticationUtils = $authenticationUtils;
    }

    #[Route('/registration', name: 'app_registration')]
    public function index(): Response
    {
        return $this->render('registration/index.html.twig', [
            'controller_name' => 'RegistrationController',
        ]);
    }
    public function login(Request $request): Response
    {
        $form = $this->createForm(LoginFormType::class);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
    
    
            return $this->redirectToRoute('home');  
        }
    
        // Get the last authentication error (if any)
        $error = $this->authenticationUtils->getLastAuthenticationError();
    
        // Get the last username entered by the user
        $lastUsername = $this->authenticationUtils->getLastUsername();
    
        return $this->render('registration/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
            'loginForm'     => $form->createView(), 
        ]);
    }
    
    #[Route('/logout', name: 'app_logout')]
    public function logout(): void
    {
        
    }

}

