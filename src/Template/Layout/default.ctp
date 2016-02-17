<!DOCTYPE html>
<html>
    <head>
        <?= $this->Html->charset() ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>
            <?= __('{0} Magic Mirror', ['']) . ' - ' . $this->fetch('title') ?>
        </title>

        <?= $this->element('includes') ?>

        <?= $this->fetch('meta') ?>
        <?= $this->fetch('styles') ?>
    </head>
    <body>
        <?= $this->element('header') ?>

        <div class="container">
            <?= $this->Flash->render() ?>

            <?= $this->fetch('content') ?>

            <?= $this->element('footer') ?>
        </div>

        <?= $this->fetch('scripts') ?>
    </body>
</html>
