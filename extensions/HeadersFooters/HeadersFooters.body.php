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
 * @file
 * @ingroup Extensions
 * @authors Olivier Finlay Beaton (olivierbeaton.com) 
 * @copyright BSD-2-Clause http://www.opensource.org/licenses/BSD-2-Clause  
 * @since 2011-09-26, 0.1
 * @note coding convention followed: http://www.mediawiki.org/wiki/Manual:Coding_conventions 
 */

if ( !defined( 'MEDIAWIKI' ) ) {
        die( 'This file is a MediaWiki extension, it is not a valid entry point' );
}

/**
 * adds headers and footers before and after article text.
 * @ingroup Extensions
 * @since 2011-09-26, 0.1
 */ 
class ExtHeadersFooters {
  /**
   * message path for global headers/footers.
   * append dash and header/footer path.
   * @since 2011-09-29, 0.2
   */        
  public static $GLOBAL_PATH = 'headersfooters-global';
  
  /**
   * message path for namespace headers/footers.
   * append dash, namespace number/id, another dash then header/footer path.    
   * @since 2011-09-29, 0.2
   */
  public static $NAMESPACE_PATH = 'headersfooters-ns';
  
  /**
   * message path for global headers/footers.
   * append dash, case-sensitive category name (without the Category:), another dash then header/footer path.   
   * @since 2011-09-29, 0.2
   */
  public static $CATEGORY_PATH = 'headersfooters-cat';
  
  /**
   * message path for global headers/footers
   * append dash, namespace number/id, another dash, case-sensitive page name (without Namespace string:), another dash then header/footer path.   
   * @since 2011-09-29, 0.2
   */
  public static $PAGE_PATH = 'headersfooters-page';
  
  /**
   * message path for headers. 
   * appended to other paths.
   * @since 2011-09-29, 0.2
   */
  public static $HEADER_PATH = 'header';
  
  /**
   * message path for footers.
   * appended to other paths.
   * @since 2011-09-29, 0.2
   */
  public static $FOOTER_PATH = 'footer';  
 
  /**
   * holds each token to add to the end of the page.  
   * @since 2011-09-26, 0.1
   * @note case must match sub-page name   
   */
  static $footer = array();
  
  /** 
   * holds each token to add to the beginning of the page.   
   * @since 2011-09-26, 0.1
   * @note case must match sub-page name   
   */
  static $header = array();
    
  /** 
   * constructor, inits our i18n messages
   * @since 2011-09-26, 0.1
   */     
  public function __construct() {    
    // load our i18n messages
    wfLoadExtensionMessages('HeadersFooters');
  }
  
