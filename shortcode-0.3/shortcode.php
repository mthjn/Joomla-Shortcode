<?php
/**
 * @package     Shortcode
 * @subpackage  plg_shortcode
 * @license     GNU General Public License version 2 or later.
 * @see         helpers and view. to make it really MVC com is needed.
 */

 defined('_JEXEC') or die;

 class plgContentShortcode extends JPlugin
 {
   protected $autoloadLanguage = true;
   function onBeforeCompileHead( )
   {
     //change or add link to your file
     $this->getStyles();
   }
   function onContentPrepare( $context, &$article, &$params, $limitstart=0 )
   {
     // check to determine whether text should be processed further
     if (strpos($article->text, 'iframe url') === false && strpos($article->text, 'bild url') === false && strpos($article->text, 'beide url') === false  && strpos($article->text, 'zoom url') === false) {
       return true;
     }
     //add yours
     $this->doParseIframe( $article );
     $this->doParseView( $article );
     $this->doParseBeide( $article );
     $this->doParseZoom( $article );
     return true;
   }

// -- helpers -- //

    public function doParseIframe( &$article ) {
      $iframe = array();
      preg_match_all('/{iframe url=(.*?)}{img=(.*?)}{tt=(.*?)}/is', $article->text, $iframe);
      foreach ($iframe[0] as $match) {
        $url = $this->parserUrl($match);
          $img = $this->parserImg($match);
            $t = $this->parserTitle($match);
              $dataid = $this->getRandString($t);
        ob_start();
          $this->viewIframe($img, $url, $t, $dataid);
          $done = ob_get_contents();
        ob_end_clean();
        $article->text = str_replace($match, $done, $article->text);
      }//feach ifr
    }

    public function doParseView( &$article ) {
      $matches = array();
      preg_match_all('/{bild url=(.*?)}{img=(.*?)}{tt=(.*?)}/is', $article->text, $matches);
      foreach ($matches[0] as $match) {
        $url = $this->parserUrl($match);
          $img = $this->parserImg($match);
            $t = $this->parserTitle($match);
          ob_start();
            $this->viewNormal($img, $url, $t, FALSE, TRUE);
            $done = ob_get_contents();
          ob_end_clean();
        $article->text = str_replace($match, $done, $article->text);
      }
    }
    public function doParseBeide( &$article ) {
      $matchesb = array();
      preg_match_all('/{beide url=(.*?)}{img=(.*?)}{tt=(.*?)}/is', $article->text, $matchesb);
      foreach ($matchesb[0] as $match) {
        $url = $this->parserUrl($match);
          $img = $this->parserImg($match);
            $t = $this->parserTitle($match);
          ob_start();
          $this->viewNormal($img, $url, $t, TRUE, TRUE);
          $done = ob_get_contents();
          ob_end_clean();
        $article->text = str_replace($match, $done, $article->text);
      }
    }
    public function doParseZoom( &$article ) {
      $matchesz = array();
      preg_match_all('/{zoom url=(.*?)}{img=(.*?)}{tt=(.*?)}/is', $article->text, $matchesz);
      foreach ($matchesz[0] as $match) {
        $url = $this->parserUrl($match);
          $img = $this->parserImg($match);
            $t = $this->parserTitle($match);
        ob_start();
          $this->viewNormal($img, $url, $t, TRUE, FALSE);
          $done = ob_get_contents();
        ob_end_clean();
      $article->text = str_replace($match, $done, $article->text);
      }
    }
      public function parserUrl($match) {
          $la1 = explode('url=', $match);
          $la = $la1[1];
          $url1 = explode('}', $la);
              $url = $url1[0];
              return $url;
            }
      public function parserImg($match) {
          $im1 = explode('img=', $match);
          $im = $im1[1];
          $img1 = explode('}', $im);
               $img = $img1[0];
               return $img;
           }
      public function parserTitle($match) {
           $tt1 = explode('tt=', $match);
           $tt = $tt1[1];
           $t1 = explode('}', $tt);
                $t = $t1[0];
                return $t;
          }
      public function getRandString( $t ) {
         $toAppend = substr( "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ" ,mt_rand( 0 ,50 ) ,1 ) .substr( md5( time() ), 1);
         $dataid = "lightbox" . $toAppend;
          return $dataid;
      }

// --- view -- //

          public function getStyles(){
            ob_start();?>
            <style type="text/css">.clearfix{content:"";clear:both}.sh-bild-img{width:100%;transition:all .2s ease-in-out}.sh-bild:hover .sh-bild-img{transform:scale(1.2)}.sh-bild-btns a{display:inline-block;padding:7px 12px;margin:3px;font-size:12px;letter-spacing:2px;line-height:1;text-align:center;vertical-align:middle;cursor:pointer;background:transparent;color:#fff;border:1px solid #fff;border-radius:100px;text-decoration:none;text-transform:uppercase;-webkit-transform:scale3d(0,0,0);transform:scale3d(0,0,0);-webkit-transition:all 400ms;transition:all 400ms}.sh-bild-btns a:hover{background:#000;border:1px solid #000}.sh-bild-btns:hover a{-webkit-transform:scale3d(0,0,0);transform:scale3d(1,1,1);-webkit-transition:all 400ms;transition:all 400ms}.sh-bild-btns h4{opacity:0;color:#fff;-webkit-transform:translate3d(0,15px,0);transform:translate3d(0,15px,0);-webkit-transition:all 400ms;transition:all 400ms}.sh-bild-btns:hover h4{opacity:1;-webkit-transform:translate3d(0,0,0);transform:translate3d(0,0,0)}.sh-bild img{webkit-transform:scale3d(1,1,1);transform:scale3d(1,1,1);-webkit-transition:all 400ms;transition:all 400ms}.sh-bild-overlay{opacity:0}.sh-bild-overlay:hover{opacity:1}</style>
            <?php
            $styles = ob_get_contents();
            ob_get_clean();

            $doc =& JFactory::getDocument();
            $doc->addCustomTag( $styles );
          }

          public function viewNormal($img, $url, $t, $zoom, $view){
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
          }//template

          public function viewIframe($img, $url, $t, $dataid){
            ?>
             <div class="clearfix"></div>
              <div class="sh-bild" style="height:auto;position:relative;z-index: 1;top: 0px;left: 0px; visibility: visible;opacity: 1">
                <div class="sh-bild-overlay-wrapper clearfix" style="overflow: hidden">
                 <img class="sh-bild-img" style="position: relative" src="<?php echo $img; ?>" alt="">
                   <div class="sh-bild-overlay" style="position: absolute;top:0;z-index:2;width:100%;height:auto">
                     <div class="sp-vertical-middle" style="width: 100%;height: 100%">
                       <div>
                        <div class="sh-bild-btns"  style="text-align: center; height: 100%; padding-top: 14px; background: rgba(0,0,0,0.5); margin-top: 17%;">
                            <a class="btn-zoom" href="#" data-featherlight="#<?php echo $dataid; ?>">Zoom</a>
                            <h4><?php echo $t; ?></h4>
                           </div>
                        </div>
                     </div>
                   </div>
                 </div>
               </div>
               <div style="display:none">
               <iframe class="lightbox" src="<?php echo $url; ?>&tmpl=component&print=1&layout=default&page="
                 width="700" height="600" id="<?php echo $dataid; ?>"
                  style="border:none;padding-top:20px;"
                  webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen=""></iframe>
               </div>
            <?php
          }//template iframe




 }// class end
