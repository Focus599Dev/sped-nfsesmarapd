<?php

namespace NFePHP\NFSe\SMARAPD;

use NFePHP\Common\DOMImproved as Dom;
use NFePHP\Common\Strings;
use stdClass;
use RuntimeException;
use DOMElement;
use DateTime;

class Make
{

    public $dom;

    public $xml;

    public $versaoNFSE = '1.00';

    public function __construct()
    {

        $this->dom = new Dom();

        $this->dom->preserveWhiteSpace = false;

        $this->dom->formatOutput = false;
    }

    public function getXML($std)
    {

        if (empty($this->xml)) {

            $this->gerarNota($std);
        }

        return $this->xml;
    }

    public function gerarNota($std)
    {

        $root = $this->dom->createElement('nfseCabecMsg');
        $this->dom->appendChild($root);

        $this->dom->addChild(
            $root,                          // pai
            "Versão",                       // nome
            $this->versaoNFSE,              // valor
            true,                           // se é obrigatorio
            "Versão do leiaute."            // descrição se der catch
        );

        $this->dom->addChild(
            $root,
            "versaoDados",
            $std->Versao,
            true,
            "Esse campo indica a versão do leiaute XML da estrutura XML informada na área de dados da mensagem."
        );


        $this->xml = $this->dom->saveXML();

        return $this->xml;
    }

    public function cancelarNota($std)
    {
    }

    public function consultarNota($std)
    {
    }
}
