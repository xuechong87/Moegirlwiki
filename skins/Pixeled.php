<?php
/**
 * Pixeled skin
 */

if( !defined( 'MEDIAWIKI' ) )
        die( "This is a skin file for MediaWiki and should not be viewed directly.\n" );

require_once( dirname( dirname( __FILE__ ) ) . '/includes/SkinTemplate.php');

/**
 * Inherit main code from SkinTemplate, set the CSS and template filter.
 */
class SkinPixeled extends SkinTemplate {
	function initPage( &$out ) {
		SkinTemplate::initPage( $out );
		$this->skinname  = 'pixeled';
		$this->stylename = 'pixeled';
		$this->template  = 'pixeledTemplate';
	}

	/* Override category functions to create a custom list */
	function getCategories() {
		$catlinks = $this->getCategoryLinks();
		if( !empty( $catlinks ) ) {
			return $catlinks;
		}
	}
 
	function getCategoryLinks() {
		global $wgUseCategoryBrowser;
		$out = $this->getOutput();
		if ( count( $out->mCategoryLinks ) == 0 ) {
			return '';
		}
		$embed = "<span dir='ltr'>";
		$pop = "</span>";
		$allCats = $out->getCategoryLinks();
		$s = '';
		$colon = wfMsgExt( 'colon-separator', 'escapenoentities' );
		if ( !empty( $allCats['normal'] ) ) {
			$t = $embed . implode( "{$pop} | {$embed}" , $allCats['normal'] ) . $pop;
			$msg = wfMsgExt( 'pagecategories', array( 'parsemag', 'escapenoentities' ), count( $allCats['normal'] ) );
			$s .= '<div class="sidebarbox"><div id="mw-normal-catlinks">' .
				Linker::link( Title::newFromText( wfMsgForContent( 'pagecategorieslink' ) ), $msg )
				. $colon . $t . '</div></div>';
		}
		# Hidden categories
		if ( isset( $allCats['hidden'] ) ) {
			if ( $this->getUser()->getBoolOption( 'showhiddencats' ) ) {
				$class = 'mw-hidden-cats-user-shown';
			} elseif ( $this->getTitle()->getNamespace() == NS_CATEGORY ) {
				$class = 'mw-hidden-cats-ns-shown';
			} else {
				$class = 'mw-hidden-cats-hidden';
			}
			$s .= "<div id=\"mw-hidden-catlinks\" class=\"$class\">" .
				wfMsgExt( 'hidden-categories', array( 'parsemag', 'escapenoentities' ), count( $allCats['hidden'] ) ) .
				$colon . '<ul>' . $embed . implode( "{$pop}{$embed}" , $allCats['hidden'] ) . $pop . '</ul>' .
				'</div>';
		}
		# optional 'dmoz-like' category browser. Will be shown under the list
		# of categories an article belong to
		if ( $wgUseCategoryBrowser ) {
			$s .= '<br /><hr />';
			# get a big array of the parents tree
			$parenttree = $this->getTitle()->getParentCategoryTree();
			# Skin object passed by reference cause it can not be
			# accessed under the method subfunction drawCategoryBrowser
			$tempout = explode( "\n", $this->drawCategoryBrowser( $parenttree ) );
			# Clean out bogus first entry and sort them
			unset( $tempout[0] );
			asort( $tempout );
			# Output one per line
			$s .= implode( "<br />\n", $tempout );
		}
		return $s;
	}

}


