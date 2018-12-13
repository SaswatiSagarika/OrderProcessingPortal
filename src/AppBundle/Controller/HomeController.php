<?php
/**
 * Controller for home product ui functions.
 *
 * @author Saswati
 *
 * @category Controller
 */
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{
    /**
     * @Route("/home", name="homepage")
     */
    public function indexAction()
    {
		$images = [
            'bag.jpeg', 
			'chair.jpeg', 
			'dress.jpeg', 
			'hood.jpeg', 
			'hook.jpeg', 
			'marron.jpeg', 
			'red.jpeg', 
			'shirt.jpeg'
        ];
        
        return $this->render('page/index.html.twig', [
            'images' => $images,
        ]);
    }
}
