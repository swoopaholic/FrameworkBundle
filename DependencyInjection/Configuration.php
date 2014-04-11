<?php
/*
 * (c) Netvlies Internetdiensten
 *
 * Author Danny Dörfel <ddorfel@netvlies.nl>
 * Created: 10/14/13 5:03 PM
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Swoopaholic\Bundle\FrameworkBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        return $this->buildConfigTree();
    }

    private function buildConfigTree()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('nvs_raven');

        $rootNode
            ->children()
                // twig form template integration
                ->arrayNode('twig')
                    ->children()
                        ->arrayNode('form')
                            ->children()
                                ->arrayNode('resources')
                                    ->prototype('scalar')->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
