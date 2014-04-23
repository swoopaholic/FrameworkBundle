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

class MenuPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $definition = $container->getDefinition('swp_framework.menu.builder');

        // TODO: add weight / order

        $menus = array();
        foreach ($container->findTaggedServiceIds('swp_framework.menu.element') as $id => $tags) {
            foreach ($tags as $attributes) {
                if (empty($attributes['alias'])) {
                    throw new \InvalidArgumentException(sprintf('The alias is not defined in the "swp_framework.menu.entry" tag for the service "%s"', $id));
                }
                if (empty($attributes['menu'])) {
                    throw new \InvalidArgumentException(sprintf('The menu is not defined in the "swp_framework.menu.entry" tag for the service "%s"', $id));
                }

                $alias = $attributes['alias'];
                $menu = $attributes['menu'];
                if (! isset($menus[$menu])) {
                    $menus[$menu] = array();
                }
                $menus[$menu][$alias] = $id;
            }
        }

        $definition->replaceArgument(1, $menus);
    }
}
