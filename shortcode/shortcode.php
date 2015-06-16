<?php
/**
 * @package     Shortcode
 * @subpackage  plg_shortcode
 *
 * @license     GNU General Public License version 2 or later.
 */

defined('_JEXEC') or die;

class plgContentShortcode extends JPlugin
{
  protected $autoloadLanguage = true;

  function onContentPrepare( $context, $article, $params, $limitstart )
  {
    $article->text = str_replace('[bild]', 'This replaces the shortcode', $article->text);
      return true;
  }

}
