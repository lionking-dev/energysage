<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\Utilities\ArrayHelper;

extract($displayData);

/**
 * Layout variables
 * ------------------
 * @param   string  $selector  Unique DOM identifier for the modal. CSS id without #
 * @param   array   $params    Modal parameters. Default supported parameters:
 *                             - title        string   The modal title
 *                             - backdrop     mixed    A boolean select if a modal-backdrop element should be included (default = true)
 *                                                     The string 'static' includes a backdrop which doesn't close the modal on click.
 *                             - keyboard     boolean  Closes the modal when escape key is pressed (default = true)
 *                             - closeButton  boolean  Display modal close button (default = true)
 *                             - animation    boolean  Fade in from the top of the page (default = true)
 *                             - url          string   URL of a resource to be inserted as an <iframe> inside the modal body
 *                             - height       string   height of the <iframe> containing the remote resource
 *                             - width        string   width of the <iframe> containing the remote resource
 *                             - bodyHeight   int      Optional height of the modal body in viewport units (vh)
 *                             - modalWidth   int      Optional width of the modal in viewport units (vh)
 *                             - footer       string   Optional markup for the modal footer
 * @param   string  $body      Markup for the modal body. Appended after the <iframe> if the URL option is set
 *
 */

$modalClasses = array('modal');

if (!isset($params['animation']) || $params['animation'])
{
	$modalClasses[] = 'fade';
}

$modalWidth       = isset($params['modalWidth']) ? round((int) $params['modalWidth'], -1) : '';
$modalDialogClass = '';

if ($modalWidth && $modalWidth > 0 && $modalWidth <= 100)
{
	$modalDialogClass = ' jviewport-width' . $modalWidth;
}

$modalAttributes = array(
	'tabindex' => '-1',
	'class'    => 'joomla-modal ' .implode(' ', $modalClasses)
);

if (isset($params['backdrop']))
{
	$modalAttributes['data-backdrop'] = (is_bool($params['backdrop']) ? ($params['backdrop'] ? 'true' : 'false') : $params['backdrop']);
}

if (isset($params['keyboard']))
{
	$modalAttributes['data-keyboard'] = (is_bool($params['keyboard']) ? ($params['keyboard'] ? 'true' : 'false') : 'true');
}

if (isset($params['url']))
{
	$url        = 'data-url="' . $params['url'] . '"';
	$iframeHtml = htmlspecialchars(LayoutHelper::render('joomla.modal.iframe', $displayData), ENT_COMPAT, 'UTF-8');
}
$script[] = "jQuery(document).ready(function($) {";
$script[] = "   $('#" . $selector . "').on('show.bs.modal', function() {";

$script[] = "       $('body').addClass('modal-open');";

if (isset($params['url']))
{
	$iframeHtmlModal = JLayoutHelper::render('joomla.modal.iframe', $displayData);

	// Script for destroying and reloading the iframe
	$script[] = "       var modalBody = $(this).find('.modal-body');";
	$script[] = "       modalBody.find('iframe').remove();";
	$script[] = "       modalBody.prepend('" . trim($iframeHtmlModal) . "');";
}
else
{
	// Set modalTooltip container to modal ID (selector), and placement to top-left if no data attribute (bootstrap-tooltip-extended.js)
	$script[] = "       $('.modalTooltip').each(function(){;";
	$script[] = "           var attr = $(this).attr('data-placement');";
	$script[] = "           if ( attr === undefined || attr === false ) $(this).attr('data-placement', 'auto-dir top-left')";
	$script[] = "       });";
	$script[] = "       $('.modalTooltip').tooltip({'html': true, 'container': '#" . $selector . "'});";
}

// Adapt modal body max-height to window viewport if needed, when the modal has been made visible to the user.
$script[] = "   }).on('shown.bs.modal', function() {";

// Get height of the modal elements.
$script[] = "       var modalHeight = $('div.modal:visible').outerHeight(true),";
$script[] = "           modalHeaderHeight = $('div.modal-header:visible').outerHeight(true),";
$script[] = "           modalBodyHeightOuter = $('div.modal-body:visible').outerHeight(true),";
$script[] = "           modalBodyHeight = $('div.modal-body:visible').height(),";
$script[] = "           modalFooterHeight = $('div.modal-footer:visible').outerHeight(true),";

// Get padding top (jQuery position().top not working on iOS devices and webkit browsers, so use of Javascript instead)
$script[] = "           padding = document.getElementById('" . $selector . "').offsetTop,";

// Calculate max-height of the modal, adapted to window viewport height.
$script[] = "           maxModalHeight = ($(window).height()-(padding*2)),";

// Calculate max-height for modal-body.
$script[] = "           modalBodyPadding = (modalBodyHeightOuter-modalBodyHeight),";
$script[] = "           maxModalBodyHeight = maxModalHeight-(modalHeaderHeight+modalFooterHeight+modalBodyPadding);";

if (isset($params['url']))
{
	// Set max-height for iframe if needed, to adapt to viewport height.
	$script[] = "       var iframeHeight = $('.iframe').height();";
	$script[] = "       if (iframeHeight > maxModalBodyHeight){;";
	$script[] = "           $('.modal-body').css({'max-height': maxModalBodyHeight, 'overflow-y': 'auto'});";
	$script[] = "           $('.iframe').css('max-height', maxModalBodyHeight-modalBodyPadding);";
	$script[] = "       }";
}
else
{
	// Set max-height for modal-body if needed, to adapt to viewport height.
	$script[] = "       if (modalHeight > maxModalHeight){;";
	$script[] = "           $('.modal-body').css({'max-height': maxModalBodyHeight, 'overflow-y': 'auto'});";
	$script[] = "       }";
}

$script[] = "   }).on('hide.bs.modal', function () {";
$script[] = "       $('body').removeClass('modal-open');";
$script[] = "       $('.modal-body').css({'max-height': 'initial', 'overflow-y': 'initial'});";
$script[] = "       $('.modalTooltip').tooltip('destroy');";
$script[] = "   });";
$script[] = "});";
if(\T4\Helper\J3J4::major() < 4){
	Factory::getDocument()->addScriptDeclaration(implode("\n", $script));
}
?>
<div id="<?php echo $selector; ?>" role="dialog" <?php echo ArrayHelper::toString($modalAttributes); ?> <?php echo $url ?? ''; ?> <?php echo isset($url) ? 'data-iframe="'.trim($iframeHtml).'"' : ''; ?>>
	<div class="modal-dialog modal-lg<?php echo $modalDialogClass; ?>" role="document">
		<div class="modal-content">
			<?php
				// Header
				if (!isset($params['closeButton']) || isset($params['title']) || $params['closeButton'])
				{
					echo LayoutHelper::render('joomla.modal.header', $displayData);
				}

				// Body
				echo LayoutHelper::render('joomla.modal.body', $displayData);

				// Footer
				if (isset($params['footer']))
				{
					echo LayoutHelper::render('joomla.modal.footer', $displayData);
				}
			?>
		</div>
	</div>
</div>
