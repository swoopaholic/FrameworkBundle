<?php
/**
 * Created 19-02-14 08:27
 */
namespace Swoopaholic\Bundle\FrameworkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NavigationController extends Controller
{
    public function indexAction()
    {
        $builder = $this->get('nvs_framework.navigation.builder');
        $navBarView = $builder->buildNavBar()->createView();
        return $this->render('SwpFrameworkBundle:Navigation:index.html.twig', array('panelnav' => $navBarView));
    }
}
