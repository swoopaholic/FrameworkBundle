<?php
/*
 * This file is part of the Swoopaholic Framework Bundle.
 *
 * (c) Danny Dörfel <danny@swoopaholic.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Swoopaholic\Bundle\FrameworkBundle\Menu;

use Knp\Menu\MenuFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;

class Builder
{
    protected $provider;

    protected $registeredMenus;

    public function __construct($provider, $registeredMenus = array())
    {
        $this->factory = new MenuFactory();
        $this->provider = $provider;
        $this->registeredMenus = $registeredMenus;
    }

    public function mainNavigation(Request $request, SecurityContext $securityContext)
    {
        $menu = $this->factory->createItem('root');
        $menu->setCurrentUri($request->getRequestUri());

        $menuConfig = $this->getMenuConfig('menu_main_nav');

        if (!$menuConfig) {
            return $menu;
        }

        foreach ($menuConfig as $alias => $id) {
            $menu->addChild($this->provider->get($alias));
        }

        return $menu;
    }

    public function secondaryNavigation(Request $request, SecurityContext $securityContext)
    {
        $menu = $this->factory->createItem('root');
        $menu->setCurrentUri($request->getRequestUri());

        $menuConfig = $this->getMenuConfig('menu_secondary_nav');

        if (!$menuConfig) {
            return $menu;
        }

        $children = array();
        foreach ($menuConfig as $alias => $id) {
            $children[] = $this->provider->get($alias);
        }

        $menu->setChildren($children);

        return $menu;
    }

    protected function getMenuConfig($name)
    {
        if (! isset($this->registeredMenus[$name])) {
            return false;
        }

        return $this->registeredMenus[$name];
    }
}
