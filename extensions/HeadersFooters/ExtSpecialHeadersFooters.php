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
 * @since 2011-09-30, 0.2 
 * @note coding convention followed: http://www.mediawiki.org/wiki/Manual:Coding_conventions  
 */
 
if ( !defined( 'MEDIAWIKI' ) ) {
        die( 'This file is a MediaWiki extension, it is not a valid entry point' );
}

/**
 * @ingroup Extensions
 * @since 2011-09-30, 0.2
 */ 
class ExtSpecialHeadersFooters extends SpecialPage {
  
  /** 
   * constructor, inits our messages
   * @since 2011-09-30, 0.2
   */     
  public function __construct() {
    // ensure we only display the page to those who have the right
    parent::__construct( 'HeadersFooters' );
    
    // load our i18n messages
    wfLoadExtensionMessages('HeadersFooters');
  } // function
  
  /**
   * shows an HTML edit bar
   * @param[in] $out OutputPage page to add text to 
   * @param[in] $request WebRequest     
   * @returns \string html edit bar   
   * @since 2011-09-30, 0.2
   */
  protected function displayEditBlocks($out,$request) {
    global $wgScript,$wgTitle;
    
    $nl = "\n";
    
    $title = method_exists($out, 'getTitle') ? $out->getTitle() : $wgTitle;
    
    // global
    $output = Xml::openElement('form', array('action'=>$wgScript,'method'=>'get')).$nl;
    $output .= Xml::input( 'title', false, $title->getPrefixedText(), array('type'=>'hidden') ).$nl;
    $output .= Xml::openElement( 'fieldset' );
    $output .= Xml::element( 'legend', null, wfMsg('headersfooters-global') );
    $output .= Xml::radioLabel(wfMsg('headersfooters-header'),'global-type',ExtHeadersFooters::$HEADER_PATH,'global-type-header',($request->getVal('global-type',ExtHeadersFooters::$FOOTER_PATH)==ExtHeadersFooters::$HEADER_PATH)).$nl;
    $output .= Xml::radioLabel(wfMsg('headersfooters-footer'),'global-type',ExtHeadersFooters::$FOOTER_PATH,'global-type-footer',($request->getVal('global-type',ExtHeadersFooters::$FOOTER_PATH)==ExtHeadersFooters::$FOOTER_PATH)).Xml::element('br').$nl;
    $output .= Xml::submitButton(wfMsg('headersfooters-edit')).$nl;
    $output .= Xml::closeElement ('fieldset' ).$nl;        
    $output .= Xml::closeElement( 'form' ).$nl;    
    $out->addHTML($output);
    
    // namespace
    $output = Xml::openElement('form', array('action'=>$wgScript,'method'=>'get')).$nl;
    $output .= Xml::input( 'title', false, $title->getPrefixedText(), array('type'=>'hidden') ).$nl;
    $output .= Xml::openElement( 'fieldset' );
    $output .= Xml::element( 'legend', null, wfMsg('headersfooters-namespace') );
    $output .= Xml::namespaceSelector($request->getInt('namespace',NS_MAIN),null,'namespace-namespace',wfMsg('headersfooters-namespace')).Xml::element('br').$nl;
    $output .= Xml::radioLabel(wfMsg('headersfooters-header'), 'namespace-type', ExtHeadersFooters::$HEADER_PATH, 'namespace-type-header',($request->getVal('namespace-type',ExtHeadersFooters::$FOOTER_PATH)==ExtHeadersFooters::$HEADER_PATH)).$nl;
    $output .= Xml::radioLabel(wfMsg('headersfooters-footer'), 'namespace-type', ExtHeadersFooters::$FOOTER_PATH, 'namespace-type-footer',($request->getVal('namespace-type',ExtHeadersFooters::$FOOTER_PATH)==ExtHeadersFooters::$FOOTER_PATH)).Xml::element('br').$nl;
    $output .= Xml::submitButton(wfMsg('headersfooters-edit')).$nl;  
    $output .= Xml::closeElement ('fieldset' ).$nl;  
    $output .= Xml::closeElement('form').$nl;
    $out->addHTML($output);
    
    // category
    $output = Xml::openElement('form', array('action'=>$wgScript,'method'=>'get')).$nl;
    $output .= Xml::input( 'title', false, $title->getPrefixedText(), array('type'=>'hidden') ).$nl;
    $output .= Xml::openElement( 'fieldset' );
    $output .= Xml::element( 'legend', null, wfMsg('headersfooters-category') );
    $output .= Xml::inputLabel(wfMsg('headersfooters-category'), 'category-category','category-category',false,$request->getVal('category-category',false)).Xml::element('br').$nl;
    $output .= Xml::radioLabel(wfMsg('headersfooters-header'), 'category-type', ExtHeadersFooters::$HEADER_PATH, 'category-type-header',($request->getVal('category-type',ExtHeadersFooters::$FOOTER_PATH)==ExtHeadersFooters::$HEADER_PATH)).$nl;
    $output .= Xml::radioLabel(wfMsg('headersfooters-footer'), 'category-type', ExtHeadersFooters::$FOOTER_PATH, 'category-type-footer',($request->getVal('category-type',ExtHeadersFooters::$FOOTER_PATH)==ExtHeadersFooters::$FOOTER_PATH)).Xml::element('br').$nl;
    $output .= Xml::submitButton(wfMsg('headersfooters-edit')).$nl;
    $output .= Xml::closeElement ('fieldset' ).$nl;    
    $output .= Xml::closeElement('form').$nl; 
    $out->addHTML($output);
    
    // page
    $output = Xml::openElement('form', array('action'=>$wgScript,'method'=>'get')).$nl;
    $output .= Xml::input( 'title', false, $title->getPrefixedText(), array('type'=>'hidden') ).$nl;
    $output .= Xml::openElement( 'fieldset' );
    $output .= Xml::element( 'legend', null, wfMsg('headersfooters-page') );
    $output .= Xml::inputLabel(wfMsg('headersfooters-page'),'page-page', 'page-page',false,$request->getVal('page-page',false)).Xml::element('br').$nl;
    $output .= Xml::radioLabel(wfMsg('headersfooters-header'), 'page-type', ExtHeadersFooters::$HEADER_PATH, 'page-type-header',($request->getVal('page-type',ExtHeadersFooters::$FOOTER_PATH)==ExtHeadersFooters::$HEADER_PATH)).$nl;
    $output .= Xml::radioLabel(wfMsg('headersfooters-footer'), 'page-type', ExtHeadersFooters::$FOOTER_PATH, 'page-type-footer',($request->getVal('page-type',ExtHeadersFooters::$FOOTER_PATH)==ExtHeadersFooters::$FOOTER_PATH)).Xml::element('br').$nl;
    $output .= Xml::submitButton(wfMsg('headersfooters-edit')).$nl;   
    $output .= Xml::closeElement ('fieldset' ).$nl; 
    $output .= Xml::closeElement('form').$nl;   
    $out->addHTML($output);
  }        
  
