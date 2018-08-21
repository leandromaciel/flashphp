<?php
/* Smarty version 3.1.32, created on 2018-08-09 01:06:04
  from '/var/www/html/notify-me/src/View/Frontend/User/index.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5b6bbdac269856_73126269',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5b1d07563e66bc52b9c21e0429199baf3c72e950' => 
    array (
      0 => '/var/www/html/notify-me/src/View/Frontend/User/index.tpl',
      1 => 1533787562,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5b6bbdac269856_73126269 (Smarty_Internal_Template $_smarty_tpl) {
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
