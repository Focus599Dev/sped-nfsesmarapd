<?php

namespace NFePHP\NFSe\SMARAPD\Soap;

class Soap
{
    public function loadCertificate(Certificate $certificate = null)
    {
        $this->isCertificateExpired($certificate);
        if (null !== $certificate) {
            $this->certificate = $certificate;
        }
    }

    public function sendByMiddleWhere($url, $operation, $action, $soapver, $parameters, $namespaces, $request, $soapheader){

        $urlDestination = 'http://3.227.39.59/efit-2.0/public/WsMiddleWhere';

        $data = array();

        $data['url'] = $url;

        $data['operation'] = $operation;

        $data['action'] = $action;
        
        $data['soapver'] = $soapver;

        $data['parameters'] = $parameters;

        $data['namespaces'] = $namespaces;

        $data['request'] = $request;

        $data['soapheader'] = $soapheader;

        $data['cnpj'] = $this->certificate->getCnpj();

        $oCurl = curl_init();

        curl_setopt($oCurl, CURLOPT_URL, $urlDestination);

        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($oCurl, CURLOPT_POST, 1);

        curl_setopt($oCurl, CURLOPT_POSTFIELDS, json_encode( $data ) );

        $response = curl_exec($oCurl);

        if ($response == ''){

           throw SoapException::soapFault('Erro unable load From Curl: ' . " $url ");

        }

        return $response;
    }

    public function send($xml, $soapUrl,$certificate)
    {

        $headers = array(
            "Content-type: text/xml;charset=\"utf-8\"",
            "Accept: text/xml",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "SOAPAction: ;",
            "Content-length: " . strlen($xml),
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        // curl_setopt($ch, CURLOPT_IPRESOLVE, CURLOPT_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_SSLVERSION, 4);
        curl_setopt($ch, CURLOPT_URL, $soapUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_SSLCERT, $certificate);
        // curl_setopt($oCurl, CURLOPT_SSLKEY, $this->tempdir . $this->prifile);
        curl_setopt($ch, CURLOPT_TIMEOUT, 40);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        $response = curl_exec($ch);
        var_dump($xml);
        curl_close($ch);

        return $response;
    }
}
