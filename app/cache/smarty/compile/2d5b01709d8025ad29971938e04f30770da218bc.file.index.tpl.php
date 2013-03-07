<?php /* Smarty version Smarty-3.1.13, created on 2013-03-05 23:44:23
         compiled from "D:\projects\easyapp\app\view\main\index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1768551337871ae09b4-29259771%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2d5b01709d8025ad29971938e04f30770da218bc' => 
    array (
      0 => 'D:\\projects\\easyapp\\app\\view\\main\\index.tpl',
      1 => 1362519858,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1768551337871ae09b4-29259771',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_51337871b518c4_32211195',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51337871b518c4_32211195')) {function content_51337871b518c4_32211195($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ('main/header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

	<h2>Этап 1: выбор или загрузка файла</h2><br/>
	<div class="row-fluid nav">
		<div class="span6 grey-block">
			<h5>Вы можете загрузить новый файл для анализа, либо выбрать ранее загруженный файл из списка справа</h5>
			<hr/>
			<form id="upload-form" class="form-inline">
				<label for="upload-file" style="margin-right: 10px;">Выберите файл для загрузки</label><input type="file" id="upload-file" style="width: 235px"/>
			</form>
		</div>
		<div class="span6 grey-block">
			<h5>Ранее загруженные файлы:</h5>
			<hr/>
			<div class="well">
				<ul class="nav nav-list file-list">
					<li><a>Файл #1<span class="add-on"><i class="icon-remove"></i></span></a></li>
					<li><a>Файл #2<span class="add-on"><i class="icon-remove"></i></span></a></li>
					<li><a>Файл #3<span class="add-on"><i class="icon-remove"></i></span></a></li>
					<li><a>Файл #4<span class="add-on"><i class="icon-remove"></i></span></a></li>
				</ul>
			</div>
		</div>
	</div>
<?php echo $_smarty_tpl->getSubTemplate ('main/footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>