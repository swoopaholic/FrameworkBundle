<?php
namespace Swoopaholic\Bundle\FrameworkBundle\Navigation;

use Swoopaholic\Component\Navigation\NavigationFactoryInterface;
use Swoopaholic\Component\Navigation\ProviderInterface;
use Swoopaholic\Component\Navigation\Type\BarType;
use Swoopaholic\Component\Navigation\Type\ButtonType;
use Swoopaholic\Component\Navigation\Type\MenuType;
use Swoopaholic\Component\Navigation\Type\NavigationType;

/**
 * Factory object building the navigation top-bar
 */
class TopbarBuilder
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

    /**
     * @return ProviderInterface
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * @return NavigationFactoryInterface
     */
    public function getFactory()
    {
        return $this->factory;
    }

    /**
     * Builds the topBar
     *
     * @return \Swoopaholic\Component\Navigation\NavigationInterface
     */
    public function buildTopBar()
    {
        $topBar = $this->createBar();

        $this->addSidebarToggle($topBar, 'mainSidebarToggle', 'left', 'menu');
        $this->addBarElements($topBar);
        $this->addSidebarToggle($topBar, 'profileSidebarToggle', 'right', 'user4');

        return $topBar;
    }


    protected function addSidebarToggle($topBar, $id, $side, $icon)
    {
        $topBar->add($this->factory->create(
            $id,
            new ButtonType(),
            array(
                'align' => $side,
                'icon' => $icon,
                'attr' => array(
                    'data-togglepanelnav' => $side
                )
            )
        ));
    }

    /**
     * Adds the bar sub-elements. Extend this to add extra elements to the bar
     * @param $topBar
     */
    protected function addBarElements($topBar)
    {
    }

    /**
     * Creates the toplevel bar element
     * @return \Swoopaholic\Component\Navigation\NavigationInterface
     */
    private function createBar()
    {
        return $this->factory->create(
            'topbar',
            new BarType(),
            array(
                'orientation' => 'top',
            )
        );
    }
}