  /**
   * entry point for the special page
   * @param[in] $par \string text after special page /   
   * @since 2011-09-30, 0.2   
   */
  public function execute($par) {
    global $wgOut,$wgRequest,$wgContLang,$wgUser;
    
    $out = $wgOut;
    
    $request = method_exists($out,'getRequest') ? $out->getRequest() : $wgRequest;
    $lang = method_exists($out, 'getLang') ? $out->getLang() : $wgContLang;
    
    $title = null;
    
    $out->addWikiText( wfMsgForContentNoTrans( 'headersfooterstext' ) );
    
    // global form submitted    
    $type = $request->getVal('global-type',null);
    if ($type !== null) {
      $title = Title::newFromText('MediaWiki:'.ExtHeadersFooters::$GLOBAL_PATH.'-'.$type);        
    } // global
    
    // namespace form submitted    
    $type = $request->getVal('namespace-type',null);
    if ($type !== null) {
      $ns = $request->getInt('namespace-namespace',NS_MAIN);
      $title = Title::newFromText('MediaWiki:'.ExtHeadersFooters::$NAMESPACE_PATH.'-'.$ns.'-'.$type);
    } // namespace
    
    // category form submitted    
    $type = $request->getVal('category-type',null);
    if ($type !== null) {
      $cat = trim($request->getVal('category-category',''));
      if ($cat !== '') {
        $catTitle = Title::newFromText($cat,NS_CATEGORY);        
        // we can setup before any pages belong to the category, and exists() would be if there is text on the cat page
        $title = Title::newFromText('MediaWiki:'.ExtHeadersFooters::$CATEGORY_PATH.'-'.$catTitle->getText().'-'.$type);        
      } else {
        $out->addHTML( Xml::tags( 'p', array( 'class' => 'error' ), wfMsg('headersfooters-error-page-blank') ) );
      } 
    } // category
    
    // page form submitted    
    $type = $request->getVal('page-type',null);
    if ($type !== null) {
      $page = trim($request->getVal('page-page',''));
      if ($page !== '') {
        $pageTitle = Title::newFromText($page);
        $ns = $pageTitle->getNamespace();
        if ($ns == NS_SPECIAL) {
          // limited special page header support
          // note that each individual special page has to follow the convention: <specialpagename>text
          
          if ($type == ExtHeadersFooters::$HEADER_PATH) {
            $path = strtolower($pageTitle->getText()).'text';
            
            // message doesn't exist
            $exists = true;
            if (function_exists('wfMessage') && wfMessage( $path )->exists() ) {
              // branch logic default true              
            } else if (!function_exists('wfMessage') && wfMsgForContentNoTrans($path) != '&lt;'.$path.'&gt;') {
              // branch logic default true
            } else {
              $exists = false;
            }
            
            if ($exists) {
              $title = Title::newFromText('MediaWiki:'.$path);
            } else {
              // msg doesn't exist
              $out->addHTML( Xml::tags( 'p', array( 'class' => 'error' ), wfMsg('headersfooters-error-specialpage-noheader') ) ); 
            }
          } else {
            // no footer support,
            $out->addHTML( Xml::tags( 'p', array( 'class' => 'error' ), wfMsg('headersfooters-error-specialpage-nofooters') ) );            
          }                          
        } elseif ($pageTitle->exists()) {                    
          $title = Title::newFromText('MediaWiki:'.ExtHeadersFooters::$PAGE_PATH.'-'.$ns.'-'.$pageTitle->getText().'-'.$type);        
        } else {          
          $out->addHTML( Xml::tags( 'p', array( 'class' => 'error' ), wfMsg('headersfooters-error-page-notfound') ) );
        }
      } else {
        $out->addHTML( Xml::tags( 'p', array( 'class' => 'error' ), wfMsg('headersfooters-error-page-blank') ) );
      }         
    } // page
    
    if ($title !== null) {
      $out->redirect( $title->getEditURL() );
      return;
    }
    
    // make our title appear
    $this->setHeaders();
    $this->outputHeader();    
     
    // no table of contents
    $out->addWikiText('__NOTOC__'.'__NOEDITSECTION__');
    $out->addWikiText(wfMsg('headersfooters-special-purpose')."\n"); 
       
    $this->displayEditBlocks($out,$request);    
  } // function
  
} // class
