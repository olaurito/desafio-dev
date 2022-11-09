<?php
require __DIR__ . '/config/init.php';
require __DIR__ . "/vendor/autoload.php";

$transaction = (new \Source\Model\Transaction())->all();
$count = 1;
$tipo = (new \Source\Model\Type());
//var_dump($transaction);
//var_dump($tipo->id, $transaction->data()->tipo);
?>
<div class="container">
    <p style="margin-bottom: 10px; text-align: left"><a href="./" title="Voltar" class="button">Voltar</a></p>
    <?php if ($transaction): ?>
        <?php foreach ($transaction as $info): ?>
            <div class="tag">
                <p>#<?= $count++ ?></p>

                <p><strong><?= ($info->tipo ==  $tipo->getType($info->tipo)->id ?  $tipo->getType($info->tipo)->descricao  : ''); ?></strong></p>
                <p>Data: <?= convert_data($info->dataocorrencia) ?> </p>
                <p>Valor: <?= str_price($info->valor) ?> </p>
                <p>CPF: <?= fmt_cpf($info->cpf) ?> </p>
                <p>Cartão: <?= $info->cartao ?> </p>
                <p>Hora: <?= convert_hora($info->hora) ?> </p>
                <p>Dono: <?= $info->dono ?> </p>
                <p>Loja: <?= $info->loja ?> </p>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
    <p>Não encontramos nenhuma transação</p>
    <?php endif; ?>

</div>
</div>
