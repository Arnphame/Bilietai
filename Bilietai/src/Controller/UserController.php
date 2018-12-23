<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{
    /**
     * @Route("/register", name="register")
     */
    public function Register(Request $request, UserPasswordEncoderInterface $passwordEncoder, AuthorizationCheckerInterface $authorizationChecker)
    {
        if($authorizationChecker->isGranted('ROLE_USER')){
            return $this->redirectToRoute('main');
        }
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $user->setRole(1);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('registration_success');
        }
        return $this->render(
            'register.html.twig',
            array('form' => $form->createView())
        );
    }
    /**
     * @Route("/login", name="login")
     */
    public function Login(Request $request, AuthenticationUtils $authenticationUtils, AuthorizationCheckerInterface $authorizationChecker)
    {
        if($authorizationChecker->isGranted('ROLE_USER')){
            return $this->redirectToRoute('main');
        }

        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(
            'login.html.twig',
            array('last_username' => $lastUsername,
                'error' => $error,
            ));
    }
    /**
     * @Route("/success", name="registration_success")
     */
    public function Success()
    {
        return $this->render(
            'success.html.twig'
            );
    }
}
