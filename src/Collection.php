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
