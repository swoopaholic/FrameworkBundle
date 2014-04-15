<?php
/**
 * Created 07-02-14 21:43
 */
namespace Swoopaholic\Bundle\FrameworkBundle\CrudTable;

use Swoopaholic\Bundle\FrameworkBundle\CrudTable\Type\CrudCellType;
use Swoopaholic\Component\Table\TableFactory;
use Swoopaholic\Component\Table\Type\BodyType;
use Swoopaholic\Component\Table\Type\CellType;
use Swoopaholic\Component\Table\Type\HeadCellType;
use Swoopaholic\Component\Table\Type\HeadType;
use Swoopaholic\Component\Table\Type\RowType;
use Swoopaholic\Component\Table\Type\TableType;
use Swoopaholic\Bundle\FrameworkBundle\CrudTable\Type\CrudActionType;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class Factory
 * @package Swoopaholic\Bundle\FrameworkBundle\CrudTable
 */
class Factory
{
    /**
     * @var \Swoopaholic\Component\Table\TableFactory
     */
    private $factory;

    /**
     * @var Router|\Symfony\Component\Routing\RouterInterface
     */
    private $router;

    /**
     * @var string
     */
    private $route;

    /**
     * @var \Swoopaholic\Component\Table\SortResolverInterface
     */
    private $sortResolver;

    /**
     * @var \ArrayIterator
     */
    private $columns;

    /**
     * @var array
     */
    private $converters;

    /**
     * The callback to retrieve the actions for the item
     * @var array|string
     */
    private $itemActionCallback;

    /**
     * @var mixed
     */
    private $data;

    /**
     * @param \Swoopaholic\Component\Table\TableFactory $factory
     * @param RouterInterface $router
     * @internal param \Swoopaholic\Component\Table\TableFactory $table
     * @internal param \Swoopaholic\Bundle\FrameworkBundle\CrudTable\Request $request
     */
    public function __construct(TableFactory $factory, RouterInterface $router)
    {
        $this->factory = $factory;
        $this->router = $router;
        $this->converters = array();
        $this->columns = new \ArrayIterator();
    }

    /**
     * @param $route
     * @return $this
     */
    public function setRoute($route)
    {
        $this->route = $route;
        return $this;
    }

    /**
     * @param SortResolverInterface $sortResolver
     * @return $this
     */
    public function setSortResolver(SortResolverInterface $sortResolver)
    {
        $this->sortResolver = $sortResolver;
        return $this;
    }

    /**
     * @param $index
     * @param $label
     * @param null $key
     * @internal param string $weight
     * @return $this
     */
    public function addColumn($index, $label, $key = null)
    {
        $this->columns->append(compact('index', 'key', 'label'));
        return $this;
    }

    /**
     * @param $index
     * @param $converter
     * @return Factory
     */
    public function addConverter($index, ValueConverterInterface $converter)
    {
        $this->converters[$index] = $converter;
        return $this;
    }

    /**
     * @param $data
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @param $callback
     * @return $this
     */
    public function setItemActionCallback($callback)
    {
        $this->itemActionCallback = $callback;
        return $this;
    }

    /**
     * @return \Swoopaholic\Component\Table\Table
     */
    public function createTable()
    {
        $table = $this->factory->create('table', new TableType(), array('hover' => true));
        $table->add($this->createTableHeader());
        $table->add($this->createTableBody());

        return $table;
    }

    /**
     * @return \Swoopaholic\Component\Table\Table
     */
    public function createTableHeader()
    {
        $head = $this->factory->create('head', new HeadType(), array());

        $i = 0;
        foreach ($this->columns as $column) {

            extract($column);
            $params = array('label' => $label);

            if ($key) {
                $params['sortLink'] = $this->getSortLink($this->sortResolver->getSortParams($key));
                $params['sortDir'] = $this->sortResolver->getSortDir($key);
                $params['active'] = $this->sortResolver->isSort($key);
            }

            $head->add($this->factory->create('head_column' . $i++, new HeadCellType(), $params));
        }

        if ($this->itemActionCallback) {
            $head->add($this->factory->create('head_column_crud', new HeadCellType(), array()));
        }

        return $head;
    }

    /**
     * @return \Swoopaholic\Component\Table\Table
     */
    public function createTableBody()
    {
        $body = $this->factory->create('body', new BodyType(), array());

        $i = 0;
        foreach ($this->data as $item) {
            $row = $this->factory->create('row_' . $i, new RowType(), array());

            $j = 0;
            foreach ($this->columns as $column) {
                extract($column);
                $value = $this->getValue($item, $index);
                $cell = $this->factory->create('cell_' . $i . '_' . $j++, new CellType(), array('value' => $value));
                $row->add($cell);
            }

            $this->addItemActions($row, $item);

            $body->add($row);
            ++$i;
        }

        return $body;
    }

    private function getValue($item, $index)
    {
        if (is_array($item)) {
            return $item[$index];
        } elseif (is_object($item)) {
            $method = 'get' . ucfirst($index);
            $value = $item->$method();
            if (isset($this->converters[$index])) {
                $converter = $this->converters[$index];
                $value = $converter->convert($value);
            }

            return $value;
        }

        throw new \Exception('huh?');
    }

    private function addItemActions($row, $item)
    {
        if ($this->itemActionCallback) {
            $actions = call_user_func($this->itemActionCallback, $this->factory, $item);

            if (count($actions)) {
                $itemActions = $this->factory->create($row->getName() . '_actions', new CrudCellType(), array());
                foreach ($actions as $action) {
                    $itemActions->add($action);
                }
                $row->add($itemActions);
            }
        }
    }

    /**
     * Generates the table header sort link
     *
     * @param $params
     * @return mixed
     */
    private function getSortLink($params)
    {
        return $this->router->generate($this->route, $params);
    }
}
