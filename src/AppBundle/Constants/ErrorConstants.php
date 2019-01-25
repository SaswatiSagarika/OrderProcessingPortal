<?php

/**
 * File for Error code,severity and error message management.
 * @author Saswati
 *
 * @category Constants
 */
namespace AppBundle\Constants;

/**
 *  Class containing the error details with error code, severity and corresponding error message.
 */
final class ErrorConstants
{
    /**
     * @var array
     */
    public static $apiErrors = array(
    	'INVALIDJSON' => array('code' => 11, 'message' => 'api.invalid_json'),
    	'INVALIDCONTENTTYPE' => array('code' => 12, 'message' => 'api.invalid_content_type'),
    	'INVALIDAUTHORIZATION' => array('code' => 13, 'message' => 'api.invalid_authorization')
    );

}