<?php

namespace Phalcon\Paginator\Adapter;

/**
 * Class Collection
 *
 * @package Phalcon\Paginator\Adapter
 */

use Phalcon\Paginator\AdapterInterface as PaginatorInterface;

/**
 * Class Collection
 * @package Lancermall\Core\Paginator
 */
class Collection implements PaginatorInterface
{
    const DEFAULT_LIMIT = 30;

    /**
    /**
     * @var integer
     */
    protected $limit;
     * Adapter constructor
     *
     * @param array $config
     */
    public function __construct($config)
    {
        $limit = isset($config['limit']) ? $config['limit'] : self::DEFAULT_LIMIT;
        $this->setLimit($limit);
    }    /**
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
    }}