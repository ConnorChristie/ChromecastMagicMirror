<?= $this->Html->meta('icon') ?>

<!-- The block is where the element gets included, styles or scripts -->

<?= $this->Html->css('bootstrap-flatly.min', ['block' => true]) ?>
<?= $this->Html->css('style', ['block' => true]) ?>

<!-- Dependencies -->
<?= $this->Html->script('libs/jquery.min', ['block' => true]) ?>
<?= $this->Html->script('libs/bootstrap.min', ['block' => true]) ?>
<?= $this->Html->script('//www.gstatic.com/cv/js/sender/v1/cast_sender.js', ['block' => true]) ?>

<!-- Extensions -->
<?= $this->Html->script('chromecast', ['block' => true]) ?>
