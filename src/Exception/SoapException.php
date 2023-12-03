<?php

namespace NFePHP\NFSe\SMARAPD\Exception;

class SoapException extends \RuntimeException implements ExceptionInterface
{

    public static function unableToLoadCurl($message)
    {

        return new static('Unable to load cURL, '
            . 'verify if libcurl is installed. ' . $message);
    }

    public static function soapFault($message)
    {

        return new static(
            'An error occurred while trying to communication via soap, '
                . $message
        );
    }
}
