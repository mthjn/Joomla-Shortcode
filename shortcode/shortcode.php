<?php
/**
 * @package     Shortcode
 * @subpackage  plg_shortcode
 * @license     GNU General Public License version 2 or later.
 */
 defined('_JEXEC') or die;

 require_once('shortcode_helpers.php');
 require_once('shortcode_view.php');

 class plgContentShortcode extends JPlugin
 {
   protected $autoloadLanguage = true;

   function onBeforeCompileHead( )
   {
     ob_start();?>
      <style type="text/css">.clearfix{content:"";clear:both}.sh-bild-img{width:100%;transition:all .2s ease-in-out}.sh-bild:hover .sh-bild-img{transform:scale(1.2)}.sh-bild-btns a{display:inline-block;padding:7px 12px;margin:3px;font-size:12px;letter-spacing:2px;line-height:1;text-align:center;vertical-align:middle;cursor:pointer;background:transparent;color:#fff;border:1px solid #fff;border-radius:100px;text-decoration:none;text-transform:uppercase;-webkit-transform:scale3d(0,0,0);transform:scale3d(0,0,0);-webkit-transition:all 400ms;transition:all 400ms}.sh-bild-btns a:hover{background:#000;border:1px solid #000}.sh-bild-btns:hover a{-webkit-transform:scale3d(0,0,0);transform:scale3d(1,1,1);-webkit-transition:all 400ms;transition:all 400ms}.sh-bild-btns h4{opacity:0;color:#fff;-webkit-transform:translate3d(0,15px,0);transform:translate3d(0,15px,0);-webkit-transition:all 400ms;transition:all 400ms}.sh-bild-btns:hover h4{opacity:1;-webkit-transform:translate3d(0,0,0);transform:translate3d(0,0,0)}.sh-bild img{webkit-transform:scale3d(1,1,1);transform:scale3d(1,1,1);-webkit-transition:all 400ms;transition:all 400ms}.sh-bild-overlay{opacity:0}.sh-bild-overlay:hover{opacity:1}</style>
      <?php
     $styles = ob_get_contents();
     ob_get_clean();
      $doc =& JFactory::getDocument();
       $doc->addCustomTag( $styles );
   }//ON BEFORECOMP header

   function onContentPrepare( $context, &$article, &$params, $limitstart=0 )
   {
   $matches = array(); //matches view
   $matchesb = array(); // matches beide
   $matchesz = array(); //matches zoom
   $iframe = array(); //matches iframe
     preg_match_all('/{bild url=(.*?)}{img=(.*?)}{tt=(.*?)}/is', $article->text, $matches);
     preg_match_all('/{beide url=(.*?)}{img=(.*?)}{tt=(.*?)}/is', $article->text, $matchesb);
     preg_match_all('/{zoom url=(.*?)}{img=(.*?)}{tt=(.*?)}/is', $article->text, $matchesz);
     preg_match_all('/{iframe url=(.*?)}{img=(.*?)}{tt=(.*?)}/is', $article->text, $iframe);

    // helpers here

   $shortcodeHelpers = new shortcodeHelpers();
   $shortcodeHelpers->shortcodeHelperIframe();
   $shortcodeHelpers->shortcodeHelperView();
   $shortcodeHelpers->shortcodeHelperBeide();
   $shortcodeHelpers->shortcodeHelperZoom();


    // --- view
   $shortcodeView = new shortcodeView();
   $shortcodeView->shortcodeViewRegular($img, $url, $t, $zoom, $view);
   $shortcodeView->shortcodeViewIframe($img, $url, $t, $dataid);


  }//ON CONTENT PREPARE
 }
