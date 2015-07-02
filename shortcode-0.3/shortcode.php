<?php
/**
 * @package     Shortcode
 * @subpackage  plg_shortcode
 * @license     GNU General Public License version 2 or later.
 * More
 * @link http://cocoate.com/jdev/plugin
 * @link http://learnwebtutorials.com/tutorial-creating-joomla-3-plugin
 * Namespace
 * @see plgContentShortcode, xml file
 */

 defined('_JEXEC') or die;

 class plgContentShortcode extends JPlugin
 {
   protected $autoloadLanguage = true;

   function onBeforeCompileHead( ){
     // styles to be flushed right before the end of head
     // rest of the styles in media
     ob_start();?>
     <style type="text/css">
     .clearfix {content:"";clear:both}.sh-bild-img{width:100%;transition: all .2s ease-in-out}.sh-bild:hover .sh-bild-img{transform:scale(1.2)}
     .sh-bild-btns a{display:inline-block;padding:7px 12px;margin:3px;font-size:12px;letter-spacing:2px;line-height:1;text-align:center;vertical-align:middle;
     cursor:pointer;background:transparent;color:#fff;border:1px solid #fff;border-radius:100px;text-decoration:none;text-transform:uppercase;
     -webkit-transform: scale3d(0, 0, 0);transform: scale3d(0, 0, 0);-webkit-transition: all 400ms;transition: all 400ms;}
     .sh-bild-btns a:hover{background:#000;border:1px solid black}
     .sh-bild-btns:hover a{-webkit-transform: scale3d(0, 0, 0); transform: scale3d(1,1,1); -webkit-transition: all 400ms; transition: all 400ms;}
     .sh-bild-btns h4{opacity:0;color:#fff;-webkit-transform: translate3d(0, 15px, 0);transform: translate3d(0, 15px, 0);-webkit-transition: all 400ms;transition: all 400ms;}
     .sh-bild-btns:hover h4{opacity:1;-webkit-transform:translate3d(0, 0, 0);transform:translate3d(0, 0, 0)}
     .sh-bild img{webkit-transform:scale3d(1,1,1);transform:scale3d(1,1,1);-webkit-transition:all 400ms;transition:all 400ms}.sh-bild-overlay{opacity:0}.sh-bild-overlay:hover{opacity:1}
     </style>
     <?php
     $styles = ob_get_contents();
     ob_get_clean();

     $doc =& JFactory::getDocument();
     $doc->addCustomTag( $styles );
   }

   function onContentPrepare( $context, &$article, &$params, $limitstart=0 )
   {
   // 4 different functionalities - place to add more
   $matches = array(); //matches view
   $matchesb = array(); // matches beide
   $matchesz = array(); //matches zoom
   $iframe = array(); //matches iframe

     preg_match_all('/{bild url=(.*?)}{img=(.*?)}{tt=(.*?)}/is', $article->text, $matches);
     preg_match_all('/{beide url=(.*?)}{img=(.*?)}{tt=(.*?)}/is', $article->text, $matchesb);
     preg_match_all('/{zoom url=(.*?)}{img=(.*?)}{tt=(.*?)}/is', $article->text, $matchesz);


foreach ($matches[0] as $match) {
  $url = $this->parserUrl($match);
  $img = $this->parserImg($match);
  $t = $this->parserTitle($match);
    ob_start();
  $this->template($img, $url, $t, FALSE, TRUE);
   $done = ob_get_contents();
    ob_end_clean();
  $article->text = str_replace($match, $done, $article->text);
}//feach view

//matches beide
foreach ($matchesb[0] as $match) {
  $url = $this->parserUrl($match);
  $img = $this->parserImg($match);
  $t = $this->parserTitle($match);
    ob_start();
  $this->template($img, $url, $t, TRUE, TRUE);
   $done = ob_get_contents();
    ob_end_clean();
  $article->text = str_replace($match, $done, $article->text);
}//feach beide

//matches zoom
foreach ($matchesz[0] as $match) {
  $url = $this->parserUrl($match);
  $img = $this->parserImg($match);
  $t = $this->parserTitle($match);
  ob_start();
$this->template($img, $url, $t, TRUE, FALSE);
 $done = ob_get_contents();
  ob_end_clean();
$article->text = str_replace($match, $done, $article->text);
}//feach zoom

//iframe stuff
if ( preg_match_all('/{iframe url=(.*?)}{img=(.*?)}{tt=(.*?)}/is', $article->text, $iframe) ) {
       //matches ifr
       foreach ($iframe[0] as $match) {
         $url = $this->parserUrl($match);
         $img = $this->parserImg($match);
         $t = $this->parserTitle($match);
           ob_start();
         $this->temp_ifr($img, $url, $t);
          $done = ob_get_contents();
           ob_end_clean();
         $article->text = str_replace($match, $done, $article->text);
       }//feach ifr
}//pregm

  return true;

   }

public function parserUrl($match) {

    $la1 = explode('url=', $match);
    $la = $la1[1];
    $url1 = explode('}', $la);
        $url = $url1[0];
        return $url;
      } // url
public function parserImg($match) {

    $im1 = explode('img=', $match);
    $im = $im1[1];
    $img1 = explode('}', $im);
         $img = $img1[0];
         return $img;
     } // img
public function parserTitle($match) {

     $tt1 = explode('tt=', $match);
     $tt = $tt1[1];
     $t1 = explode('}', $tt);
          $t = $t1[0];
          return $t;
    } // title

// template with zoom to image and view to external page
public function template($img, $url, $t, $zoom, $view){
  ?>
   <div class="clearfix"></div>
    <div class="sh-bild" style="height:auto;position:relative;z-index: 1;top: 0px;left: 0px; visibility: visible;opacity: 1">
      <div class="sh-bild-overlay-wrapper clearfix" style="overflow: hidden">
       <img class="sh-bild-img" style="position: relative" src="<?php echo $img; ?>" alt="">
         <div class="sh-bild-overlay" style="position: absolute;top:0;z-index:2;width:100%;height:auto">
           <div class="sp-vertical-middle" style="width: 100%;height: 100%">
             <div>
              <div class="sh-bild-btns"  style="text-align: center; height: 100%; padding-top: 14px; background: rgba(0,0,0,0.5); margin-top: 17%;">
<?php if ( $zoom != FALSE ) {?>
                 <a class="btn-zoom" href="<?php echo $img; ?>" data-featherlight="image">Zoom</a>
                 <?php }?>
               	&nbsp;
<?php if ( $view != FALSE ) { ?>
                 <a class="btn-view" style="margin: 0 auto" href="<?php echo $url;?>">View</a>
                 <?php }?>
                  <h4><?php echo $t; ?></h4>
                 </div>
              </div>
           </div>
         </div>
       </div>
     </div>
  <?php
}
/**
// template with zoom leading to lightbox iframe
// Joomla hack:
// Appended to url: &tmpl=component&print=1&layout=default&page=
// will prepare the content for Print, hereby removes header and footer section
// makes it possible to make iframe content as regular article or SP Page Builder Page
// -- easy to edit by non-tech people
* TO DO - With menu links / external links?
// As the page has no menu link, the URL will be in form: http://example.com/index.php?option=com_sppagebuilder&view=page&id=39
// as it already has queries, a query starting with & is appended
**/
public function temp_ifr($img, $url, $t){
  ?>
   <div class="clearfix"></div>
    <div class="sh-bild" style="height:auto;position:relative;z-index: 1;top: 0px;left: 0px; visibility: visible;opacity: 1">
      <div class="sh-bild-overlay-wrapper clearfix" style="overflow: hidden">
       <img class="sh-bild-img" style="position: relative" src="<?php echo $img; ?>" alt="">
         <div class="sh-bild-overlay" style="position: absolute;top:0;z-index:2;width:100%;height:auto">
           <div class="sp-vertical-middle" style="width: 100%;height: 100%">
             <div>
              <div class="sh-bild-btns"  style="text-align: center; height: 100%; padding-top: 14px; background: rgba(0,0,0,0.5); margin-top: 17%;">
                  <a class="btn-zoom" href="#" data-featherlight="#<?php echo $t; ?>">Zoom</a>
                  <h4><?php echo $t; ?></h4>
                 </div>
              </div>
           </div>
         </div>
       </div>
     </div>
     <div style="display:none">
     <iframe class="lightbox" src="<?php echo $url; ?>&tmpl=component&print=1&layout=default&page="  width="700" height="600" id="<?php echo $t; ?>" style="border:none;padding-top:20px;" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen=""></iframe>
     </div>
  <?php
}//template iframe



 }
