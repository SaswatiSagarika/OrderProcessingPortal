<?php
/**
 * Controller for apitesting functions.
 *
 * @author Saswati
 *
 * @category Controller
 */
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\FormTypeInterface;
use AppBundle\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\User;
use Symfony\Component\Form\Form;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserController extends Controller
{   
    /**
     * function to call the api from symfony form
     *
     * @Route("/register", name="user_registration")
     *
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     *
     * @return $response
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        // 1) build the form
        $user = new User();
        $form = $this->createForm(UserType::class);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            // 4) save the User!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user

            return $this->redirectToRoute('replace_with_some_route');
        }

        return $this->render(
            'user/register.html.twig',
            ['form' => $form->createView()]
        );
    }
    public function indexAction (Request $request)
    {	
        $form = $this->createForm(UserType::class);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
        }
        $response = new Response(
          $this->renderView('user/register.html.twig',['form' => $form->createView()]),
          200
        );
        $response->headers->set('Content-Type', 'text/html');
        return $response;
    }
}