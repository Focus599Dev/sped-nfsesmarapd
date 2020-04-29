<?php

namespace NFePHP\NFSe\SMARAPD\Exception;

class DocumentsException extends \InvalidArgumentException
{

    public static $list = [
        0 => "",
        12 => "O TXT não representa uma NFSe",
        13 => "O numero de notas indicado na primeira linha do TXT é diferente do numero total de notas do txt.",
        16 => "O txt tem um campo não definido {{msg}}",
        17 => "O txt não está no formato adequado.",
    ];

    public static function wrongDocument($code, $msg = '')
    {

        $msg = self::replaceMsg(self::$list[$code], $msg);

        return new static($msg);
    }

    private static function replaceMsg($input, $msg)
    {

        return str_replace('{{msg}}', $msg, $input);
    }
}
