<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  Content.MpaLangStrings
 *
 * @copyright   Copyright (C) 2017, MacPietsApps.net
 * @license     MIT License
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
 * Plugin that displays localised language strings inside content
 * This uses the {mpa-lang} syntax
 *
 * @package     Joomla.Plugin
 * @subpackage  Content.Mpalangstrings
 * @since       1.5
 */
class plgContentMpalangstrings extends JPlugin {

	/**
	 * Plugin that displays localised language strings inside content
	 *
	 * @param   string   $context   The context of the content being passed to the plugin.
	 * @param   object   &$article  The article object.  Note $article->text is also available
	 * @param   mixed    &$params   The article params
	 * @param   integer  $page      The 'page' number
	 *
	 * @return  mixed   true if there is an error. Void otherwise.
	 *
	 * @since   1.6
	 */
	public function onContentPrepare($context, &$article, &$params, $limitstart) {
		// Simple performance check to determine whether bot should process further
		if (strpos($article->text, 'mpa-lang') === false) {
			return true;
		}

		// Expression to search for Dxfaparse
		$regex = '/{mpa-lang(.*?)}/i';
		preg_match_all($regex, $article->text, $matches, PREG_SET_ORDER);

		// No matches, skip this
		if ($matches) {
			foreach ($matches as $match) {
				$found = trim($match[1]);
				$output = JText::_($found);

				$article->text = str_replace($match[0], $output, $article->text);
			}
		}
	}
}
