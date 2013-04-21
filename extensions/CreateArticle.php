<?php
/**
 * Extension CreateArticle.php
 *
 * @author Lisa Ridley <lhridley@theridleys.org>
 * @copyright Lisa Ridley
 * @license GNU
 * @version 0.91beta 20 Mar 2007
 *
 * This extension is a derivation of the <inputbox> extension by Erik M?ller
 *
 * To implement this extension, save in the extensions/ folder as CreateArticle.php
 * and insert the following line into LocalSettings.php, near the end:
 *
 * require_once("$IP/extensions/CreateArticle.php");
 *
 * or if that doesn't work try:
 * 
 * require_once("extensions/CreateArticle.php" );
 *
 * This extension has been tested and verified to work with version 1.6.9
 *
 * Instructions:  To use this extension, insert the following tag into a
 * MediaWiki article page:
 *      <createarticle>
 *       type=createarticle
 *       argument=
 *       ....
 *      </createarticle>
 *
 * The following are valid arguments:
 * type=createarticle (this is the only valid argument, but future functionality is
 *      under development
 * prefix=a prefix for page creation.  This will be added to the beginning of
 *      the article name created.  Good for assigning articles to namespaces.
 * subpage=a suffix for page creation.  This will be added to the end of the
 *      article name created.  For valid subpages, make sure you use a "/" at
 *      the beginning of the subpage name (ex:  /article)
 * width=the width of the text creation input field (defaults to 50)
 * preload=the name of the template in the MediaWiki namespace that holds the
 *      text you wish to preload in the newly created article page
 * editintro=the name of the template in the MediaWiki namespace that holds the
 *      instructions you wish to have displayed above the article creation input
 *      box
 * default=the default text you want to show in the article creation input box
 * bgcolor=color you want the background display to be
 * buttonlabel=text you want to show in the create article button.  Defaults to
 *      label stored in MediaWiki:createarticle system message which is
 *      "create article" unless it has been overridden
 * align=position of create article box on the page; valid arguments are left,
 *      center, and right; defaults to center
 *
 * Note:  While this feature will work with subpages, there is no check to see
 * if creating a subpage is a valid act (i.e. $wgNamespacesWithSubpage is not
 * checked)
 *
 */
 
/**
 * Register the CreateArticle extension with MediaWiki
 */
$wgExtensionFunctions[] = 'wfCreateArticle';
$wgExtensionCredits['parserhook'][] = array(
        'name' => 'CreateArticle',
        'author' => 'Lisa Ridley',
        'url' => 'http://www.mediawiki.org/wiki/User:Hoggwild5',
        'description' => 'Generates create article input forms allowing for articles to be created with a variety of prefixes and suffixes',
        'version' => '0.9 beta',
);
/**
 * Registers the CreateArticle hook
 **/
$wgHooks['UnknownAction'][] = 'actionCreatearticle';
 
/**
 * Sets the createarticle tag and the article creation box by which this operates
 */
function wfCreateArticle() {
    global $wgParser;
    $wgParser->setHook('createarticle', 'renderCreatebox');
}
/**
 * Renders a article creation box based on information provided by $input.
 */
function renderCreatebox($input, $params, &$parser) {
        $createbox=new Createbox( $parser );
        getCreateBoxOption($createbox->type,$input,'type');
        getCreateBoxOption($createbox->prefix,$input,'prefix');
        getCreateBoxOption($createbox->subpage,$input,'subpage');
        getCreateBoxOption($createbox->width,$input,'width',true);
        getCreateBoxOption($createbox->preload,$input,'preload');
        getCreateBoxOption($createbox->editintro,$input,'editintro');
        getCreateBoxOption($createbox->buttonlabel,$input,'buttonlabel');
        getCreateBoxOption($createbox->defaulttext,$input,'default');
        getCreateBoxOption($createbox->bgcolor,$input,'bgcolor');
        getCreateBoxOption($createbox->align,$input,'align');
        getCreateBoxOption($createbox->br,$input,'br');
        getCreateBoxOption($createbox->hidden, $input, 'hidden');
        $createbox->lineBreak();
        $createbox->checkWidth();
 
        $boxhtml=$createbox->render();
        # Maybe support other useful magic words here
        # Commenting this line out for now; causing problems for some for no apparent reason
        #$boxhtml=str_replace("{{PAGENAME}}",$parser->getTitle()->getText(),$boxhtml);
        if($boxhtml) {
                return $boxhtml;
        } else {
                return '<div><strong class="error">create box: type not defined.</strong></div>';
        }
}
/* Parses tag input arguments */
function getCreateBoxOption(&$value,&$input,$name,$isNumber=false) {
      if(preg_match("/^\s*$name\s*=\s*(.*)/mi",$input,$matches)) {
                if($isNumber) {
                        $value=intval($matches[1]);
                } else {
                        $value=htmlspecialchars($matches[1]);
                }
        }
}
 
