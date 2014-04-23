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

        foreach ($menuConfig as $alias => $id) {
            $menu->addChild($this->provider->get($alias));
        }

        return $menu;
    }

    protected function getMenuConfig($name)
    {
        if (! isset($this->registeredMenus[$name])) {
            throw new \InvalidArgumentException('Menu does not exist: ' . $name);
        }

        return $this->registeredMenus[$name];
    }
}
