<?php
use Cake\Core\Configure;
use Cake\Error\Debugger;

$this->layout = 'default';

if (Configure::read('debug')):
    $this->layout = 'dev_error';

    $this->assign('title', $message);
    $this->assign('templateName', 'error500.ctp');

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
<?php if ($error instanceof Error) : ?>
        <strong>Error in: </strong>
        <?= sprintf('%s, line %s', str_replace(ROOT, 'ROOT', $error->getFile()), $error->getLine()) ?>
<?php endif; ?>
<?php
    echo $this->element('auto_table_warning');

    if (extension_loaded('xdebug')):
        xdebug_print_function_stack();
    endif;

    $this->end();
endif;
?>

<div class="jumbotron">
    <h1><?= __d('cake', 'Error') ?></h1>
    <p class="lead">
        <?= str_replace('\n', '<br>', $message) ?>
    </p>
    <p><a class="btn btn-success" href="/" role="button">Back to Settings</a></p>
</div>

