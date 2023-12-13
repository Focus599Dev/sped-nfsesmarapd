<?php

namespace NFePHP\NFSe\SMARAPD\Factories;

use NFePHP\NFSe\SMARAPD\Make;
use NFePHP\Common\Strings;

class Parser
{

    public function __construct($version = '3.0.1')
    {

        $ver = str_replace('.', '', $version);

        $path = realpath(__DIR__ . "/../../storage/txtstructure.json");

        $this->Servico = new \stdClass();

        $this->structure = json_decode(file_get_contents($path), true);

        $this->version = $version;

        $this->make = new Make();
    }

    public function toXml($nota)
    {

        $this->array2xml($nota);

        if ($this->make->monta()) {

            return $this->make->getXML();
        }

        return null;
    }

    protected function array2xml($nota)
    {

        foreach ($nota as $lin) {

            $fields = explode('|', $lin);

            if (empty($fields)) {
                continue;
            }

            $metodo = strtolower(str_replace(' ', '', $fields[0])) . 'Entity';

            if (method_exists(__CLASS__, $metodo)) {

                $struct = $this->structure[strtoupper($fields[0])];

                $std = $this->fieldsToStd($fields, $struct);

                $this->$metodo($std);
            }
        }
    }

    protected function fieldsToStd($dfls, $struct)
    {

        $sfls = explode('|', $struct);

        $len = count($sfls) - 1;

        $std = new \stdClass();

        for ($i = 1; $i < $len; $i++) {

            $name = $sfls[$i];

            if (isset($dfls[$i]))
                $data = $dfls[$i];
            else
                $data = '';

            if (!empty($name)) {

                $std->$name = Strings::replaceSpecialsChars($data);
            }
        }

        return $std;
    }

    private function aEntity($std)
    {
    }

    private function bEntity($std)
    {
        $cnpj = new \stdClass();

        $cnpj = (object) array_merge((array) $cnpj, (array) $std);

        $this->make->buildCpfCnpjPrestador($cnpj);

        $InscricaoMunicipal = new \stdClass();

        $InscricaoMunicipal = (object) array_merge((array) $InscricaoMunicipal, (array) $std);

        $this->make->buildPrestador($InscricaoMunicipal);
    }

    private function cEntity($std)
    {
    }

    private function eEntity($std)
    {
        $RazaoSocial = new \stdClass();

        $RazaoSocial = (object) array_merge((array) $RazaoSocial, (array) $std);

        $this->make->buildTomadorServico($RazaoSocial);

        $Endereco = new \stdClass();

        $Endereco = (object) array_merge((array) $Endereco, (array) $std);

        $this->make->buildEndereco($Endereco);

        $Contato = new \stdClass();

        $Contato = (object) array_merge((array) $Contato, (array) $std);

        $this->make->buildContato($Contato);
    }

    private function e02Entity($std)
    {
        $cnpj = new \stdClass();

        $cnpj = (object) array_merge((array) $cnpj, (array) $std);

        $this->make->buildCpfCnpjTomador($cnpj);

        $InscricaoMunicipal = new \stdClass();

        $InscricaoMunicipal = (object) array_merge((array) $InscricaoMunicipal, (array) $std);

        $this->make->buildIdentificacaoTomador($InscricaoMunicipal);
    }

    private function h01Entity($std)
    {
        $IdentificacaoRps = new \stdClass();

        $IdentificacaoRps = (object) array_merge((array) $IdentificacaoRps, (array) $std);

        $this->make->buildIdentificacaoRps($IdentificacaoRps);
    }

    private function mEntity($std)
    {
        $Valores = new \stdClass();

        $Valores = (object) array_merge((array) $Valores, (array) $std);

        $this->make->buildValores($Valores);

        $this->Servico = (object) array_merge((array) $this->Servico, (array) $std);
    }

    private function nEntity($std)
    {
     
        $this->Servico = (object) array_merge((array) $this->Servico, (array) $std);

        $this->make->buildServico($this->Servico);
    }

    private function wEntity($std)
    {
        $Rps = new \stdClass();

        $Rps = (object) array_merge((array) $Rps, (array) $std);

        $this->make->buildRps($Rps);

        $InfDeclaracaoPrestacaoServico = new \stdClass();

        $InfDeclaracaoPrestacaoServico = (object) array_merge((array) $InfDeclaracaoPrestacaoServico, (array) $std);

        preg_match_all('!\d+!', $std->DataEmissao, $matches);

        $InfDeclaracaoPrestacaoServico->dataEmissao = $matches[0][0] . $matches[0][1] . $matches[0][2];

        $this->make->buildInfDeclaracaoPrestacaoServico($InfDeclaracaoPrestacaoServico);
    }
}