  /**
   * checks if we should clear some caches when people create headers/footers.
   * @param[in] $title Title of the page edited.   
   * @since 2011-10-02, 0.2.1            
   */                                                              
  protected static function clearCache($title) {
    global $wgHeadersFootersUsingGlobal,$wgHeadersFootersUsingNamespaces,
      $wgHeadersFootersUsingCategories,$wgHeadersFootersUsingPages;
    
    if ($wgHeadersFootersUsingGlobal || $wgHeadersFootersUsingNamespaces || $wgHeadersFootersUsingCategories || $wgHeadersFootersUsingPages) {
      //$title->invalidateCache();
    }
    
    if ($title->getNamespace() != NS_MEDIAWIKI) {
      // not a header/footer
      return;
    }
    
    if( wfReadOnly() ) {
      // hook should never have been called, but just in case...
      return;
    }
      
    $name = $title->getText();
    $name[0] = strtolower($name[0]);  
     
    // global
    if ($wgHeadersFootersUsingGlobal
      && (
        $name == self::$GLOBAL_PATH.'-'.self::$HEADER_PATH
        || $name == self::$GLOBAL_PATH.'-'.self::$FOOTER_PATH)
      ) {
      // clear every single page in the wiki      
      $tables = array();
      $conds = array();
      $join_conds = array();
      self::clearCacheManual($tables,$conds,$join_conds);
    } // global
    
    // namespace
    if ($wgHeadersFootersUsingNamespaces && preg_match('/^'.self::$NAMESPACE_PATH.'-([0-9]+)-(?:'.self::$HEADER_PATH.'|'.self::$FOOTER_PATH.')$/',$name,$matches)) {
      // clear all pages in a namespace
      $ns = $matches[1];
      $tables = array();
      $conds = array( 'page_namespace' => $ns );
      $join_conds = array();
      self::clearCacheManual($tables,$conds,$join_conds);
    } // namespace
    
    // category
    if ($wgHeadersFootersUsingCategories && preg_match('/^'.self::$CATEGORY_PATH.'-(.+)-(?:'.self::$HEADER_PATH.'|'.self::$FOOTER_PATH.')$/',$name,$matches)) {
      // clear all pages belonging to a category
      $cat = $matches[1];
      $tables = array('categorylinks');
      $conds = array('cl_to' => str_replace(' ','_',$cat));
      $join_conds = array();
      $join_conds['categorylinks'] = array('INNER JOIN', 'page_id = cl_from');
      self::clearCacheManual($tables,$conds,$join_conds);
    } // category
    
    // page
    if ($wgHeadersFootersUsingPages && preg_match('/^'.self::$PAGE_PATH.'-([0-9]+)-(.+)-(?:'.self::$HEADER_PATH.'|'.self::$FOOTER_PATH.')$/',$name,$matches)) {
      // clear one page
      $ns = $matches[1];
      $page = $matches[2];
      $newTitle = Title::makeTitle($ns,str_replace(' ','_',$page));
      if ($newTitle !== null && $newTitle->exists()) {
        $newTitle->invalidateCache();
      }
    } // page  
    
  } // function
  
  /**
   * touches the files in db, clears the file cache.
   * @param[in] $user_tables \array list of tables to add to query
   * @param[in] $user_conds \array list of row conditions to be met      
   * @param[in] $user_joins \array join parameters for extra table      
   * @since 2011-10-02, 0.2.1            
   */
  protected static function clearCacheManual($user_tables,$user_conds,$user_joins) {
    // update the touched
    $dbw = wfGetDB( DB_MASTER );
    // since we add a join, no automatic prefixes get put onto the table names.
    $tables = $dbw->tableName('page');
    $var_updates = array( 'page_touched' => $dbw->timestamp() );
    $conds = array('page_namespace != '.NS_MEDIAWIKI); 
    foreach($user_joins as $table=>$info) {
      $tables .= ' '.$info[0].' '.$dbw->tableName($table);
      $conds[] = $info[1];       
    }
    //$sql = 'UPDATE '.$tables.' SET '.$dbw->makeList($var_updates, LIST_SET).' WHERE '.$dbw->makeList($conds+$user_conds,LIST_AND); var_dump($sql);
    $success = $dbw->update( $tables, $var_updates, array_merge($conds,$user_conds), __METHOD__);
    
    // clear each title's cache
    $dbw = wfGetDB( DB_SLAVE );
    $tables = array('page');
    $vars = array('page_namespace', 'page_title');
    $conds = array('page_namespace != '.NS_MEDIAWIKI);
    $options = array(); // order by, limit, use index
    $join_conds = array();

    // $sql = $dbw->selectSQLText( array_merge($tables,$user_tables), $vars, array_merge($conds,$user_conds), __METHOD__, $options, array_merge($join_conds,$user_joins));var_dump($sql); 
    $pages = $dbw->select( array_merge($tables,$user_tables), $vars, array_merge($conds,$user_conds), __METHOD__, $options, array_merge($join_conds,$user_joins));
    foreach($pages as $row) {    
      //echo 'row ns: '.$row->page_namespace.' title: '.$row->page_title."\n";
      HTMLFileCache::clearFileCache( Title::makeTitle($row->page_namespace, $row->page_title) );
    }    
  } // function
  
