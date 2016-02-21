<?php
use Cake\Core\Configure;
use Cake\Error\Debugger;

if (Configure::read('debug'))
{
    $this->layout = 'dev_error';

    $this->assign('title', $message);
    $this->assign('templateName', 'error400.ctp');

    $this->start('file');
    ?>

    <?php if (!empty($error->queryString)) : ?>
        <p class="notice">
            <strong>SQL Query: </strong>
            <?= h($error->queryString) ?>
        </p>
    <?php endif; ?>

    <?php if (!empty($error->params)) : ?>
        <strong>SQL Query Params: </strong>
        <?= Debugger::dump($error->params) ?>
    <?php endif; ?>

    <?= $this->element('auto_table_warning') ?>

    <?php
    if (extension_loaded('xdebug')):
        xdebug_print_function_stack();
    endif;

    $this->end();
}
?>

<div class="jumbotron">
    <h1><?= __d('cake', 'Error') ?></h1>
    <p class="lead">
        <?= sprintf(
            __d('cake', 'The requested address %s was not found on this server.'),
            "<strong>'{$url}'</strong>"
        ) ?>
    </p>
    <p><a class="btn btn-success" href="/" role="button">Back to Settings</a></p>
</div>
