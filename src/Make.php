<?php

namespace NFePHP\NFSe\SMARAPD;

use NFePHP\Common\DOMImproved as Dom;

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

        $this->InfDeclaracaoPrestacaoServico = $this->dom->createElement('InfDeclaracaoPrestacaoServico');

        $this->Rps = $this->dom->createElement('Rps');

        $this->IdentificacaoRps = $this->dom->createElement('IdentificacaoRps');

        $this->Servico = $this->dom->createElement('Servico');

        $this->Valores = $this->dom->createElement('Valores');

        $this->Prestador  = $this->dom->createElement('Prestador');

        $this->CpfCnpjPrestador = $this->dom->createElement('CpfCnpj');

        $this->CpfCnpjTomador = $this->dom->createElement('CpfCnpj');

        $this->TomadorServico = $this->dom->createElement('TomadorServico');

        $this->IdentificacaoTomador = $this->dom->createElement('IdentificacaoTomador');

        $this->Endereco = $this->dom->createElement('Endereco');

        $this->Contato = $this->dom->createElement('Contato');
    }

    public function getXML()
    {

        if (empty($this->xml)) {

            $this->monta();
        }

        return $this->xml;
    }

    public function monta()
    {
        $this->dom->appendChild($this->InfDeclaracaoPrestacaoServico);

        $this->InfDeclaracaoPrestacaoServico->appendChild($this->Rps);

        $items = $this->dom->getElementsByTagName('InfDeclaracaoPrestacaoServico');

        $firstItem = $items->item(0);

        $firstItem->insertBefore($this->TomadorServico, $firstItem->firstChild);

        $firstItem->insertBefore($this->Prestador, $firstItem->firstChild);

        $firstItem->insertBefore($this->Servico, $firstItem->firstChild);

        $comptc = $this->InfDeclaracaoPrestacaoServico->getElementsByTagName('Competencia');

        $comptc = $comptc->item(0);

        $firstItem->insertBefore($comptc, $firstItem->firstChild);

        $firstItem->insertBefore($this->Rps, $firstItem->firstChild);

        $items = $this->InfDeclaracaoPrestacaoServico->getElementsByTagName('Rps');

        $firstItem = $items->item(0);

        $firstItem->insertBefore($this->IdentificacaoRps, $firstItem->firstChild);

        $items = $this->InfDeclaracaoPrestacaoServico->getElementsByTagName('Servico');

        $firstItem = $items->item(0);

        $firstItem->insertBefore($this->Valores, $firstItem->firstChild);

        $items = $this->InfDeclaracaoPrestacaoServico->getElementsByTagName('Prestador');

        $firstItem = $items->item(0);

        $firstItem->insertBefore($this->CpfCnpjPrestador, $firstItem->firstChild);

        $items = $this->InfDeclaracaoPrestacaoServico->getElementsByTagName('TomadorServico');

        $firstItem = $items->item(0);

        $firstItem->insertBefore($this->IdentificacaoTomador, $firstItem->firstChild);

        $items = $this->InfDeclaracaoPrestacaoServico->getElementsByTagName('IdentificacaoTomador');

        $firstItem = $items->item(0);

        $firstItem->insertBefore($this->CpfCnpjTomador, $firstItem->firstChild);

        $this->TomadorServico->appendChild($this->Endereco);

        $this->TomadorServico->appendChild($this->Contato);

        $this->xml = $this->dom->saveXML();

        return $this->xml;
    }

    public function buildIdentificacaoRps($std)
    {
        $this->dom->addChild(
            $this->IdentificacaoRps,
            "Numero",
            $std->Numero,
            true,
            "Número do RPS"
        );

        $this->dom->addChild(
            $this->IdentificacaoRps,
            "Serie",
            $std->Serie,
            true,
            "Série do RPS"
        );

        $this->dom->addChild(
            $this->IdentificacaoRps,
            "Tipo",
            $std->Tipo,
            true,
            "Tipo do RPS"
        );
    }

    public function buildRps($std)
    {
        $this->dom->addChild(
            $this->Rps,
            "DataEmissao",
            $std->DataEmissao,
            true,
            "Data de emissão do RPS"
        );

        $this->dom->addChild(
            $this->Rps,
            "Status",
            $std->Status,
            true,
            "Situação do RPS"
        );
    }

    public function buildValores($std)
    {

        $this->dom->addChild(
            $this->Valores,
            "ValorServicos",
            $std->ValorServicos,
            true,
            "Valor do serviço"
        );

        $this->dom->addChild(
            $this->Valores,
            "ValorDeducoes",
            $std->ValorDeducoes,
            true,
            "Valor total das deduções"
        );

        $this->dom->addChild(
            $this->Valores,
            "ValorPis",
            $std->ValorPis,
            true,
            "Valor do PIS"
        );

        $this->dom->addChild(
            $this->Valores,
            "ValorCofins",
            $std->ValorCofins,
            true,
            "Valor do CONFINS"
        );

        $this->dom->addChild(
            $this->Valores,
            "ValorInss",
            $std->ValorInss,
            true,
            "Valor do INSS"
        );

        $this->dom->addChild(
            $this->Valores,
            "ValorIr",
            $std->ValorIr,
            true,
            "Valor do imposto de renda"
        );

        $this->dom->addChild(
            $this->Valores,
            "ValorCsll",
            $std->ValorCsll,
            true,
            "Valor do CSLL"
        );

        $this->dom->addChild(
            $this->Valores,
            "OutrasRetencoes",
            $std->ValorOutrasRetencoes,
            true,
            "Valor total de outras retenções"
        );

        $this->dom->addChild(
            $this->Valores,
            "ValorIss",
            $std->ValorIss,
            true,
            "Valor do ISS quando informado pelo prestador"
        );

        $this->dom->addChild(
            $this->Valores,
            "Aliquota",
            $std->Aliquota,
            true,
            "Alíquota do ISS quando informado pelo prestador"
        );

        $this->dom->addChild(
            $this->Valores,
            "DescontoIncondicionado",
            $std->DescontoIncondicionado,
            true,
            "Valor do desconto condicionado"
        );

        $this->dom->addChild(
            $this->Valores,
            "DescontoCondicionado",
            $std->DescontoCondicionado,
            true,
            "Valor do desconto incondicionado"
        );
    }

    public function buildServico($std)
    {

        $this->dom->addChild(
            $this->Servico,
            "IssRetido",
            $std->IssRetido,
            true,
            "ISS retido (S/N)"
        );

        $this->dom->addChild(
            $this->Servico,
            "ItemListaServico",
            $std->ItemListaServico,
            true,
            "Subitem do serviço prestado"
        );

        $this->dom->addChild(
            $this->Servico,
            "CodigoCnae",
            $std->CodigoCnae,
            true,
            "Código CNAE"
        );

        $this->dom->addChild(
            $this->Servico,
            "CodigoTributacaoMunicipio",
            $std->CodigoTributacaoMunicipio,
            true,
            "Código de tributação do município"
        );

        $this->dom->addChild(
            $this->Servico,
            "Discriminacao",
            $std->Discriminacao,
            true,
            "Discriminação do serviço"
        );

        $this->dom->addChild(
            $this->Servico,
            "CodigoMunicipio",
            $std->CodigoMunicipio,
            true,
            "Código do município da prestação do serviço"
        );

        $this->dom->addChild(
            $this->Servico,
            "ExigibilidadeISS",
            $std->CodigoMunicipio,
            true,
            "Exigibilidade do ISS"
        );
    }

    public function buildCpfCnpjPrestador($std)
    {

        $this->dom->addChild(
            $this->CpfCnpjPrestador,
            "Cnpj",
            $std->Cnpj,
            true,
            "Número do Cnpj"
        );
    }

    public function buildCpfCnpjTomador($std)
    {

        $this->dom->addChild(
            $this->CpfCnpjTomador,
            "Cnpj",
            $std->Cnpj,
            true,
            "Número do Cnpj"
        );
    }

    public function buildPrestador($std)
    {

        $this->dom->addChild(
            $this->Prestador,
            "InscricaoMunicipal",
            $std->Cnpj,
            true,
            "Inscrição Municipal da empresa/pessoa"
        );
    }

    public function buildIdentificacaoTomador($std)
    {

        $this->dom->addChild(
            $this->IdentificacaoTomador,
            "InscricaoMunicipal",
            $std->InscricaoMunicipal,
            true,
            "Inscrição Municipal da empresa/pessoa"
        );
    }

    public function buildTomadorServico($std)
    {

        $this->dom->addChild(
            $this->TomadorServico,
            "RazaoSocial",
            $std->RazaoSocial,
            true,
            "Razão Social do tomador do serviço"
        );
    }

    public function buildEndereco($std)
    {

        $this->dom->addChild(
            $this->Endereco,
            "Endereco",
            $std->Endereco,
            true,
            "Tipo e nome do logradouro"
        );

        $this->dom->addChild(
            $this->Endereco,
            "Numero",
            $std->Numero,
            true,
            "Número do imóvel"
        );

        $this->dom->addChild(
            $this->Endereco,
            "Complemento",
            $std->Complemento,
            true,
            "Complemento do Endereço"
        );

        $this->dom->addChild(
            $this->Endereco,
            "Bairro",
            $std->Bairro,
            true,
            "Nome do bairro"
        );

        $this->dom->addChild(
            $this->Endereco,
            "CodigoMunicipio",
            $std->CodigoMunicipio,
            true,
            "Código da cidade"
        );

        $this->dom->addChild(
            $this->Endereco,
            "Uf",
            $std->Uf,
            true,
            "Sigla do estado"
        );

        $this->dom->addChild(
            $this->Endereco,
            "Cep",
            $std->Cep,
            true,
            "CEP da localidade"
        );
    }

    public function buildContato($std)
    {

        $this->dom->addChild(
            $this->Contato,
            "Telefone",
            $std->Telefone,
            true,
            "Número do telefone"
        );

        $this->dom->addChild(
            $this->Contato,
            "Email",
            $std->Email,
            true,
            "Endereço eletrônico (email)"
        );
    }

    public function buildInfDeclaracaoPrestacaoServico($std)
    {

        $this->dom->addChild(
            $this->InfDeclaracaoPrestacaoServico,
            "Competencia",
            $std->dataEmissao,
            true,
            "Dia, mês e ano da prestação de serviço (AAAAMMDD)"
        );

        $this->dom->addChild(
            $this->InfDeclaracaoPrestacaoServico,
            "RegimeEspecialTributacao",
            $std->RegimeEspecialTributacao,
            true,
            "Identificação do regime especial de tributação"
        );

        $this->dom->addChild(
            $this->InfDeclaracaoPrestacaoServico,
            "OptanteSimplesNacional",
            $std->OptanteSimplesNacional,
            true,
            "Informação se optante pelo Simples Nacional (S/N)"
        );

        $this->dom->addChild(
            $this->InfDeclaracaoPrestacaoServico,
            "IncentivoFiscal",
            $std->RegimeEspecialTributacao,
            true,
            "Informação se o prestador é incentivador fiscal"
        );
    }

    public function cancelarNota($std)
    {
    }

    public function consultarNota($std)
    {
    }
}
