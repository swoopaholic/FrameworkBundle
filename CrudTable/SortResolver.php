<?php
/*
 * This file is part of the Swoopaholic Framework Bundle.
 *
 * (c) Danny Dörfel <danny@swoopaholic.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Swoopaholic\Bundle\FrameworkBundle\CrudTable;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class SortResolver
 * @package Swoopaholic\Bundle\FrameworkBundle\CrudTable
 */
class SortResolver implements SortResolverInterface
{
    const ASC = 'asc';
    const DESC = 'desc';

    /**
     * @var Request
     */
    private $request;

    /**
     * @var string
     */
    private $sortParamName;

    /**
     * @var string
     */
    private $sortOrderParamName;

    /**
     * @var string
     */
    private $defaultSortOrder;

    /**
     * @param Request $request
     * @internal param \Symfony\Component\Routing\RouterInterface $router
     */
    public function __construct(Request $request)
    {
        $this->request = $request;

        $this->sortParamName = 'sort';
        $this->sortOrderParamName = 'dir';
        $this->defaultSortOrder = 'ASC';
    }

    /**
     * @param $sortParamName
     * @return $this
     */
    public function setSortParamName($sortParamName)
    {
        $this->sortParamName = $sortParamName;
        return $this;
    }

    /**
     * @param $sortOrderParamName
     * @return $this
     */
    public function setSortOrderParamName($sortOrderParamName)
    {
        $this->sortOrderParamName = $sortOrderParamName;
        return $this;
    }

    /**
     * @param $sortOrder
     * @return $this
     */
    public function setDefaultSortOrder($sortOrder)
    {
        $this->defaultSortOrder = $sortOrder = self::DESC ? self::DESC : self::ASC;
        return $this;
    }

    /**
     * @param $key
     * @return string
     */
    public function getSortParams($key)
    {
        return array(
            $this->sortParamName => $key,
            $this->sortOrderParamName => $this->getSortDir($key)
        );
    }

    /**
     * @param $key
     * @return string
     */
    public function getSortDir($key)
    {
        $sortOrder = $this->request->get($this->sortOrderParamName, $this->defaultSortOrder);
        return $this->isSort($key) && $sortOrder == 'ASC' ? 'DESC' : 'ASC';
    }

    /**
     * @param $key
     * @return bool
     */
    public function isSort($key)
    {
        $sort = $this->request->get($this->sortParamName, null);
        return $sort == $key;
    }

    public function getQueryParams()
    {
        $params = array();

        if ($this->request->get($this->sortParamName)) {
            $params[$this->sortParamName] = $this->request->get($this->sortParamName);
        }

        if ($this->request->get($this->sortOrderParamName)) {
            $params[$this->sortOrderParamName] = $this->request->get($this->sortOrderParamName);
        }

        return $params;
    }
}
