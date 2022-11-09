<?php

namespace Source\Model;

/**
 * CLASSE UPLOAD
 */
class Upload
{
    /** @var string */
    private $name;

    /** @var string */
    private $extension;

    /** @var string */
    private $type;

    /** @var string */
    private $tmpName;

    /** @var integer */
    private $erro;

    /** @var integer */
    private $size;

    /** @var integer */
    private $duplicates;


    /**
     * Constritor da classe
     * @param array $file $_FILES[campo]
     */
    public function __construct($file)
    {
        $this->type = $file['type'];
        $this->tmpName = $file['tmp_name'];
        $this->erro = $file['error'];
        $this->size = $file['size'];

        $info = pathinfo($file['name']);
        $this->name = $info['filename'];
        $this->extension = $info['extension'];

    }

    /**
     * GERAR UM NOME ALEATORIO
     * @return void
     */
    public function generateNewName()
    {
        $this->name = time() . '-' . rand(10000, 9999) . '-' . uniqid();
    }

    /**
     * @return string
     */
    public function getBasename(): string
    {
        $extension = strlen($this->extension) ? '.' . $this->extension : '';

        /** VALIDA DUPLICAÇÃO     */
        $duplicates = $this->duplicates > 0 ? '-' . $this->duplicates : '';
        return $this->name . $duplicates . $extension;
    }

    /**
     * @param $dir
     * @param $overwrite
     * @return string
     */
    public function getPossibleBasename($dir, $overwrite): string
    {
        if ($overwrite) return $this->getBasename();

        $basename = $this->getBasename();
        if (file_exists($dir . '/' . $basename)) {
            return $basename;
        }
        /**  incrementar duplicação   */
        $this->duplicates++;

        return $this->getBasename($dir, $overwrite); //metódo recursivo
    }

    /**
     * @param $dir
     * @param $overwrite
     * @return bool
     */
    public function upload($dir, $overwrite = true): bool
    {
        if ($this->erro != 0) return false;

        /** Validação do arquivo txt e importação p/ o diretório */
        if ($_FILES && !empty($_FILES['file']['name'])) {
            /*  var_dump($_FILES); */
            $fileUpload = $_FILES['file'];

            $alllowebType = [
                "text/plain"
            ];

            $path = $dir . "/" . $this->getPossibleBasename($dir, $overwrite);


            /*  echo "<pre>";
              print_r($path);
              echo "</pre>";*/


            if (in_array($fileUpload['type'], $alllowebType)) {
                $this->read($fileUpload['tmp_name']);
                return move_uploaded_file($fileUpload['tmp_name'], $path);

            }
        }
        return false;
    }


    /**
     * @param $file
     * @return void
     */
    public function read($file)
    {
        if (file_exists($file) && is_file($file)) {

            echo "<p>Existe!</p>";
            $fileOpen = fopen($file, 'r');

            while (!feof($fileOpen)) {
                $leitura = fgets($fileOpen);

                $conteudo = [
                    "tipo" => mb_substr($leitura, 0, 1),
                    "data" => mb_substr($leitura, 1, 8),
                    "valor" => mb_substr($leitura, 9, 10),
                    "cpf" => mb_substr($leitura, 19, 11),
                    "cartao" => mb_substr($leitura, 30, 12),
                    "hora" => mb_substr($leitura, 42, 6),
                    "dono" => mb_substr($leitura, 48, 14),
                    "loja" => mb_substr($leitura, 62, 19),
                ];

                $model = new Transaction();
                $transaction = $model->boostrap(
                    $conteudo
                );

                $transaction->save();
            }

        } else {
            echo "<p>Não existe!</p>";
        }
    }
}