  /**
   * called after user saves an edit, makes sure new header/footers are shown  
   * @param[inout] &$article the article
   * @param[inout] &$sectionanchor The section anchor link (e.g. "#overview" )
   * @param[inout] &$extraq Extra query parameters which can be added via hooked functions
   * @return \bool true, continue hook processing
   * @since 2011-10-02, 0.2.1      
   * @see hook documentation http://www.mediawiki.org/wiki/Manual:Hooks/ArticleUpdateBeforeRedirect
   * @note requires MediaWiki 1.11.0            
   */
  public static function hookArticleUpdateBeforeRedirect($article, &$sectionanchor, &$extraq) {
    global $wgHeadersFootersUsingGlobal,$wgHeadersFootersUsingNamespaces,
      $wgHeadersFootersUsingCategories,$wgHeadersFootersUsingPages;
    
    wfDebugLog('headersfooters', __METHOD__);

    $title = $article->getTitle();
    
    if ($wgHeadersFootersUsingGlobal || $wgHeadersFootersUsingNamespaces 
      || $wgHeadersFootersUsingCategories || $wgHeadersFootersUsingPages) {
    
      // let's touch the file to be in the future
      // OutputPage::output calls OutputPage::sendCacheControl dead last, we have no chance to invalidate it with a current timestamp
      // if we set the date too far in the future, changes may happen but client will still be cached
      
      $dbw = wfGetDB( DB_MASTER );
      $dbw->update( 'page',
        array( 'page_touched' => $dbw->timestamp()+5 ),
        $title->pageCond(),
        __METHOD__
      );
      HTMLFileCache::clearFileCache( $title );
    }     
    
    return true;
  }
  
  /**
   * check if our article has headers or footers, and add them  
   * @param[inout] &$article Title the article object being loaded from the database
   * @param[inout] &$content \string the content (text) of the article
   * @return \bool true, continue hook processing
   * @since 2011-09-29, 0.2      
   * @see hook documentation http://www.mediawiki.org/wiki/Manual:Hooks/ArticleAfterFetchContent
   * @note requires MediaWiki 1.6.0            
   */
  public static function hookArticleAfterFetchContent(&$article, &$content) {
    global $wgRequest,$wgHeadersFootersUsingGlobal,$wgHeadersFootersUsingNamespaces,
      $wgHeadersFootersUsingCategories,$wgHeadersFootersUsingPages;
    
    wfDebugLog('headersfooters', __METHOD__); 
          
    $request = $wgRequest;
    if (method_exists($article, 'getContext')) {
      $context = $article->getContext();
      if (method_exists($context, 'getRequest')) {
        $request = $context->getRequest();
      }
    }        
    
    $action = $request->getVal('action','view');

    wfDebugLog('headersfooters', "action: ".$action); 

    // we aren't dealing with the article body, watch out for the cache!
    if ($action != 'view' && $action != 'print' && $action != 'purge') {
      return true;
    }    
    
    // title for the page we're parsing and it's namespace   
    $title = $article->getTitle();    
    $ns = $title->getNamespace();
    
    // don't run in MEDIAWIKI namespace
    if ($ns == NS_MEDIAWIKI) {
      return true;    
    }
    
    // page scan
    if ($wgHeadersFootersUsingPages) { 
      wfDebugLog('headersfooters', "scanning for page hf:");
      self::doHFChecks(self::$PAGE_PATH.'-'.$ns.'-'.$title->getText());
    } // if pages       
    
    if ($wgHeadersFootersUsingCategories) {
      wfDebugLog('headersfooters', "scanning for category hf:");
      $cats = $title->getParentCategories();
      $cats = array_keys($cats);
      
      foreach ($cats as $name) {
        // remove the Category: (may be localized)
        $name = substr($name, strpos($name,':')+1);
        wfDebugLog('headersfooters', "checking ".$name); 
        self::doHFChecks(self::$CATEGORY_PATH.'-'.$name);
      } // foreach cat          
    } // if cats
    
    // namespace scan  
    if ($wgHeadersFootersUsingNamespaces) {
      wfDebugLog('headersfooters', "scanning for ns hf:");
      self::doHFChecks(self::$NAMESPACE_PATH.'-'.$ns);
    } // if namespaces
    
    // global scan  
    if ($wgHeadersFootersUsingNamespaces) {
      wfDebugLog('headersfooters', "scanning for global hf:");
      self::doHFChecks(self::$GLOBAL_PATH);
    } // if global
    
    // apply headers
    foreach (self::$header as $wikitext) {
      $content = $wikitext."\n".$content;
    }

    foreach(self::$footer as $wikitext) {
      $content = $content."\n".$wikitext;
    }
      
    return true;
  } // function
  
