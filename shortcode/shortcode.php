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

     ob_start();?>
     <style type="text/css">
     .sh-bild-img{width:100%}.sh-bild-btns a{display:inline-block;padding:7px 12px;margin:3px;font-size:12px;letter-spacing:2px;line-height:1;text-align:center;vertical-align:middle;cursor:pointer;background:transparent;color:#fff;border:1px solid #fff;border-radius:100px;text-decoration:none;text-transform:uppercase}.sh-bild-btns a:hover{background:#000}.sh-bild-btns h4{color:#fff}.sh-bild img{webkit-transform:scale3d(1,1,1);transform:scale3d(1,1,1);-webkit-transition:all 400ms;transition:all 400ms}.sh-bild-overlay{opacity:0}.sh-bild-overlay:hover{opacity:1}
     </style>
     <?php
     $styles = ob_get_contents();
     ob_get_clean();

     $doc =& JFactory::getDocument();
     $doc->addCustomTag( $styles );
   }

   function onContentPrepare( $context, &$article, &$params, $limitstart=0 )
   {
   $matches = array();

     //preg_match_all('/{bild url="' . $params->get('url') . '"}(.*?){\/bild}/is',$article->text, $matches);

     preg_match_all('/{bild url=(.*?)}{img=(.*?)}{tt=(.*?)}/is', $article->text, $matches);

     $i = 0;
     foreach ($matches[0] as $match) {

         $la1 = explode('url=', $match);
         $la = $la1[1];
         $url1 = explode('}', $la);
             $url = $url1[0];

         $im1 = explode('img=', $match);
         $im = $im1[1];
         $img1 = explode('}', $im);
              $img = $img1[0];

          $tt1 = explode('tt=', $match);
          $tt = $tt1[1];
          $t1 = explode('}', $tt);
               $t = $t1[0];


        // ------ Bild content  ------- //

        ob_start();
        ?>
      <div class="sh-bild" style="height: 400px;position: absolute;z-index: 1;top: 0px;left: 0px; visibility: visible;opacity: 1">
         <div class="sh-bild-overlay-wrapper clearfix" style="overflow: hidden">

        <img class="sh-bild-img" style="position: relative" src="<?php echo $img; ?>" alt="">

              <div class="sh-bild-overlay" style="/*background: rgba(0,0,0,0.4)*/;position: absolute;top:0;z-index: 2;width: 100%;height: auto">
                  <div class="sp-vertical-middle" style="width: 100%;height: 100%">
                    <div>
                      <div class="sh-bild-btns"  style="text-align:center;height:100%;padding-top: 20%;margin:5px">

        <a class="btn-view" style="margin: 0 auto" href="<?php echo $url;?>">View</a>
          <h4><?php echo $t; ?></h4>

                      </div>
                   </div>
                  </div>
                </div>
              </div>
            </div>


        <?php
        $done = ob_get_contents();
        ob_end_clean();


        // ------ Bild content  ------- //


      $article->text = str_replace($match, $done, $article->text);



    }//feach


   // Simple
   /*
   $shortcode = '[bild]';
   $sh_content = 'This replaces a shortcode';
   $article->text = str_replace( $shortcode, $sh_content, $article->text);
   */
       return true;
   }

 }
