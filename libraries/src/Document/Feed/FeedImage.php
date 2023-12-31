<?php

/**
 * Joomla! Content Management System
 *
 * @copyright  (C) 2017 Open Source Matters, Inc. <https://www.joomla.org>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\CMS\Document\Feed;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * Data object representing a feed image
 *
 * @since  1.7.0
 */
class FeedImage
{
    /**
     * Title image attribute
     *
     * required
     *
     * @var    string
     * @since  1.7.0
     */
    public $title = '';

    /**
     * URL image attribute
     *
     * required
     *
     * @var    string
     * @since  1.7.0
     */
    public $url = '';

    /**
     * Link image attribute
     *
     * required
     *
     * @var    string
     * @since  1.7.0
     */
    public $link = '';

    /**
     * Width image attribute
     *
     * optional
     *
     * @var    string
     * @since  1.7.0
     */
    public $width;

    /**
     * Title feed attribute
     *
     * optional
     *
     * @var    string
     * @since  1.7.0
     */
    public $height;

    /**
     * Title feed attribute
     *
     * optional
     *
     * @var    string
     * @since  1.7.0
     */
    public $description;
}
