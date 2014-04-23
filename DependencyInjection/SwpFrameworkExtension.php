<?php
/*
 * This file is part of the Swoopaholic Framework Bundle.
 *
 * (c) Danny Dörfel <danny@swoopaholic.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Swoopaholic\Bundle\FrameworkBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\Config\FileLocator;

class SwpFrameworkExtension extends Extension implements PrependExtensionInterface
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('navigation.yml');
        $loader->load('menu.yml');
        $loader->load('crud.yml');
        $loader->load('raven.yml');
        $loader->load('services.yml');
    }

    /**
     * {@inheritDoc}
     */
    public function prepend(ContainerBuilder $container)
    {
        $bundles = $container->getParameter('kernel.bundles');

        if (isset($bundles['AsseticBundle'])) {
            $this->configureAsseticBundle($container);
        }
    }

    protected function configureAsseticBUndle(ContainerBuilder $container)
    {
        foreach ($container->getExtensions() as $name => $extension) {
            switch ($name) {
                case 'assetic':
                    $container->prependExtensionConfig(
                        $name,
                        array(
                            'assets' => $this->buildAsseticConfig()
                        )
                    );
                    break;
            }
        }
    }

    private function buildAsseticConfig()
    {
        $assetsConfig = array(
            'nvs_raven_css' => array(
                'input' => array(
                    '%kernel.root_dir%/../vendor/netvlies/raven-interface/dist/css/raven.css',
                ),
                'filters' => array('cssrewrite'),
                'output' => 'css/nvs_raven.css',
            ),
            'nvs_raven_js' => array(
                'input' => array(
                    '%kernel.root_dir%/../vendor/netvlies/raven-interface/dist/js/raven.js',
                ),
                'output' => 'js/nvs_raven.js',
            ),
        );

        foreach (array('woff', 'ttf', 'svg') as $font) {
            $name = str_replace('-', '_', $font);
            $assetsConfig['nvs_raven_svg_' . $name] = array(
                'input' => '%kernel.root_dir%/../vendor/netvlies/raven-interface/dist/fonts/Icomoon.' . $font,
                'output' => 'fonts/Icomoon.' . $font
            );
        }

        return $assetsConfig;
    }
}

