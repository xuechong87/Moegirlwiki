<?php 

/*
Copyright 2011 Olivier Finlay Beaton. All rights reserved.

Redistribution and use in source and binary forms, with or without modification, are
permitted provided that the following conditions are met:

   1. Redistributions of source code must retain the above copyright notice, this list of
      conditions and the following disclaimer.

   2. Redistributions in binary form must reproduce the above copyright notice, this list
      of conditions and the following disclaimer in the documentation and/or other materials
      provided with the distribution.

THIS SOFTWARE IS PROVIDED BY <COPYRIGHT HOLDER> ''AS IS'' AND ANY EXPRESS OR IMPLIED
WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND
FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL <COPYRIGHT HOLDER> OR
CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON
ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF
ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*/

/*
  By comitting against this file you retain copyright for your contributions and grant
  them to Olivier Finlay Beaton under the same BSD-2-Clause license (attribution).
*/ 

/**
 * Extension add headers and footers to articles
 * @file
 * @ingroup Extensions
 * @version 0.2.3
 * @authors Olivier Finlay Beaton (olivierbeaton.com)  
 * @copyright BSD-2-Clause http://www.opensource.org/licenses/BSD-2-Clause  
 * @note this extension is pay-what-you-want, please consider a purchase at http://olivierbeaton.com/mediawiki#headersfooters
 * @since 2011-09-26, 0.1   
 * @note coding convention followed: http://www.mediawiki.org/wiki/Manual:Coding_conventions
 */
 
if ( !defined( 'MEDIAWIKI' ) ) {
        die( 'This file is a MediaWiki extension, it is not a valid entry point' );
}

/* (not our var to doc)
 * extension credits
 * @since 2011-09-16, 0.1
 */
$wgExtensionCredits['parserhook'][] = array(
  'name' => 'HeadersFooters',
  'author' =>array('[http://olivierbeaton.com/ Olivier Finlay Beaton]'), 
  'version' => '0.2.3',
  'url' => 'http://www.mediawiki.org/wiki/Extension:HeadersFooters', 
  'descriptionmsg' => 'headersfooters-desc',
 );
 
/**
 * Should we discard duplicate header/footers. 
 * @since 2011-09-26, 0.1
 * @note most useful for multiple categories that add the same footer 
 */    
$wgHeadersFootersDuplicates = false;  

/**
 * Should we look for a global headers/footers 
 * @since 2011-09-27, 0.1 
 */
$wgHeadersFootersUsingGlobal = false; 

/**
 * Should we look at an article's namespace to find headers/footers 
 * @since 2011-09-26, 0.1 
 */    
$wgHeadersFootersUsingNamespaces = true; 

/**
 * Should we look at an article's categories to find headers/footers 
 * @since 2011-09-26, 0.1 
 */
$wgHeadersFootersUsingCategories = true;

/**
 * Should we look at an article to find headers/footers 
 * @since 2011-09-26, 0.1 
 */
$wgHeadersFootersUsingPages = false; 
   
if (isset($wgConfigureAdditionalExtensions) && is_array($wgConfigureAdditionalExtensions)) {

  /* (not our var to doc)
   * attempt to tell Extension:Configure how to web configure our extension
   * @since 2011-09-27, 0.1 
   */ 
  $wgConfigureAdditionalExtensions[] = array(
      'name' => 'HeadersFooters',
      'settings' => array(
          'wgHeadersFootersUsingGlobal' => 'bool',
          'wgHeadersFootersDuplicates' => 'bool',
          'wgHeadersFootersUsingNamespaces' => 'bool',
          'wgHeadersFootersUsingCategories' => 'bool',
          'wgHeadersFootersUsingPages' => 'bool',   
      ),
      'schema' => false,
      'url' => 'http://www.mediawiki.org/wiki/Extension:HeadersFooters',
  );
   
} // $wgConfigureAdditionalExtensions exists   
  
/* (not our var to doc)
 * special page names  
 * @since 2011-09-30, 0.2
 * @deprecated
 * @note here for pre 1.16 support
 */    
$wgExtensionAliasesFiles['HeadersFooters'] = dirname( __FILE__ ) . '/HeadersFooters.alias.php';  

/* (not our var to doc)
 * special page names  
 * @since 2011-10-02, 0.2.1
 */
$wgExtensionMessagesFiles['HeadersFooters'] = dirname( __FILE__ ) . '/HeadersFooters.alias.php';
   
/* (not our var to doc)
 * Holds our internalization output strings
 * @since 2011-09-26, 0.1
 */ 
$wgExtensionMessagesFiles['HeadersFooters'] = dirname( __FILE__ ) . '/HeadersFooters.i18n.php';   
 
/* (not our var to doc)
 * Our extension class, it will load the first time the core tries to access it
 * @since 2011-09-16, 0.1  
 */ 
$wgAutoloadClasses['ExtHeadersFooters'] = dirname(__FILE__) . '/HeadersFooters.body.php';

/* (not our var to doc)
 * Our special page, it will load the first time the core tries to access it
 * @since 2011-09-30, 0.2  
 */ 
$wgAutoloadClasses['ExtSpecialHeadersFooters'] = dirname(__FILE__) . '/ExtSpecialHeadersFooters.php';

/* (not our var to doc)
 * Called before we save the cache for a page
 * @since 2011-09-27, 0.1
 */ 
$wgHooks['ArticleAfterFetchContent'][] = 'ExtHeadersFooters::hookArticleAfterFetchContent';

/* (not our var to doc)
 * Called when user deletes a page.
 * @since 2011-10-02, 0.2.1
 */ 
$wgHooks['ArticleDeleteComplete'][] = 'ExtHeadersFooters::hookArticleDeleteComplete';

/* (not our var to doc)
 * Called after a user saves an edit
 * @since 2011-10-02, 0.2.1
 */ 
$wgHooks['ArticleUpdateBeforeRedirect'][] = 'ExtHeadersFooters::hookArticleUpdateBeforeRedirect';

/* (not our var to doc)
 * Called when user edits, saves or moves an article.
 * @since 2011-10-02, 0.2.1
 */
$wgHooks['NewRevisionFromEditComplete'][] =  'ExtHeadersFooters::hookNewRevisionFromEditComplete';              
        
/* (not our var to doc)
 * Called when a user undeletes a page.
 * @since 2011-10-02, 0.2.1
 */ 
$wgHooks['ArticleUndelete'][] = 'ExtHeadersFooters::hookArticleUndelete'; 

/* (not our var to doc)
 * Special page to register
 * @since 2011-09-30, 0.2  
 * @see $wgAutoloadClasses for how the class gets defined.  
 */
$wgSpecialPages['HeadersFooters'] = 'ExtSpecialHeadersFooters';

/* (not our var to doc)
 * Special page category
 * @since 2011-09-30, 0.2  
 */  
$wgSpecialPageGroups['HeadersFooters'] = 'wiki';
