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

//jimport('joomla.plugin.plugin');


class plgContentShortcode extends JPlugin
{
  protected $autoloadLanguage = true;

  function onContentPrepare( $context, &$article, &$params, $limitstart=0 )
  {
/*
    preg_match_all('/{bild url="' . $params->get('url') . '"}(.*?){\/bild}/is', $article->text, $matches);
    $i = 0;
    foreach ($matches[0] as $match) {
     $done = $matches[1][$i];
     $article->text = str_replace($match, $done, $article->text);
    }
*/

  // Simple
  $shortcode = '[bild]';
  $sh_content = 'This replaces a shortcode';
  $article->text = str_replace( $shortcode, $sh_content, $article->text);

      return true;
  }

}