class Createbox {
        var $type,$prefix, $subpage, $width;
        var $preload,$editintro, $bgcolor;
        var $defaulttext,$buttonlabel;
        var $align, $br, $hidden;
 
        function CreateBox( &$parser ) {
                $this->parser =& $parser;
        }
 
        function render() {
                if($this->type=='createarticle'){
                        return $this->getCreateForm();
                } else {
                        return false;
                }
        }
 
        function getCreateForm() {
                global $wgScript;
                if ($this->align == '') {
                    $this->align = "center";
                }
                $action = htmlspecialchars( $wgScript );
                $comment='';
                if ($this->buttonlabel == '') {
                    $this->buttonlabel=wfMsgHtml("createarticle");
                } else {
                    $this->buttonlabel = trim($this->buttonlabel);
                }
                $type = $this->hidden ? 'hidden' : 'text';
                $createform=<<<ENDFORM
<table border="0" width="100%" cellspacing="0" cellpadding="0">
<tr><td align="{$this->align}" bgcolor="{$this->bgcolor}">
<form name="createbox" action="$action" method="get" class="createbox">
<input type='hidden' name="action" value="createarticle" />
<input type="hidden" name="prefix" value="{$this->prefix}" />
<input type="hidden" name="preload" value="{$this->preload}" />
<input type="hidden" name="subpage" value="{$this->subpage}" />
<input type="hidden" name="editintro" value="{$this->editintro}" />
{$comment}
<input class="createboxInput" name="title" type="{$type}"
value="{$this->defaulttext}" size="{$this->width}" />{$this->br}
<input type='submit' name="createarticle" class="createboxButton"
value="{$this->buttonlabel}" />
</form>
</td></tr></table>
ENDFORM;
                return $createform;
        }
        /**
         * If br=no, create button is placed on rh side of textbox
         * defaults to yes
         */
        function lineBreak() {
                # Should we be inserting a <br /> tag?
                $cond = ( strtolower( $this->br ) == "no" );
                $this->br = $cond ? '' : '<br />';
        }
        /**
         * If the width is not supplied, set it to 50
         */
        function checkWidth() {
                if( !$this->width || trim( $this->width ) == '' )
                        $this->width = 50;
        }
}
/* creates the requested article using the supplied parameters */
function actionCreatearticle($action, $article) {
    global $wgRequest, $wgTitle, $wgOut, $prefix;
 
    if($action != 'createarticle') return true;
 
    $prefix = $wgRequest->getVal('prefix');
    $subpage = $wgRequest->getVal('subpage');
    $title = $wgRequest->getVal('title');
 
    if($prefix && strpos($title, $prefix)!==0) {
        $title = $prefix . $title;
    }
    if($subpage && substr($title,-strlen($subpage))!=$subpage) {
        $title.= $subpage;
    }
    $title = Title::newFromText( $title );
    if (trim($wgRequest->getVal('title'))=='') {
            $wgTitle = Title::newFromText( wfMsgForContent( 'badtitle' ) );
            $wgOut->errorpage( 'badtitle', 'badtitletext');    }
    if(isset($title) && $title->getArticleID() == 0) {
            accRedirect($title, 'createarticle');
    } elseif (!isset($title)) {
            $wgTitle = Title::newFromText( wfMsgForContent( 'badtitle' ) );
            $wgOut->errorpage( 'badtitle', 'badtitletext');
    } else {
         ##need to make this create error messages to disallow editing existing articles from here
        $wgTitle = Title::newFromText( wfMsgForContent( 'createarticle' ) );
        $wgOut->errorpage( 'error', 'articleexists' );
    }
    return false;
}
/* builds and sends the URL to the browser */
function accRedirect($title, $action) {
    global $wgRequest, $wgOut;
    $query = "action=edit&section=" . $wgRequest->getVal('section') .
        "&createintro=" . $wgRequest->getVal('createintro') . "&preload=" .   
        $wgRequest->getVal('preload') . "&editintro=" . $wgRequest->getVal('editintro');
 
    $wgOut->setSquidMaxage( 1200 );
    $wgOut->redirect($title->getFullURL( $query ), '301');
}