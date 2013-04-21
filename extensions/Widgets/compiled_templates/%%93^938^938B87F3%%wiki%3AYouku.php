<?php /* Smarty version 2.6.18-dev, created on 2013-04-21 12:55:10
         compiled from wiki:Youku */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'wiki:Youku', 3, false),array('modifier', 'default', 'wiki:Youku', 4, false),)), $this); ?>

<embed
src="http://player.youku.com/player.php/sid/<?php echo ((is_array($_tmp=$this->_tpl_vars['id'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'urlpathinfo') : smarty_modifier_escape($_tmp, 'urlpathinfo')); ?>
/v.swf"
quality="high" width="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['width'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')))) ? $this->_run_mod_handler('default', true, $_tmp, '480') : smarty_modifier_default($_tmp, '480')); ?>
"
height="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['height'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')))) ? $this->_run_mod_handler('default', true, $_tmp, 400) : smarty_modifier_default($_tmp, 400)); ?>
" align="middle"
allowScriptAccess="sameDomain" allowFullscreen="true"
type="application/x-shockwave-flash"></embed>