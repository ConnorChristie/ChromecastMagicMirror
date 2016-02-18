<?= $this->Html->meta('icon') ?>

<!-- The block is where the element gets included, styles or scripts -->

<?= $this->Html->css('bootstrap-flatly.min.css', ['block' => 'styles']) ?>
<?= $this->Html->css('style.css', ['block' => 'styles']) ?>

<?= $this->Html->script('jquery.min.js', ['block' => 'scripts']) ?>
<?= $this->Html->script('bootstrap.min.js', ['block' => 'scripts']) ?>
<?= $this->Html->script('main.js', ['block' => 'scripts']) ?>
