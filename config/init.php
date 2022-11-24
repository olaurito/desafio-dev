<?php
/**
 * Teste CNAB
 * @author Olaurito Neto <https://www.linkeding.com.br/in/olauritonetto>
 *
 * Document content and charset
 */
header("Content-Type: text/html; charset=utf-8");


/**
 * [ PHP Basic Config ] Configurações basicas do sistema
 * Configura o timezone da aplicação
 * Define a função para output de erros.
 */
date_default_timezone_set("America/Sao_Paulo");

/**
 * [ php config ] Altera modo de erro e exibição do var_dump.
 * display_errors: Erros devem ser exibidos.
 * error_reporting: Todos os tipos de erros
 * overload_var_dump: Omitir a linha de caminho do var_dump.
 */
ini_set("display_errors", 1);
ini_set("error_reporting", E_ALL);
ini_set('xdebug.overload_var_dump', 1);

/**
 * [ interface ] Style, icon and logo
 */
echo "<link rel='stylesheet' href='config/style.css'/>";


/**
 * [ Title Function ] Cria o título do arquivo para o browser
 */
function cnabPHPClassName($className)
{
    echo "<title>{$className} | CNAB</title>";
}

