<?php
/*
 * (c) Netvlies Internetdiensten
 *
 * Author Danny Dörfel <ddorfel@netvlies.nl>
 * Created: 10/16/13 4:09 PM
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Swoopaholic\Bundle\FrameworkBundle\CacheWarmer;

use Symfony\Component\HttpKernel\CacheWarmer\CacheWarmerInterface;

class MenuCacheWarmer implements CacheWarmerInterface
{
    protected $menuCollector;

    public function __construct($menuCollector)
    {
        $this->menuCollector = $menuCollector;
    }

    /**
     * Checks whether this warmer is optional or not.
     *
     * Optional warmers can be ignored on certain conditions.
     *
     * A warmer should return true if the cache can be
     * generated incrementally and on-demand.
     *
     * @return Boolean true if the warmer is optional, false otherwise
     */
    public function isOptional()
    {
        return false;
    }

    /**
     * Warms up the cache.
     *
     * @param string $cacheDir The cache directory
     */
    public function warmUp($cacheDir)
    {

    }
}
