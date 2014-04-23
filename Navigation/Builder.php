<?php
/*
 * This file is part of the Swoopaholic Framework Bundle.
 *
 * (c) Danny Dörfel <danny@swoopaholic.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Swoopaholic\Bundle\FrameworkBundle\Navigation;

use Swoopaholic\Component\Navigation\NavigationFactoryInterface;
use Swoopaholic\Component\Navigation\ProviderInterface;
use Swoopaholic\Component\Navigation\Type\BarType;
use Swoopaholic\Component\Navigation\Type\ButtonType;
use Swoopaholic\Component\Navigation\Type\MenuType;
use Swoopaholic\Component\Navigation\Type\NavigationType;

/**
 * Factory object, building the navigation bar
 */
class Builder
{
    /**
     * @var \Swoopaholic\Component\Navigation\ProviderInterface
     */
    private $provider;

    /**
     * @var \Swoopaholic\Component\Navigation\NavigationFactoryInterface
     */
    private $factory;

    /**
     * @param ProviderInterface $provider
     * @param NavigationFactoryInterface $factory
     */
    public function __construct(ProviderInterface $provider, NavigationFactoryInterface $factory)
    {
        $this->provider = $provider;
        $this->factory = $factory;
    }

    public function buildNavBar()
    {
        $navBar = $this->factory->create('navbar', new NavigationType(), array());
        $navBar->add($this->provider->get('topbar'))
            ->add($this->buildMainSidebar())
            ->add($this->buildProfileSideBar());

        return $navBar;
    }

    public function buildMainSideBar()
    {
        $mainSideBar = $this->factory->create(
            'mainSideBar',
            new BarType(),
            array(
                'orientation' => 'left',
                'data-class' => 'tocompact slide'
            )
        );

        $mainSideBar->add($this->factory->create(
            'mainMenu',
            new MenuType(),
            array(
                'menu' => $this->provider->get('menu_main_nav')
            )
        ));

        return $mainSideBar;
    }

    public function buildProfileSideBar()
    {
        $profileSideBar = $this->factory->create(
            'profileSideBar',
            new BarType(),
            array(
                'orientation' => 'right',
                'data-class' => 'compact slide'
            )
        );

        return $profileSideBar;
    }
}
