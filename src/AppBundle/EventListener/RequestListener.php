<?php
/**
 * RequestListener 
 *
 * @author Saswati
 *
 * @category EventListener
 */
namespace AppBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use AppBundle\EventListener\TranslatorInterface;
use AppBundle\Service\AuthenticateApiService;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class RequestListener
{   
    /**
     * @var $authservice
     */
    private $authservice;
    
    /**
     * @var $translator
     */
    private $translator;
    
    /**
     * @param AuthenticateApiService $authservice
     * @param TranslatorInterface $translator
     *
     * @return void
     */
    public function __construct(AuthenticateApiService $authservice, TranslatorInterface $translator) {
        $this->authservice = $authservice;
        $this->translator = $translator;
    }

    /**
     * @param GetResponseEvent $event
     *
     * @return void
     */
    public function onKernelRequest(GetResponseEvent $event)
    {    
        
        $request = $event->getRequest();
        if ('/api/testform' === $request->getPathInfo()) {
            return true;
        }
        $response = $this->authservice->authenticateRequest($request);
        
        if(true !== $response['status']){
            
            $responseData['error'] = $this->translator->trans($response['errorMessage']['message']);
            $event->setResponse(new JsonResponse($responseData));
        }
        return; 
    }
}