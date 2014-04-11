<?php
namespace Swoopaholic\Bundle\FrameworkBundle\Navigation;

use Swoopaholic\Component\Navigation\NavigationFactoryInterface;
use Swoopaholic\Component\Navigation\ProviderInterface;
use Swoopaholic\Component\Navigation\Type\BarType;
use Swoopaholic\Component\Navigation\Type\ButtonType;
use Swoopaholic\Component\Navigation\Type\MenuType;
use Swoopaholic\Component\Navigation\Type\NavigationType;

class Builder
{
    private $provider;

    private $factory;

    public function __construct(ProviderInterface $provider, NavigationFactoryInterface $factory)
    {
        $this->provider = $provider;
        $this->factory = $factory;
    }

    public function buildNavBar()
    {
        $navBar = $this->factory->create('navbar', new NavigationType(), array());
        $navBar->add($this->buildTopBar())
            ->add($this->buildMainSidebar())
            ->add($this->buildProfileSideBar());

        return $navBar;
    }

    public function buildTopBar()
    {
        $topBar = $this->factory->create(
            'topbar',
            new BarType(),
            array(
                'orientation' => 'top'
            )
        );

        $topBar->add($this->factory->create(
            'mainSidebarToggle',
            new ButtonType(),
            array(
                'align' => 'left',
                'icon' => 'menu',
                'attr' => array(
                    'data-togglepanelnav' => 'left'
                )
            )
        ))
        ->add($this->factory->create(
            'profileSidebarToggle',
                new ButtonType(),
                array(
                    'align' => 'right',
                    'icon' => 'user4',
                    'attr' => array(
                        'data-togglepanelnav' => 'right'
                    )
                )
        ));

        return $topBar;
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
