<?php
/*
 * This file is part of the Swoopaholic Framework Bundle.
 *
 * (c) Danny Dörfel <danny@swoopaholic.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Swoopaholic\Bundle\FrameworkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NavigationController extends Controller
{
    public function indexAction()
    {
        $builder = $this->get('swp_framework.navigation.builder');
        $navBarView = $builder->buildNavBar()->createView();
        return $this->render('SwpFrameworkBundle:Navigation:index.html.twig', array('panelnav' => $navBarView));
    }
}
