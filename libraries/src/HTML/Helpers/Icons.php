<?php
/**
 * Joomla! Content Management System
 *
 * @copyright  Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\CMS\HTML\Helpers;

\defined('JPATH_PLATFORM') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\FileLayout;
use Joomla\CMS\Uri\Uri;
use Joomla\Filesystem\Path;
use Joomla\Utilities\ArrayHelper;

/**
 * Utility class for icons.
 *
 * @since  2.5
 */
abstract class Icons
{
	/**
	 * Method to generate html code for a list of buttons
	 *
	 * @param   array  $buttons  Array of buttons
	 *
	 * @return  string
	 *
	 * @since   2.5
	 */
	public static function buttons($buttons)
	{
		if (empty($buttons))
		{
			return '';
		}

		$html = array();

		foreach ($buttons as $button)
		{
			$html[] = HTMLHelper::_('icons.button', $button);
		}

		return implode($html);
	}

	/**
	 * Method to generate html code for a list of buttons
	 *
	 * @param   array  $button  Button properties
	 *
	 * @return  string
	 *
	 * @since   2.5
	 */
	public static function button($button)
	{
		if (isset($button['access']))
		{
			if (is_bool($button['access']))
			{
				if ($button['access'] == false)
				{
					return '';
				}
			}
			else
			{
				// Get the user object to verify permissions
				$user = Factory::getUser();

				// Take each pair of permission, context values.
				for ($i = 0, $n = count($button['access']); $i < $n; $i += 2)
				{
					if (!$user->authorise($button['access'][$i], $button['access'][$i + 1]))
					{
						return '';
					}
				}
			}
		}

		// Instantiate a new FileLayout instance and render the layout
		$layout = new FileLayout('joomla.quickicons.icon');

		return $layout->render($button);
	}

	/**
	 * Writes an inline '<svg>' element
	 *
	 * @param   string   $file      The relative or absolute PATH to use for the src attribute.
	 * @param   boolean  $relative  Flag if the path to the file is relative to the /media folder (and searches in template).
	 *
	 * @return  string|null
	 *
	 * @since   4.0
	 */
	public static function svg(string $file, bool $relative = true): ?string
	{
		// Check extension for .svg
		$extension = strtolower(substr($file, -4));

		if ($extension !== '.svg')
		{
			return null;
		}

		// Get path to icon
		$file = HTMLHelper::_('image', $file, '', '', $relative, true);

		// Make sure path is local to Joomla
		$file = Path::check(JPATH_ROOT . '/' . substr($file, \strlen(Uri::root(true))));

		// If you can't find the icon or if it's unsafe then skip it
		if (!$file)
		{
			return null;
		}

		// Get contents to display inline
		$file = file_get_contents($file);

		return $file;
	}

	/**
	 * Method to write a `<span>` element for an icon
	 *
	 * @param   string  $icon     The functional name for an icon.
	 * @param   array   $attribs  Attributes to be added to the wrapping element
	 *
	 * @return  string
	 *
	 * @throws  \InvalidArgumentException
	 *
	 * @since   __DEPLOY_VERSION__
	 */
	public static function icon(string $icon, array $attribs = []): string
	{
		if ($icon === '')
		{
			throw new \InvalidArgumentException(Text::_('JLIB_HTML_ICONS_NO_ICON'));
		}

		$class = $icon;

		if (isset($attribs['class']))
		{
			$class .= ' ' . $attribs['class'];
		}

		$attribs['class'] = $class;

		if (!isset($attribs['aria-hidden']))
		{
			$attribs['aria-hidden'] = 'true';
		}

		if (isset($attribs['text']))
		{
			$text = htmlspecialchars($attribs['text'], ENT_COMPAT, 'UTF-8');
			$text = '<span class="sr-only">' . $text . '</span>';
			unset($attribs['text']);
		}

		$output = '<span ' . ArrayHelper::toString($attribs) . '></span>';

		if (isset($attribs['svg']))
		{
			$provider = $attribs['svg']['provider'] ?? 'fontawesome-free';
			$group    = $attribs['svg']['group'] ?? 'regular';
			$path     = '/media/vendor/' . $provider . '/svgs/' . $group;
			$output   = HTMLHelper::_('icons.svg', $icon . '.svg', $path);
		}

		return $output . $text;
	}
}
