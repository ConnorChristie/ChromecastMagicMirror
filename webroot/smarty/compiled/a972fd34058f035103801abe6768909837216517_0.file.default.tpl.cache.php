<?php
/* Smarty version 3.1.29, created on 2016-02-14 21:38:04
  from "E:\Users\Connor\WebsiteProjects\ChromecastMagicMirror\src\Template\Layout\default.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_56c0f3bc085988_01359384',
  'file_dependency' => 
  array (
    'a972fd34058f035103801abe6768909837216517' => 
    array (
      0 => 'E:\\Users\\Connor\\WebsiteProjects\\ChromecastMagicMirror\\src\\Template\\Layout\\default.tpl',
      1 => 1455485882,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_56c0f3bc085988_01359384 ($_smarty_tpl) {
$_smarty_tpl->compiled->nocache_hash = '2996456c0f3bbf30f37_53635706';
?>
<!DOCTYPE html>
<html>
    <head>
        <?php echo $_smarty_tpl->tpl_vars['this']->value->Html->charset();?>

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>
            Magic Mirror - <?php echo $_smarty_tpl->tpl_vars['this']->value->fetch('title');?>

        </title>
        <?php echo $_smarty_tpl->tpl_vars['this']->value->Html->meta('icon');?>


        <?php echo $_smarty_tpl->tpl_vars['this']->value->Html->css('base.css');?>

        <?php echo $_smarty_tpl->tpl_vars['this']->value->Html->css('cake.css');?>


        <?php echo $_smarty_tpl->tpl_vars['this']->value->fetch('meta');?>

        <?php echo $_smarty_tpl->tpl_vars['this']->value->fetch('css');?>

        <?php echo $_smarty_tpl->tpl_vars['this']->value->fetch('script');?>

    </head>
    <body>
        <nav class="top-bar expanded" data-topbar role="navigation">
            <ul class="title-area large-3 medium-4 columns">
                <li class="name">
                    <h1><a href=""><?php echo $_smarty_tpl->tpl_vars['this']->value->fetch('title');?>
</a></h1>
                </li>
            </ul>
            <section class="top-bar-section">
                <ul class="right">
                    <li><a target="_blank" href="http://book.cakephp.org/3.0/">Documentation</a></li>
                    <li><a target="_blank" href="http://api.cakephp.org/3.0/">API</a></li>
                </ul>
            </section>
        </nav>

        <?php echo $_smarty_tpl->tpl_vars['this']->value->Flash->render();?>


        <section class="container clearfix">
            <?php echo $_smarty_tpl->tpl_vars['this']->value->fetch('content');?>

        </section>
    </body>
</html><?php }
}
