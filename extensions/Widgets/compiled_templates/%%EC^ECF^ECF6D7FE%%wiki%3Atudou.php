<?php /* Smarty version 2.6.18-dev, created on 2013-04-21 13:31:34
         compiled from wiki:tudou */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'wiki:tudou', 2, false),array('modifier', 'default', 'wiki:tudou', 2, false),)), $this); ?>

<embed src="http://www.tudou.com/<?php if ($this->_tpl_vars['type'] == 'video'): ?>v<?php elseif ($this->_tpl_vars['type'] == 'album'): ?>a<?php endif; ?>/<?php echo ((is_array($_tmp=$this->_tpl_vars['id'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'urlpathinfo') : smarty_modifier_escape($_tmp, 'urlpathinfo')); ?>
/&videoClickNavigate=false/v.swf" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" wmode="opaque" width="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['width'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')))) ? $this->_run_mod_handler('default', true, $_tmp, '480') : smarty_modifier_default($_tmp, '480')); ?>
" height="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['height'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')))) ? $this->_run_mod_handler('default', true, $_tmp, 400) : smarty_modifier_default($_tmp, 400)); ?>
"></embed>