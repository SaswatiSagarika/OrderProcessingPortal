<?php

/**
 * Service for products Section. This service used for verifying the product details and process and provide product response for the searched data provided.
 *
 * @author Saswati
 * 
 * @category Service
 */
namespace AppBundle\Service;

use Doctrine\Bundle\DoctrineBundle\Registry;
use AppBundle\Entity\User;

class RegistrationService
{

    /**
     * @var Registry
     */
    protected $doctrine;
    
    /**
     * @var mailer
     */
    private $mailer;

    /**
     * @param Registry $doctrine
     *
     * @return void
     */
    
    public function __construct(Registry $doctrine, $mailer)
    {
        $this->doctrine = $doctrine;
        $this->mailer = $mailer;
    }  
    
    /**
     * Private function to generate and sms the otp
     *
     * @param array $param
     *
     * @return array
     */
    public function registerUserResponse($param)
    {
        try {
            $returnData['status'] = false;

            $em = $this->doctrine->getEntityManager();
            $active = $em->getRepository('AppBundle:Status')->findOneBy(array(
                    'name' => 'ACTIVE'
                ));

            $param['otp'] = rand(100000,999999);

            //create new user in db
            $user = new User();
            $user->setName($param['name'])
                 ->setEmail($param['email'])
                 ->setLast($param['last'])
                 ->setIsVerified(1)
                 ->setPassword($param['password'])
                 ->setOtp($param['otp'])
                 ->setRole('user')
                 ->setStatus($active)
                 ->setEmployeeID(time());

            $em->persist($user);
            $em->flush();
            $sendMail = $this->mailer->sendOtpToEmail($param);
            if (false === $sendMail['status']) {
                $returnData['message'] = $sendMail['errorMessage'];
                return $returnData;
            }
            $returnData['status'] = true;
            
            
        } catch (\Exception $e) {
            $returnData['errorMessage'] = $e->getMessage();            
        }
        return $returnData;
    }

    /**
     * Private function to login
     *
     * @param array $param
     *
     * @return array
     */
    public function loginResponse($param)
    {
        try {
            $returnData['status'] = false;
            $login       = $this->doctrine->getRepository('AppBundle:User')->loginDetails($param);
            if (!$login) {
                $returnData['message'] = 'missing_login';
                return $returnData;
            }
            $returnData['status'] = true;
                        
        } catch (\Exception $e) {
            $returnData['errorMessage'] = $e->getMessage();            
        }
        return $returnData;
    }
}