class pixeledTemplate extends QuickTemplate {
	function execute() {
		global $wgUser;
		$skin = $wgUser->getSkin();

		// Suppress warnings to prevent notices about missing indexes in $this->data
		wfSuppressWarnings();
		$this->html( 'headelement' );

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="<?php $this->text('xhtmldefaultnamespace') ?>" <?php 
	foreach($this->data['xhtmlnamespaces'] as $tag => $ns) {
		?>xmlns:<?php echo "{$tag}=\"{$ns}\" ";
	} ?>xml:lang="<?php $this->text('lang') ?>" lang="<?php $this->text('lang') ?>" dir="<?php $this->text('dir') ?>">
	<head>
		<meta http-equiv="Content-Type" content="<?php $this->text('mimetype') ?>; charset=<?php $this->text('charset') ?>" />
		<?php $this->html('headlinks') ?>
		<title><?php $this->text('pagetitle') ?></title>
		<style type="text/css" media="screen, projection">/*<![CDATA[*/
			@import "<?php $this->text('stylepath') ?>/common/shared.css?<?php echo $GLOBALS['wgStyleVersion'] ?>";
			@import "<?php $this->text('stylepath') ?>/<?php $this->text('stylename') ?>/main.css?<?php echo $GLOBALS['wgStyleVersion'] ?>";
		/*]]>*/</style>
		<link rel="stylesheet" type="text/css" <?php if(empty($this->data['printable']) ) { ?>media="print"<?php } ?> href="<?php $this->text('stylepath') ?>/common/commonPrint.css?<?php echo $GLOBALS['wgStyleVersion'] ?>" />
		<!--[if IE 6]><style type="text/css">@import "<?php $this->text('stylepath') ?>/<?php $this->text('stylename') ?>/ie6.css?<?php echo $GLOBALS['wgStyleVersion'] ?>";</style><![endif]-->
		<!--[if lt IE 7]><style type="text/css">@import "<?php $this->text('stylepath') ?>/<?php $this->text('stylename') ?>/ie.css?<?php echo $GLOBALS['wgStyleVersion'] ?>";</style><![endif]-->
		<meta http-equiv="imagetoolbar" content="no" />
		
		<?php print Skin::makeGlobalVariablesScript( $this->data ); ?>
                
		<script type="<?php $this->text('jsmimetype') ?>" src="<?php $this->text('stylepath' ) ?>/common/wikibits.js?<?php echo $GLOBALS['wgStyleVersion'] ?>"><!-- wikibits js --></script>
<?php	if($this->data['jsvarurl'  ]) { ?>
		<script type="<?php $this->text('jsmimetype') ?>" src="<?php $this->text('jsvarurl'  ) ?>"><!-- site js --></script>
<?php	} ?>
<?php	if($this->data['pagecss'   ]) { ?>
		<style type="text/css"><?php $this->html('pagecss'   ) ?></style>
<?php	}
		if($this->data['usercss'   ]) { ?>
		<style type="text/css"><?php $this->html('usercss'   ) ?></style>
<?php	}
		if($this->data['userjs'    ]) { ?>
		<script type="<?php $this->text('jsmimetype') ?>" src="<?php $this->text('userjs' ) ?>"></script>
<?php	}
		if($this->data['userjsprev']) { ?>
		<script type="<?php $this->text('jsmimetype') ?>"><?php $this->html('userjsprev') ?></script>
<?php	} ?>
		<script src="/mediaworki/load.php?debug=false&amp;lang=en&amp;modules=startup&amp;only=scripts&amp;skin=pixeled&amp;*"></script>
<?php		 if($this->data['trackbackhtml']) print $this->data['trackbackhtml']; ?>
		<!-- Head Scripts -->
<?php $this->html('headscripts') ?>
		<style type="text/css"><?php 
		if ($wgUser->getOption('justify')) {
			$s .= "#article, #bodyContent { text-align: justify; }\n";
		}
		if (!$wgUser->getOption('showtoc')) {
			$s .= "#toc { display: none; }\n";
		}
		if (!$wgUser->getOption('editsection')) {
			$s .= ".editsection { display: none; }\n";
		}
		echo $s;
		?></style>
	</head>
<body>


<div id="wrapper">
	<div id="header">
		<div id="logo">
			<h1><a href="/"><?php $this->msg('sitetitle') ?></a></h1>
			<span><?php $this->msg('sitesubtitle') ?></span>
		</div>
		<div id="topright">
			<ul>
<?php
			foreach( $this->data['personal_urls'] as $key => $item ) { ?>
				<li id="pt-<?php echo Sanitizer::escapeId($key) ?>"<?php
				if ($item['active']) { ?> class="active"<?php } ?>><a href="<?php
				echo htmlspecialchars($item['href']) ?>"<?php echo Xml::expandAttributes( Linker::tooltipAndAccesskeyAttribs('pt-'.$key) ) ?><?php
				if(!empty($item['class'])) { ?> class="<?php
				echo htmlspecialchars($item['class']) ?>"<?php } ?>><?php
				echo htmlspecialchars($item['text']) ?></a></li>
<?php			} ?>
			</ul>
		</div>
	</div> <!-- Closes header -->

	<div id="catnav">
		<ul id="nav">
<?php
		foreach($this->data['content_actions'] as $key => $tab) { ?>
			<li id="ca-<?php echo Sanitizer::escapeId($key) ?>"<?php
			if ($tab['active']) { ?> class="active"<?php } ?>><a href="<?php
			echo htmlspecialchars($tab['href']) ?>"<?php echo Xml::expandAttributes( Linker::tooltipAndAccesskeyAttribs('ca-'.$key) ) ?><?php
			if(!empty($tab['class'])) { ?> class="<?php
			echo htmlspecialchars($tab['class']) ?>"<?php } ?>><?php
			echo htmlspecialchars($tab['text']) ?></a></li>
<?php		} ?>
		</ul>
	</div> <!-- Closes catnav -->

	<div class="cleared"></div>

	<div id="main">
		<div id="contentwrapper">
			<div class="topPost">
				<div class="topContent">
					<h2><?php $this->html('title') ?></h2>
					<!-- start content -->
					<?php $this->html('bodytext') ?>
					<!-- end content -->
					<div class="visualClear"></div>
				</div>
			</div>
		</div> <!-- Closes contentwrapper -->

		<div id="sidebars">
			<div id="sidebar_full">
				<ul>
					<li>
						<div class="sidebarbox">
							<h2><label for="searchInput"><?php $this->msg('search') ?></label></h2>
							<div id="searchBody" class="pBody">
								<form action="<?php $this->text('searchaction') ?>" id="searchform">
								<div>
									<input id="searchInput" name="search" type="text"<?php 
										if( isset( $this->data['search'] ) ) {
											?> value="<?php $this->text('search') ?>"<?php } ?> />
									<input type='submit' name="go" class="searchButton" id="searchGoButton"        value="<?php $this->msg('searcharticle') ?>" />&nbsp;
									<input type='submit' name="fulltext" class="searchButton" id="mw-searchButton" value="<?php $this->msg('searchbutton') ?>" />
								</div>
								</form>
							</div>
						</div>
					</li>

					<li>
						<?php echo $this->data['catlinks']."\n" ?>
					</li>
				</ul>
			</div> <!-- Closes sidebar_full -->

<?php
$sidebar = $this->data['sidebar'];
foreach ($this->data['sidebar']  as $boxName => $cont) {
	if ( $boxName == 'navigation' ) {
?>
			<div id="sidebar_left">
				<ul>
					<li>
						<div class="sidebarbox">
							<h2><?php $this->msg('navigation') ?></h2>
							<ul>
<?php foreach($cont as $key => $val) { ?>
								<li id="<?php echo Sanitizer::escapeId($val['id']) ?>"<?php
					if ( $val['active'] ) { ?> class="active" <?php }
				?>><a href="<?php echo htmlspecialchars($val['href']) ?>"<?php echo Xml::expandAttributes( Linker::tooltipAndAccesskeyAttribs( $val['id'] ) ) ?>><?php echo htmlspecialchars($val['text']) ?></a></li>
<?php					} ?>
							</ul>
						</div>
					</li>
				</ul>
			</div> <!-- Closes sidebar_left -->
<?php	}
}
?>

			<div id="sidebar_right">
				<ul>
					<li>
						<div class="sidebarbox">
							<h2><?php $this->msg('toolbox') ?></h2>
							<ul>
<?php
	if($this->data['notspecialpage']) { ?>
								<li id="t-whatlinkshere"><a href="<?php
								echo htmlspecialchars($this->data['nav_urls']['whatlinkshere']['href'])
								?>"<?php echo Xml::expandAttributes( Linker::tooltipAndAccesskeyAttribs('t-whatlinkshere') ) ?>><?php $this->msg('whatlinkshere') ?></a></li>
<?php
	if( $this->data['nav_urls']['recentchangeslinked'] ) { ?>
								<li id="t-recentchangeslinked"><a href="<?php
								echo htmlspecialchars($this->data['nav_urls']['recentchangeslinked']['href'])
								?>"<?php echo Xml::expandAttributes( Linker::tooltipAndAccesskeyAttribs('t-recentchangeslinked') ) ?>><?php $this->msg('recentchangeslinked') ?></a></li>
<?php
 	}
	}
	if(isset($this->data['nav_urls']['trackbacklink'])) { ?>
								<li id="t-trackbacklink"><a href="<?php
								echo htmlspecialchars($this->data['nav_urls']['trackbacklink']['href'])
								?>"<?php echo Xml::expandAttributes( Linker::tooltipAndAccesskeyAttribs('t-trackbacklink') ) ?>><?php $this->msg('trackbacklink') ?></a></li>
<?php
 	}
	if($this->data['feeds']) { ?>
								<li id="feedlinks"><?php foreach($this->data['feeds'] as $key => $feed) {
								?><span id="feed-<?php echo Sanitizer::escapeId($key) ?>"><a href="<?php
								echo htmlspecialchars($feed['href']) ?>"<?php echo Xml::expandAttributes( Linker::tooltipAndAccesskeyAttribs('feed-'.$key) ) ?>><?php echo htmlspecialchars($feed['text']) ?></a>&nbsp;</span>
<?php
	} ?>
								</li>
<?php
	}

		foreach( array('contributions', 'log', 'blockip', 'emailuser', 'upload', 'specialpages') as $special ) {

			if($this->data['nav_urls'][$special]) { ?>
								<li id="t-<?php echo $special ?>"><a href="<?php echo htmlspecialchars($this->data['nav_urls'][$special]['href'])
								?>"<?php echo Xml::expandAttributes( Linker::tooltipAndAccesskeyAttribs('t-'.$special) ) ?>><?php $this->msg($special) ?></a></li>
<?php			}
		}
		if(!empty($this->data['nav_urls']['print']['href'])) { ?>
								<li id="t-print"><a href="<?php echo htmlspecialchars($this->data['nav_urls']['print']['href'])
								?>"<?php echo Xml::expandAttributes( Linker::tooltipAndAccesskeyAttribs('t-print') ) ?>><?php $this->msg('printableversion') ?></a></li>
<?php		}
		if(!empty($this->data['nav_urls']['permalink']['href'])) { ?>
								<li id="t-permalink"><a href="<?php echo htmlspecialchars($this->data['nav_urls']['permalink']['href'])
								?>"<?php echo Xml::expandAttributes( Linker::tooltipAndAccesskeyAttribs('t-permalink') ) ?>><?php $this->msg('permalink') ?></a></li>
<?php		}
		elseif ($this->data['nav_urls']['permalink']['href'] === '') { ?>
								<li id="t-ispermalink"<?php echo $skin->tooltip('t-ispermalink') ?>><?php $this->msg('permalink') ?></li>
<?php		}

		wfRunHooks( 'pixeledTemplateToolboxEnd', array( &$this ) );
?>
							</ul>
						</div>
					</li>
				</ul>
			</div> <!-- Closes sidebar_right -->
			<div class="cleared"></div>
		</div> <!-- Closes sidebars -->
		<div class="cleared"></div>
	</div> <!-- Closes main -->

	<div id="morefoot">
		<div class="col1">
			<h3>Looking for something?</h3>
			<p>Use the form below to search the wiki:</p>
			<div id="searchBody" class="pBody">
				<form action="<?php $this->text('searchaction') ?>" id="searchform">
				<div>
					<input id="searchInput" name="search" type="text"<?php 
						if( isset( $this->data['search'] ) ) {
							?> value="<?php $this->text('search') ?>"<?php } ?> />
					<input type='submit' name="go" class="searchButton" id="searchGoButton"        value="<?php $this->msg('searcharticle') ?>" />&nbsp;
					<input type='submit' name="fulltext" class="searchButton" id="mw-searchButton" value="<?php $this->msg('searchbutton') ?>" />
				</div>
				</form>
				<p>Still not finding what you're looking for? Drop a comment on a post or contact us so we can take care of it!</p>
			</div>
		</div>
		<div class="col2">
			<h3><?php $this->msg('navigation') ?></h3>
<?php
//$sidebar = $this->data['sidebar'];
foreach ($sidebar as $boxName => $cont) {
	if ( $boxName == 'navigation' ) {
?>
			<ul>
<?php foreach($cont as $key => $val) { ?>
				<li id="<?php echo Sanitizer::escapeId($val['id']) ?>"<?php
				if ( $val['active'] ) { ?> class="active" <?php }
				?>><a href="<?php echo htmlspecialchars($val['href']) ?>"<?php echo Xml::expandAttributes( Linker::tooltipAndAccesskeyAttribs( $val['id'] ) ) ?>><?php echo htmlspecialchars($val['text']) ?></a></li>
<?php				} ?>
			</ul>
<?php	}
}
?>
		</div>
		<div class="col3">
			<h3><?php $this->msg('toolbox') ?></h3>
			<ul>
<?php
		if($this->data['notspecialpage']) { ?>
				<li id="t-whatlinkshere"><a href="<?php
				echo htmlspecialchars($this->data['nav_urls']['whatlinkshere']['href'])
				?>"<?php echo Xml::expandAttributes( Linker::tooltipAndAccesskeyAttribs('t-whatlinkshere') ) ?>><?php $this->msg('whatlinkshere') ?></a></li>
<?php
			if( $this->data['nav_urls']['recentchangeslinked'] ) { ?>
				<li id="t-recentchangeslinked"><a href="<?php
				echo htmlspecialchars($this->data['nav_urls']['recentchangeslinked']['href'])
				?>"<?php echo Xml::expandAttributes( Linker::tooltipAndAccesskeyAttribs('t-recentchangeslinked') ) ?>><?php $this->msg('recentchangeslinked') ?></a></li>
<?php 			}
		}
		if(isset($this->data['nav_urls']['trackbacklink'])) { ?>
				<li id="t-trackbacklink"><a href="<?php
				echo htmlspecialchars($this->data['nav_urls']['trackbacklink']['href'])
				?>"<?php echo Xml::expandAttributes( Linker::tooltipAndAccesskeyAttribs('t-trackbacklink') ) ?>><?php $this->msg('trackbacklink') ?></a></li>
<?php 	}
		if($this->data['feeds']) { ?>
				<li id="feedlinks"><?php foreach($this->data['feeds'] as $key => $feed) {
				?><span id="feed-<?php echo Sanitizer::escapeId($key) ?>"><a href="<?php
				echo htmlspecialchars($feed['href']) ?>"<?php echo Xml::expandAttributes( Linker::tooltipAndAccesskeyAttribs('feed-'.$key) ) ?>><?php echo htmlspecialchars($feed['text']) ?></a>&nbsp;</span>
				<?php } ?></li><?php
		}

		foreach( array('contributions', 'log', 'blockip', 'emailuser', 'upload', 'specialpages') as $special ) {

			if($this->data['nav_urls'][$special]) { ?>
				<li id="t-<?php echo $special ?>"><a href="<?php echo htmlspecialchars($this->data['nav_urls'][$special]['href'])
				?>"<?php echo Xml::expandAttributes( Linker::tooltipAndAccesskeyAttribs('t-'.$special) ) ?>><?php $this->msg($special) ?></a></li>
<?php			}
		}
		if(!empty($this->data['nav_urls']['print']['href'])) { ?>
				<li id="t-print"><a href="<?php echo htmlspecialchars($this->data['nav_urls']['print']['href'])
				?>"<?php echo Xml::expandAttributes( Linker::tooltipAndAccesskeyAttribs('t-print') ) ?>><?php $this->msg('printableversion') ?></a></li>
<?php		}
		if(!empty($this->data['nav_urls']['permalink']['href'])) { ?>
				<li id="t-permalink"><a href="<?php echo htmlspecialchars($this->data['nav_urls']['permalink']['href'])
				?>"<?php echo Xml::expandAttributes( Linker::tooltipAndAccesskeyAttribs('t-permalink') ) ?>><?php $this->msg('permalink') ?></a></li>
<?php		}
		elseif ($this->data['nav_urls']['permalink']['href'] === '') { ?>
				<li id="t-ispermalink"<?php echo $skin->tooltip('t-ispermalink') ?>><?php $this->msg('permalink') ?></li>
<?php
		}

		wfRunHooks( 'pixeledTemplateToolboxEnd', array( &$this ) );
?>
			</ul>
		</div>
<!--<?php
			$footerlinks = array(
				'lastmod', 'viewcount', 'numberofwatchingusers', 'about', 'tagline',
			);
			foreach( $footerlinks as $aLink ) {
				if( isset( $this->data[$aLink] ) && $this->data[$aLink] ) {
?>			<li id="<?php echo$aLink?>"><?php $this->html($aLink) ?></li>
<?php 		}
			}
?>-->
		<div class="cleared"></div>
	</div> <!-- Closes morefoot -->
	<div class="cleared"></div>
</div> <!-- Closes wrapper -->
<div class="cleared"></div>

		</div><!-- end of the left (by default at least) column -->
			<div class="visualClear"></div>
	<?php $this->html('bottomscripts'); /* JS call to runBodyOnloadHook */ ?>
<?php $this->html('reporttime') ?>
<?php if ( $this->data['debug'] ): ?>
<!-- Debug output:
<?php $this->text( 'debug' ); ?>

-->
<?php endif; ?>
</body>
</html>
<?php
	wfRestoreWarnings();
	} // end of execute() method
} // end of class
?>
