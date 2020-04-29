<?php

namespace NFePHP\NFSe\SMARAPD;

use NFePHP\Common\Strings;
use NFePHP\NFSe\SMARAPD\Exception\DocumentsException;
use NFePHP\NFSe\SMARAPD\Factories\Parser;

class Convert
{
    public function __construct($txt = '')
    {

        if (!empty($txt)) {

            $this->txt = trim($txt);
        }
    }

    public function toXml($txt = '')
    {

        if (!empty($txt)) {

            $this->txt = trim($txt);
        }

        $txt = Strings::removeSomeAlienCharsfromTxt($this->txt);

        if (!$this->isNFSe($txt)) {

            throw DocumentsException::wrongDocument(12, '');
        }

        $this->notas = $this->sliceNotas($this->dados);

        $this->checkQtdNFSe();

        $this->validNotas();

        $i = 0;

        foreach ($this->notas as $nota) {

            $version = $this->layouts[$i];

            $parser = new Parser($version);

            $this->xmls[] = $parser->toXml($nota);

            $i++;
        }

        return $this->xmls;
    }

    protected function isNFSe($txt)
    {

        if (empty($txt)) {

            throw DocumentsException::wrongDocument(15, '');
        }

        $this->dados = explode("\n", $txt);

        $fields = explode('|', $this->dados[0]);

        if ($fields[0] == 'NOTAFISCAL') {

            $this->numNFs = (int) $fields[1];

            return true;
        }

        return false;
    }

    protected function sliceNotas($array)
    {

        $aNotas = [];

        $annu = explode('|', $array[0]);

        $numnotas = $annu[1];

        unset($array[0]);

        if ($numnotas == 1) {

            $aNotas[] = $array;

            return $aNotas;
        }

        $iCount = 0;

        $xCount = 0;

        $resp = [];

        foreach ($array as $linha) {

            if (substr($linha, 0, 2) == 'A|') {

                $resp[$xCount]['init'] = $iCount;

                if ($xCount > 0) {

                    $resp[$xCount - 1]['fim'] = $iCount;
                }

                $xCount += 1;
            }

            $iCount += 1;
        }

        $resp[$xCount - 1]['fim'] = $iCount;

        foreach ($resp as $marc) {

            $length = $marc['fim'] - $marc['init'];

            $aNotas[] = array_slice($array, $marc['init'], $length, false);
        }

        return $aNotas;
    }

    protected function checkQtdNFSe()
    {

        $num = count($this->notas);

        if ($num != $this->numNFs) {

            throw DocumentsException::wrongDocument(13, '');
        }
    }

    protected function validNotas()
    {

        foreach ($this->notas as $nota) {

            $this->loadLayouts($nota);
        }
    }

    protected function loadLayouts($nota)
    {

        if (empty($nota)) {

            throw DocumentsException::wrongDocument(17, '');
        }

        foreach ($nota as $campo) {

            $fields = explode('|', $campo);

            if ($fields[0] == 'A') {

                $this->layouts[] = $fields[2];

                break;
            }
        }
    }
}