  /**
   * Called when user deletes a page.  
   * @param[inout] &$article the article that was deleted. WikiPage in MW >= 1.18, Article in 1.17.x and earlier.
   * @param[inout] &$user the user that deleted the article
   * @param[in] $reason the reason the article was deleted
   * @param[in] $id id of the article that was deleted (added in 1.13)
   * @return \bool true, continue hook processing
   * @since 2011-10-02, 0.2.1      
   * @see hook documentation http://www.mediawiki.org/wiki/Manual:Hooks/ArticleDeleteComplete
   * @note requires MediaWiki 1.4.0    
   * @note Occurs after the delete article request has been processed           
   */
  public static function hookArticleDeleteComplete(&$article, &$user, $reason, $id) {
    wfDebugLog('headersfooters', __METHOD__); 
  
    self::clearCache($article->getTitle());  
    return true;  
  } // function
  
  /**
   * Called when user edits, saves or moves an article.
   * @param[in] $article the article edited
   * @param[in] $rev the new revision
   * @param[in] $baseID the revision ID this was based off, if any. For example, for a rollback, this will be the rev_id that is being rolled back to.
   * @param[in] $user the revision author   
   * @return \bool true, continue hook processing
   * @since 2011-10-02, 0.2.1      
   * @see hook documentation http://www.mediawiki.org/wiki/Manual:Hooks/NewRevisionFromEditComplete
   * @note requires MediaWiki 1.13.0       
   * @note Called when a revision was inserted due to an edit.         
   */
  public static function hookNewRevisionFromEditComplete($article, $rev, $baseID, $user) {
    wfDebugLog('headersfooters', __METHOD__);
    
    $title = $article->getTitle();
       
    self::clearCache($title);
    return true;
  } // function
  
  /**
   * Called when a user undeletes a page.
   * @param[in] $title Title corresponding to the article restored
   * @param[in] $create Whether or not the restoration caused the page to be created (i.e. it didn't exist before)
   * @return \bool true, continue hook processing
   * @since 2011-10-02, 0.2.1      
   * @see hook documentation http://www.mediawiki.org/wiki/Manual:Hooks/ArticleUndelete
   * @note requires MediaWiki 1.9.1
   * @note When one or more revisions of an article are restored               
   */
  public static function hookArticleUndelete($title, $create) {
    wfDebugLog('headersfooters', __METHOD__);
    
    self::clearCache($title);
    return true;
  } // function
  
  /**
   * checks if we have a header or footer for an article given a presice extension url
   * @param[in] $name \string message partial name     
   * @since 2011-09-26, 0.1
   */
  protected static function doHFChecks($name) {
    global $wgHeadersFootersDuplicates;
      
    foreach(array('header','footer') as $type) {
      $path = strtoupper($type).'_PATH';
      $path = self::$$path; 
      $path = $name.'-'.$path; 
      
      // message doesn't exist
      if (function_exists('wfMessage') && !wfMessage( $path )->exists() ) {
        continue;
      }
           
      $content = wfMsgForContentNoTrans($path);
      
      if (!function_exists('wfMessage') && $content == '&lt;'.$path.'&gt;') {
        continue;
      }
           
      // don't check for duplicates, or don't add the same header/footer twice 
      if ($wgHeadersFootersDuplicates || !in_array($content,self::$$type)) {
        $var =& self::$$type;
        $var[] = $content;
      }
    } // foreach type
  }
} // class
