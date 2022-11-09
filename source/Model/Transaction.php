<?php

namespace Source\Model;

/**
 *
 */
class Transaction extends Model
{

    /** campos protegidos que não podem ser manipulados na base  */
    protected static $safe = ["id"];

    /**
     * @var string
     */
    protected static $entity = "transacoes";

    public function __construct()
    {
        parent::__construct(self::$entity);
    }

    /**
     * @param array $conteudo
     * @return $this
     */
    public function boostrap(array $conteudo)
    {
        $this->tipo = $conteudo['tipo'];
        $this->dataocorrencia = $conteudo['data'];
        $this->valor = $conteudo['valor'];
        $this->cpf = $conteudo['cpf'];
        $this->cartao = $conteudo['cartao'];
        $this->hora = $conteudo['hora'];
        $this->dono = $conteudo['dono'];
        $this->loja = $conteudo['loja'];
        return $this;
    }

    /**
     * @param int $id
     * @param string $columns
     * @return Transaction|null
     */
    public function load(int $id, string $columns = "*"): ?Transaction
    {
        $load = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE id= :id", "id={$id}");
        if ($this->fail() || !$load->rowCount()) {
            $this->message = "transação não encontrada para o id informado";
            return null;
        }
        return $load->fetchObject(__CLASS__);
    }

    /**
     * @param int $limit
     * @param int $offset
     * @param string $columns
     * @return array|null
     */
    public function all(int $limit = 30, int $offset = 0, string $columns = "*"): ?array
    {
        $all = $this->read("SELECT {$columns} FROM " . self::$entity . " LIMIT :l OFFSET :o", "l={$limit}&o={$offset}");
        if ($this->fail() || !$all->rowCount()) {
            $this->message = "Sua consulta não retornou transação";
            return null;
        }
        return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }


    public function findType(int $type): ?Type
    {
        return (new Type())->getType($type);
    }


    public function save()
    {

        $transactionId = $this->create(self::$entity, $this->safe());

        if ($this->fail()) {
            $this->message = "Erro ao cadastrar, verifique os dados";
        }
        $this->message = "Cadastro efetuado com sucesso";
        $this->data = $this->read("SELECT * FROM " . self::$entity . " WHERE id = :id", "id={$transactionId}");
        return $this;
    }


}