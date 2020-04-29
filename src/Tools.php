<?php

namespace NFePHP\NFSe\SMARAPD;

use NFePHP\NFSe\SMARAPD\Common\Tools as ToolsBase;
use NFePHP\Common\Strings;
use NFePHP\NFSe\SMARAPD\Make;

class Tools extends ToolsBase
{
    public function enviaRPS($xml)
    {

        if (empty($xml)) {
            throw new InvalidArgumentException('$xml');
        }

        $xml = Strings::clearXmlString($xml);

        $servico = 'GerarNfseRequest';

        $this->lastRequest = htmlspecialchars_decode($xml);

        $request = $this->envelopXML($xml, $servico);

        $request = $this->envelopSoapXML($request);

        $response = $this->sendRequest($request, $this->soapUrl);
        var_dump($response);
        $response = $this->removeStuffs($response);
        var_dump('ae');
        return $response;
    }

    public function CancelaNfse($std)
    {
        $make = new Make();

        $xml = $make->cancelarNota($std);

        $xml = Strings::clearXmlString($xml);

        $servico = 'CancelarNota';

        $request = $this->envelopXML($xml, $servico);

        $request = $this->envelopSoapXML($request);

        $response = $this->sendRequest($request, $this->soapUrl);

        $response = strip_tags($response);

        $response = htmlspecialchars_decode($response);

        return $response;
    }

    public function consultaSituacaoLoteRPS($std)
    {

        $make = new Make();

        $xml = $make->consultarNota($std);

        $xml = Strings::clearXmlString($xml);

        $servico = 'ConsultarNotaPrestador';

        $request = $this->envelopXML($xml, $servico);

        $request = $this->envelopSoapXML($request);

        $this->lastResponse = $this->sendRequest($request, $this->soapUrl);

        $this->lastResponse = htmlspecialchars_decode($this->lastResponse);

        $this->lastResponse = substr($this->lastResponse, strpos($this->lastResponse, '<Mensagem>') + 10);

        $this->lastResponse = substr($this->lastResponse, 0, strpos($this->lastResponse, '</Mensagem>'));

        $auxResp = simplexml_load_string($this->lastResponse);

        return $auxResp;
    }
}
