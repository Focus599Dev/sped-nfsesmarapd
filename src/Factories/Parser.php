<?php

namespace NFePHP\NFSe\SMARAPD\Factories;

use NFePHP\NFSe\SMARAPD\Make;
use stdClass;
use NFePHP\Common\Strings;
use App\Http\Model\Uteis;

class Parser
{

    protected $structure;

    protected $make;

    protected $loteRps;

    protected $tomador;

    protected $std;

    public function __construct($version = '3.0.1')
    {

        $ver = str_replace('.', '', $version);

        $path = realpath(__DIR__ . "/../../storage/txtstructure$ver.json");

        $this->std = new \stdClass();

        $this->std->tomador = new \stdClass();

        $this->std->prestador = new \stdClass();

        $this->std->servico = array();

        $this->servicos = array();

        $this->structure = json_decode(file_get_contents($path), true);

        $this->version = $version;

        $this->make = new Make();
    }

    public function toXml($nota)
    {

        $std = $this->array2xml($nota);

        if ($this->make->getXML($this->std)) {

            echo $this->make->getXML($this->std);
            die;

            return $this->make->getXML($this->std);
        }

        return null;
    }

    protected function array2xml($nota)
    {

        $obj = [];

        foreach ($nota as $lin) {

            $fields = explode('|', $lin);

            $struct = $this->structure[strtoupper($fields[0])];

            $std = $this->fieldsToStd($fields, $struct);

            $obj = (object) array_merge((array) $obj, (array) $std);
        }

        return $obj;
    }

    protected function fieldsToStd($dfls, $struct)
    {

        $sfls = explode('|', $struct);

        $len = count($sfls) - 1;

        for ($i = 1; $i < $len; $i++) {

            $name = $sfls[$i];

            if (isset($dfls[$i]))
                $data = $dfls[$i];
            else
                $data = '';

            if (!empty($name)) {

                if ($dfls[0] == 'C') {

                    $this->std->prestador->$name = Strings::replaceSpecialsChars($data);
                } elseif ($dfls[0] == 'E' || $dfls[0] == 'E02') {

                    $this->std->tomador->$name = Strings::replaceSpecialsChars($data);
                } else {

                    $this->std->$name = Strings::replaceSpecialsChars($data);
                }
            }
        }

        if ($dfls[0] == 'N') {

            $this->servicos[] = $dfls;

            $this->std->servico = $this->servicos;
        }

        return $this->std;
    }
}
