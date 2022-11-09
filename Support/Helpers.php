<?php

function convert_data(string $data)
{
    return date("d/m/Y", strtotime($data));
}

function convert_hora(string $hora)
{
    return date("H:m:s", strtotime($hora));
}

function str_price(string $price): string
{
    return number_format($price, 2, ",", ".");
}

function fmt_cpf(string $cpf, int $lenght = 11 )
{
    if(strlen($cpf) === $lenght){
        return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cpf);
    }
    return '';
}