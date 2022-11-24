<?php

namespace Source\Model;

class Type extends Model
{

    protected static $entity = "tipos";

    public function __construct()
    {
        parent::__construct(self::$entity);
    }

    public function getType(int $id): ?Type
    {
        $load = $this->read("SELECT * FROM " . self::$entity . " WHERE id= :id", "id={$id}");

        if ($this->fail() || !$load->rowCount()) {
            $this->message = "transação não encontrada para o id informado";
            return null;
        }
        return $load->fetchObject(__CLASS__);
    }

}