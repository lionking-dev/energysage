<?php

/**
 * @package     Joomla.Plugin
 * @subpackage  Extension.namespacemap
 *
 * @copyright   (C) 2022 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Extension\PluginInterface;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use Joomla\Event\DispatcherInterface;
use Joomla\Plugin\Extension\NamespaceMap\Extension\NamespaceMap;

return new class () implements ServiceProviderInterface {
    /**
     * Registers the service provider with a DI container.
     *
     * @param   Container  $container  The DI container.
     *
     * @return  void
     *
     * @since   4.3.0
     */
    public function register(Container $container)
    {
        $container->set(
            PluginInterface::class,
            function (Container $container) {
                $plugin     = new NamespaceMap(
                    $container->get(DispatcherInterface::class),
                    new JNamespacePsr4Map(),
                    (array) PluginHelper::getPlugin('extension', 'namespacemap')
                );

                return $plugin;
            }
        );
    }
};
