<?php
/**
 * Created 08-02-14 00:13
 */
namespace Swoopaholic\Bundle\FrameworkBundle\CrudTable;

interface SortResolverInterface
{
    /**
     * Returns the uri query params for the sort key
     *
     * @param $key
     * @return array
     */
    public function getSortParams($key);

    /**
     * Returns the current sort direction for the key
     *
     * @param $key
     * @return string 'ASC|'DESC'
     */
    public function getSortDir($key);

    /**
     * Checks if the key is the current sort
     *
     * @param $key
     * @return boolean
     */
    public function isSort($key);
}
