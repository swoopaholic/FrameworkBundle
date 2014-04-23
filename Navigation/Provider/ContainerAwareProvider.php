<?php
/*
 * This file is part of the Swoopaholic Framework Bundle.
 *
 * (c) Danny Dörfel <danny@swoopaholic.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Swoopaholic\Bundle\FrameworkBundle\Navigation\Provider;

use Swoopaholic\Component\Navigation\NavigationInterface;
use Swoopaholic\Component\Navigation\ProviderInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class ContainerAwareProvider
 * @package Swoopaholic\Bundle\FrameworkBundle\NavBar\Provider
 */
class ContainerAwareProvider implements ProviderInterface
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    private $container;

    /**
     * @var array
     */
    private $elementIds;

    /**
     * @param ContainerInterface $container
     * @param array $elementIds
     */
    public function __construct(ContainerInterface $container, array $elementIds)
    {
        $this->container = $container;
        $this->elementIds = $elementIds;
    }

    /**
     * @param string $name
     * @param array $options
     * @throws \InvalidArgumentException
     * @internal param string $section
     * @return NavigationInterface
     */
    public function get($name, array $options = array())
    {
        if (!$this->has($name)) {
            throw new \InvalidArgumentException(sprintf('The element "%s" is not defined.', $name));
        }

        return $this->container->get($this->elementIds[$name]);
    }

    /**
     * @param string $name
     * @internal param string $section
     * @return bool
     */
    public function has($name)
    {
        return isset($this->elementIds[$name]);
    }
}
