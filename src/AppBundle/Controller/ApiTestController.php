<?php
/**
 * Controller for Default apitesting functions.
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
use AppBundle\Form\ApiTestFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Form\Form;


class ApiTestController extends Controller
{   
    /**
     * function to call the api from symfony form
     *
     * @Route("/api/testform", name="form")
     *
     * @param $request
     * @return array
     */
    public function indexAction (Request $request)
    {	
        $form = $this->createForm(ApiTestFormType::class);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $verb = $form["verb"]->getData();
            $url = $form["url"]->getData();
            $content = $form["content"]->getData();
            //setting $token for the header
            $token = hash_hmac('sha1', $content, 
                $this->container->getParameter('hash_signature_key'))
            ;
            //intializing the header
            $header = array(
                'Authorization: '.$token
            );
            //calling the api
            $response = $this->container
                ->get('app.service.api_caller')
                ->callingApi($url, $header, $verb, $content)
            ;

            return new Response($response['message']);
        }
        //
         $response = new Response(
          $this->renderView('default/test.html.twig',['form' => $form->createView()]),
          200
        );
        $response->headers->set('Content-Type', 'text/html');
        return $response;
    }
}