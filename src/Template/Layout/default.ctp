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
        <?= $this->fetch('css') ?>
    </head>
    <body>
        <?= $this->element('header') ?>

        <div class="container">
            <div class="flash">
                <?= $this->Flash->render() ?>
            </div>

            <?= $this->fetch('content') ?>

            <?= $this->element('footer') ?>
        </div>

        <?= $this->fetch('script') ?>
        <?= $this->Html->script('main') ?>
    </body>
</html>
