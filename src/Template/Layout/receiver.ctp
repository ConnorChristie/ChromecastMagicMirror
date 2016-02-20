<!DOCTYPE html>
<html>
    <head>
        <?= $this->Html->charset() ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>
            <?= __('{0} Magic Mirror', ['']) . ' - ' . $this->fetch('title') ?>
        </title>

        <?= $this->element('Receiver/includes') ?>

        <?= $this->fetch('meta') ?>
        <?= $this->fetch('css') ?>
    </head>
    <body>
        <?= $this->fetch('content') ?>

        <?= $this->fetch('script') ?>

        <?= $this->Html->script('receiver/chromecast') ?>
        <?= $this->fetch('script-after') ?>
        <?= $this->Html->script('receiver/main') ?>
    </body>
</html>
