<?php

/**
 * Description of AuthenticateApiService. This service is used for authenticating the api request
 *
 * @author Saswati
 * 
 * @category Service
 */
namespace AppBundle\Service;

use Doctrine\Bundle\DoctrineBundle\Registry;

class MailerService
{
    /**
     *  @var Registry
     */
    private $doctrine;

    /**
     *  @var string
     */
    private $emailTo;

     /**
     *  @var string
     */
    private $mailer;
    
    /**
     *  Constructor Function for iniatialize dependencies.
     *  
     *  @param string $mailer
     *   
     *  @return void
     */
    public function __construct(Registry $doctrine, $emailTo, $mailer)
    {
        $this->doctrine = $doctrine;
        $this->emailTo = $emailTo;
        $this->mailer = $mailer;
    
    }
    
    /**
     * Function to check content and Api header
     *
     * @param array $request
     *
     * @return true
     **/
    public function mailToVendor($params)
    {
        try {
           
            foreach ($params as $param) {
                $Qty = $param['SalesItemLineDetail']['Qty'];
                $itemRef = $this->doctrine->getRepository('AppBundle:Product')->getVendorDetail($param['SalesItemLineDetail']['ItemRef']['value']);

                $this->sendMail($itemRef, $Qty);
            }
                         
       } catch (\Exception $e) {
            $returnData['errorMessage'] = $e->getMessage();
        }
        
        return $returnData;
    }

    /**
     * Function to send the mail
     *
     * @param array $request
     *
     * @return true
     **/
    public function sendMailToVendor($toEmail, $Qty)
    {
        try {
             $body = 'Hi  '.$toEmail[0]['vendor'].', <br/> '
             .$toEmail[0]['email'].' <br/> <br/>There is a order for <b>'.$toEmail[0]['name'].'</b> Item. 
        Can you please send a confirmation mail whether your company can provide '.$Qty.' number of <b>'.$toEmail[0]['name'].' to us</b>.<br/><br/>Thanks, <br/>Quickbooks Corp.';
       
            $message = \Swift_Message::newInstance() 
                      ->setSubject('Conform availablity of items') 
                      ->setFrom($this->emailTo) 
                      ->setTo('saswati.sagarika@mindfiresolutions.com') 
                      ->setBody($body, 'text/html');
                      
            $this->mailer->send($message); 

       } catch (\Exception $e) {
            $returnData['errorMessage'] = $e->getMessage();
        }
        
        return $returnData;
    }

    /**
     * Function to send the mail
     *
     * @param array $request
     *
     * @return true
     **/
    public function sendOtpToEmail($param)
    {
        try {
            $returnData['status'] = false;
             $body = 'Hi  '.$param['name'].', <br/> <br/> <br/></b>Your one-time password to verify your account is ' . $param['otp'].'.<br/><br/>Thanks, <br/>Quickbooks Corp.';
       
            $message = \Swift_Message::newInstance() 
                      ->setSubject('Verification of account') 
                      ->setFrom($this->emailTo) 
                      ->setTo('saswati.sagarika@mindfiresolutions.com') 
                      ->setBody($body, 'text/html');
                      
            $this->mailer->send($message); 
            $returnData['status'] = true;
       } catch (\Exception $e) {
            $returnData['errorMessage'] = $e->getMessage();

        }
        return $returnData;
    }


}