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

$data = $displayData;
?>
<div class="alert alert-info">
	<?php echo HTMLHelper::_('icon', 'fas fa-info-circle', Text::_('INFO')); ?>
	<?php echo $data['options']['noResultsText']; ?>
</div>
