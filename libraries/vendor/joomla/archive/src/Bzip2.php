<?php

/**
 * Part of the Joomla Framework Archive Package
 *
 * @copyright  Copyright (C) 2005 - 2021 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Archive;

use Joomla\Filesystem\File;
use Joomla\Filesystem\Stream;

/**
 * Bzip2 format adapter for the Archive package
 *
 * @since  1.0
 */
class Bzip2 implements ExtractableInterface
{
    /**
     * Bzip2 file data buffer
     *
     * @var    string
     * @since  1.0
     */
    private $data;

    /**
     * Holds the options array.
     *
     * @var    array|\ArrayAccess
     * @since  1.0
     */
    protected $options = [];

    /**
     * Create a new Archive object.
     *
     * @param   array|\ArrayAccess  $options  An array of options
     *
     * @since   1.0
     * @throws  \InvalidArgumentException
     */
    public function __construct($options = [])
    {
        if (!\is_array($options) && !($options instanceof \ArrayAccess)) {
            throw new \InvalidArgumentException(
                'The options param must be an array or implement the ArrayAccess interface.'
            );
        }

        $this->options = $options;
    }

    /**
     * Extract a Bzip2 compressed file to a given path
     *
     * @param   string  $archive      Path to Bzip2 archive to extract
     * @param   string  $destination  Path to extract archive to
     *
     * @return  boolean  True if successful
     *
     * @since   1.0
     * @throws  \RuntimeException
     */
    public function extract($archive, $destination)
    {
        $this->data = null;

        if (!isset($this->options['use_streams']) || $this->options['use_streams'] == false) {
            // Old style: read the whole file and then parse it
            $this->data = file_get_contents($archive);

            if (!$this->data) {
                throw new \RuntimeException('Unable to read archive');
            }

            $buffer = bzdecompress($this->data);
            unset($this->data);

            if (empty($buffer)) {
                throw new \RuntimeException('Unable to decompress data');
            }

            if (!File::write($destination, $buffer)) {
                throw new \RuntimeException('Unable to write archive to file ' . $destination);
            }
        } else {
            // New style! streams!
            $input = Stream::getStream();

            // Use bzip
            $input->set('processingmethod', 'bz');

            if (!$input->open($archive)) {
                throw new \RuntimeException('Unable to read archive');
            }

            $output = Stream::getStream();

            if (!$output->open($destination, 'w')) {
                $input->close();

                throw new \RuntimeException('Unable to open file "' . $destination . '" for writing');
            }

            do {
                $this->data = $input->read($input->get('chunksize', 8196));

                if ($this->data) {
                    if (!$output->write($this->data)) {
                        $input->close();

                        throw new \RuntimeException('Unable to write archive to file ' . $destination);
                    }
                }
            } while ($this->data);

            $output->close();
            $input->close();
        }

        return true;
    }

    /**
     * Tests whether this adapter can unpack files on this computer.
     *
     * @return  boolean  True if supported
     *
     * @since   1.0
     */
    public static function isSupported()
    {
        return \extension_loaded('bz2');
    }
}
