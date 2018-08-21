<?php
/* Smarty version 3.1.32, created on 2018-08-15 02:04:58
  from '/var/www/html/notify-me/src/View/Frontend/templates/User/index.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5b73b47a0649f2_83933112',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '93a247ab1e8c1cd6fe737caa8400b7c93093799e' => 
    array (
      0 => '/var/www/html/notify-me/src/View/Frontend/templates/User/index.tpl',
      1 => 1533787562,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5b73b47a0649f2_83933112 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Notify-me</title>
</head>
<body>
    
    <?php echo $_smarty_tpl->tpl_vars['User']->value->getLogin();?>


    <br>

    <?php echo $_smarty_tpl->tpl_vars['Language']->value->getMessage('mandatory-accountTypeId');?>


</body>
</html><?php }
}
