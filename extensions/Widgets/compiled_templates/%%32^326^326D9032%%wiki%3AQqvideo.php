<?php /* Smarty version 2.6.18-dev, created on 2012-06-29 17:07:56
         compiled from wiki:Qqvideo */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'wiki:Qqvideo', 3, false),array('modifier', 'default', 'wiki:Qqvideo', 3, false),)), $this); ?>


<embed src="http://static.video.qq.com/TPout.swf?vid=<?php echo ((is_array($_tmp=$this->_tpl_vars['id'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'urlpathinfo') : smarty_modifier_escape($_tmp, 'urlpathinfo')); ?>
" allowFullScreen="true" quality="high" width="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['width'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')))) ? $this->_run_mod_handler('default', true, $_tmp, '480') : smarty_modifier_default($_tmp, '480')); ?>
" height="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['height'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')))) ? $this->_run_mod_handler('default', true, $_tmp, 400) : smarty_modifier_default($_tmp, 400)); ?>
" align="middle" allowScriptAccess="always" type="application/x-shockwave-flash"></embed>