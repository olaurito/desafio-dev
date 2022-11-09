<?php
require __DIR__ . '/config/init.php';
require __DIR__ . "/vendor/autoload.php";

use Source\Model\Upload;
use Source\Model\Transaction;



if (isset($_FILES['file'])) {

    $obUpload = new Upload($_FILES['file']);

    $obUpload->generateNewName();

    /** @var  $folder */
    $folder = __DIR__ . "/uploads";
    if (!file_exists($folder) || !is_dir($folder)) {
        mkdir($folder, 0755);
    }

    $getPost = filter_input(INPUT_GET, "post", FILTER_VALIDATE_BOOLEAN);

    $success = $obUpload->upload($folder, false);

    if ($success) {
        echo "Arquivo <strong>" . $obUpload->getBasename() . "</strong> enviado com sucesso!";
        header('Location: /cnab/list');
        exit;
    }
    die("Problemas em enviar o arquivo!");
}

include __DIR__ . "/form.php";






