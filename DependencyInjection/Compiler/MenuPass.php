<?php
namespace Swoopaholic\Bundle\FrameworkBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class MenuPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $definition = $container->getDefinition('nvs_framework.menu.builder');

        $menus = array();
        foreach ($container->findTaggedServiceIds('nvs_framework.menu.element') as $id => $tags) {
            foreach ($tags as $attributes) {
                if (empty($attributes['alias'])) {
                    throw new \InvalidArgumentException(sprintf('The alias is not defined in the "nvs_framework.menu.entry" tag for the service "%s"', $id));
                }
                if (empty($attributes['menu'])) {
                    throw new \InvalidArgumentException(sprintf('The menu is not defined in the "nvs_framework.menu.entry" tag for the service "%s"', $id));
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
