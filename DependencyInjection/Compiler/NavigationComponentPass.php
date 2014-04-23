<?php
/*
 * This file is part of the Swoopaholic Framework Bundle.
 *
 * (c) Danny Dörfel <danny@swoopaholic.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Swoopaholic\Bundle\FrameworkBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class NavigationComponentPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('nvs_raven.navigation.container_aware_provider')) {
            return;
        }

        $definition = $container->getDefinition('nvs_raven.navigation.container_aware_provider');

        $navElements = array();
        foreach ($container->findTaggedServiceIds('swp_framework.navigation.element') as $id => $tags) {
            foreach ($tags as $attributes) {
                if (empty($attributes['alias'])) {
                    throw new \InvalidArgumentException(sprintf('The alias is not defined in the for the service "%s"', $id));
                }
                $navElements[$attributes['alias']] = $id;
            }
        }
        $definition->replaceArgument(1, $navElements);
    }
}
