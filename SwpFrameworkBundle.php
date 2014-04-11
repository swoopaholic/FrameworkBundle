<?php
/*
 * (c) Netvlies Internetdiensten
 *
 * Author Danny Dörfel <ddorfel@netvlies.nl>
 * Created: 10/28/13 4:15 PM
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Swoopaholic\Bundle\FrameworkBundle;

use Swoopaholic\Bundle\FrameworkBundle\DependencyInjection\Compiler\MenuPass;
use Swoopaholic\Bundle\FrameworkBundle\DependencyInjection\Compiler\NavigationComponentPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SwpFrameworkBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new MenuPass());
        $container->addCompilerPass(new NavigationComponentPass());
    }
}
