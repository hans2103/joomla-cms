<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

?>
<div class="alert alert-info">
	<?php echo HTMLHelper::_('icons.icon', 'icon-info-circle', Text::_('INFO')); ?>
	<?php echo $displayData['options']['noResultsText']; ?>
</div>
