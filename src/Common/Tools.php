<?php

namespace NFePHP\NFSe\SMARAPD\Common;

use NFePHP\Common\Certificate;
use NFePHP\NFSe\SMARAPD\Soap\Soap;
use NFePHP\Common\Validator;

class Tools
{

    public $soapUrl;

    public $config;

    public $soap;

    public $pathSchemas;

    protected $algorithm = OPENSSL_ALGO_SHA1;

    protected $canonical = [false, false, null, null];

    protected $versao = '2.0.4';

    protected $availableVersions = [
        '2.0.4' => 'SMARAPD204'
    ];


    public function __construct($configJson, Certificate $certificate)
    {
        

        
        $this->pathSchemas = realpath(
            __DIR__ . '/../../schemas'
        ) . '/'. $this->availableVersions[$this->versao] . '/'; 

        $this->certificate = $certificate;

        $this->config = json_decode($configJson);

        if ($this->config->tpAmb == '1') {

            $this->soapUrl = 'http://201.48.3.165:9083/tbw/services/nfseSOAP?wsdl';
        } else {

            $this->soapUrl = 'http://201.48.3.165:9083/tbhomolog/services/nfseSOAP?wsdl';
        }
    }

    protected function sendRequest($request, $soapUrl,$certificate)
    {

        $soap = new Soap;

        $response = $soap->send($request, $soapUrl, $certificate);

        return (string) $response;
    }

    public function envelopXMLEnvio($xml)
    {

        $xml = trim(preg_replace("/<\?xml.*?\?>/", "", $xml));

        $this->xml =
            '<GerarNfseEnvio xmlns="http://www.abrasf.org.br/nfse.xsd">
                <Rps xmlns="http://www.abrasf.org.br/nfse.xsd">'
            . $xml .
            '</Rps>
            </GerarNfseEnvio>';

        return $this->xml;
    }

    public function removeStuffs($xml)
    {

        if (preg_match('/<SOAP-ENV:Body>/', $xml)) {

            $tag = '<SOAP-ENV:Body>';
            $xml = substr($xml, (strpos($xml, $tag) + strlen($tag)), strlen($xml));

            $tag = '</SOAP-ENV:Body>';
            $xml = substr($xml, 0, strpos($xml, $tag));
        }

        $xml = trim($xml);

        return $xml;
    }

    public function getLastRequest()
    {
        return $this->lastRequest;
    }

    protected function isValid($version, $body, $method){

        $schema = $this->pathSchemas.$method."_v$version.xsd";
        var_dump($schema);
        if (!is_file($schema)) {
            return true;
        }

        return Validator::isValid(
            $body,
            $schema
        );

    }
}
