<?php /* Smarty version 2.6.18-dev, created on 2013-04-21 13:48:35
         compiled from wiki:bilibili */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'wiki:bilibili', 5, false),)), $this); ?>


<script type="text/javascript">
var script = document.createElement('script');
script.src = "http://1.moegirlwiki.sinaapp.com/bilitest.php?id=<?php echo ((is_array($_tmp=$this->_tpl_vars['id'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'urlpathinfo') : smarty_modifier_escape($_tmp, 'urlpathinfo')); ?>
<?php if (isset ( $this->_tpl_vars['page'] )): ?>&page=<?php echo ((is_array($_tmp=$this->_tpl_vars['page'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'urlpathinfo') : smarty_modifier_escape($_tmp, 'urlpathinfo')); ?>
<?php endif; ?>";
document.getElementsByTagName('head')[0].appendChild(script);
</script>
<table class="wikitable">
<tbody>
<tr>
<th id="bilibili-title-<?php echo ((is_array($_tmp=$this->_tpl_vars['id'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
-<?php if (isset ( $this->_tpl_vars['page'] )): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['page'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'urlpathinfo') : smarty_modifier_escape($_tmp, 'urlpathinfo')); ?>
<?php else: ?>1<?php endif; ?>">
</th>
</tr>
<tr>
<td id="bilibili-video-<?php echo ((is_array($_tmp=$this->_tpl_vars['id'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
-<?php if (isset ( $this->_tpl_vars['page'] )): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['page'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'urlpathinfo') : smarty_modifier_escape($_tmp, 'urlpathinfo')); ?>
<?php else: ?>1<?php endif; ?>">
<button type="button" id="bilibili-button-<?php echo ((is_array($_tmp=$this->_tpl_vars['id'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
-<?php if (isset ( $this->_tpl_vars['page'] )): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['page'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'urlpathinfo') : smarty_modifier_escape($_tmp, 'urlpathinfo')); ?>
<?php else: ?>1<?php endif; ?>">点击此处加载视频</button>
</td>
</tr>
</tbody>
</table>