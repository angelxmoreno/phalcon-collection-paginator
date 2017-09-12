<?php

namespace Phalcon\Paginator\Adapter;

use Phalcon\Mvc\Collection as CollectionModel;
use Phalcon\Paginator\AdapterInterface as PaginatorInterface;
use Phalcon\Paginator\Exception as PaginatorException;

/**
 * Class Collection
 *
 * @package Phalcon\Paginator\Adapter
 */
class Collection implements PaginatorInterface
{
    const DEFAULT_LIMIT = 30;
    const MISSING_COLLECTION = 'Missing Collection';

    /**
     * @var CollectionModel
     */
    protected $collection;

    /**
     * @var integer
     */
    protected $limit;

    /**
     * @var array
     */
    protected $find_query;

    /**
     * @var integer
     */
    protected $current_page;

    /**
     * Collection Adapter constructor
     * @param array $config
     *
     * @throws PaginatorException
     */
    public function __construct(array $config)
    {
        $limit = isset($config['limit']) ? $config['limit'] : self::DEFAULT_LIMIT;

        if (!isset($config['collection'])) {
            throw new PaginatorException(self::MISSING_COLLECTION);
        }
        $collection = $config['collection'];
        $find_query = isset($config['find_query']) ? $config['find_query'] : [];

        $current_page = (isset($config['current_page']))
            ? $config['current_page']
            : (isset($config['page']) ? $config['page'] : 1);

        $this->setLimit($limit);
        $this->setCollection($collection);
        $this->setFindQuery($find_query);
        $this->setCurrentPage($current_page);
    }

    /**
     * Returns a slice of the resultset to show in the pagination
     *
     * @return \stdClass
     */
    public function getPaginate()
    {
        $find_query = $this->buildQuery();
        $collection = $this->getCollection();
        $result = $this->paginate($collection, $find_query);

        return $this->createPaginationDataObj($result);
    }

    /**
     * @return array
     */
    protected function buildQuery()
    {
        $find_query = $this->getFindQuery();
        $find_query['limit'] = $this->getLimit();
        $find_query['skip'] = ($this->getCurrentPage() - 1) * $this->getLimit();

        return $find_query;
    }

    /**
     * @param string|CollectionModel $collection
     * @param array $query
     *
     * @return array
     */
    protected function paginate($collection, array $query)
    {
        return $collection::find($query);
    }

    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     */
    public function setLimit($limit)
    {
        $this->limit = (int)$limit;
    }

    /**
     * @return string|CollectionModel
     */
    public function getCollection()
    {
        return $this->collection;
    }

    /**
     * @param string|CollectionModel $collection
     */
    public function setCollection($collection)
    {
        $this->collection = $collection;
    }

    /**
     * @return array
     */
    public function getFindQuery()
    {
        return $this->find_query;
    }

    /**
     * @param array $find_query
     */
    public function setFindQuery(array $find_query)
    {
        $this->find_query = $find_query;
    }

    /**
     * @return int
     */
    public function getCurrentPage()
    {
        return $this->current_page;
    }

    /**
     * @param int $current_page
     */
    public function setCurrentPage($current_page)
    {
        $this->current_page = (int)$current_page;
    }

    /**
     * @return integer
     */
    protected function calcTotalItemsCount()
    {
        $collection = $this->getCollection();

        return (int)$collection::count($this->getFindQuery());
    }

    /**
     * @param integer $total_items
     *
     * @return integer
     */
    protected function calcTotalPages($total_items)
    {
        return (int)ceil($total_items / $this->getLimit());
    }

    /**
     * @param array $items
     * @return \stdClass
     */
    protected function createPaginationDataObj(array $items)
    {
        $current = $this->getCurrentPage();
        $total_items = $this->calcTotalItemsCount();
        $last = $this->calcTotalPages($total_items);
        $before = max(1, $current - 1);
        $next = min($last, $current + 1);

        $page = new \stdClass();
        $page->items = $items;
        $page->first = 1;
        $page->before = $before;
        $page->current = $current;
        $page->last = $last;
        $page->next = $next;
        $page->total_pages = $last;
        $page->total_items = $total_items;
        $page->limit = $this->getLimit();

        return $page;
    }
}