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
use AppBundle\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\User;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\Form\LoginFormType;


class UserController extends Controller
{   
    /**
     * function to shoe to registration form
     *
     * @Route("/register", name="user_registration")
     *
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     *
     * @return $response
     */
    public function registerAction(Request $request)
    {
        // 1) build the form
        $form = $this->createForm(UserType::class);
        $customer = $this->getDoctrine()->getRepository('AppBundle:Customer')->getCustomerDetail();
        
        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //initalizing form data
           $param['password'] = hash_hmac('sha1',$form['password']->getData(), 
                $this->container->getParameter('hash_signature_key'))
            ;
            $param['email'] = $form['email']->getData();
            $param['name'] = $form['name']->getData();
            $param['last'] = $form['last']->getData();
            //calling registr api     
            $response = $this->container
                ->get('app.service.registration')
                ->registerUserResponse($param)
            ;
            if(true === $response['status']){
                $session = new Session();
                $session->set('authenticated', true);
            }
            return $this->redirect($this->generateUrl('homepage'));
            // return $this->render(
            //     'user/otp.html.twig',
            //     ['user' => $param,
            //      'response' => $response
            // ]);
        }

        return $this->render(
            'user/register.html.twig',
            ['form' => $form->createView(),
            'customer' => $customer]
        );
    }

    /**
     * function to call the api from symfony form
     *
     * @Route("/login", name="user_login")
     *
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     *
     * @return $response
     */
    public function loginAction(Request $request)
    {
        // 1) build the form
        $form = $this->createForm(LoginFormType::class);
        
        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $param['email'] = $form['email']->getData();
             $param['password'] = hash_hmac('sha1',$form['password']->getData(), 
                $this->container->getParameter('hash_signature_key'))
            ;
            
            // $response = $this->forward('AppBundle\Controller\AuthController::loginAction', [
            //     'param'  =>  $param,
            // ]);
            $response = $this->container
                ->get('app.service.registration')
                ->loginResponse($param)
            ;
            if(true === $response['status']){
                $session = new Session();
                $session->set('authenticated', true);
            }
            return $this->redirect($this->generateUrl('homepage'));
        }

        return $this->render(
            'user/login.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * function to logout
     *
     * @Route("/logout", name="user_logout")
     *
     * @param Request $request
     *
     * @return $response
     */
    public function logoutAction(Request $request)
    {
        $session = new Session();
        $session->set('authenticated', false);
        $session->clear();
        return $this->redirect($this->generateUrl('user_login'));
    }
    
}