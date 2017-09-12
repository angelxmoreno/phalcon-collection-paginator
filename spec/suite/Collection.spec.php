<?php

use CollectionModel\TestModel;
use Phalcon\Paginator\Adapter\Collection as Paginator;
use Phalcon\Paginator\Exception as PaginatorException;

describe(Paginator::class, function () {

    given('default_config', function () {
        return [
            'limit' => 3,
            'collection' => TestModel::class,
            'find_query' => [],
            'page' => 2
        ];
    });
    beforeAll(function () {
        TestModel::populate();
    });
    afterAll(function () {
        TestModel::cleanUp();
    });
    describe('->__construct()', function () {
        context('setting the limit', function () {
            context('when a limit is given', function () {
                beforeEach(function () {
                    $this->limit = 13;
                    $this->config = $this->default_config;
                    $this->config['limit'] = $this->limit;
                });

                it('sets the limit on the instance', function () {
                    expect(Paginator::class)
                        ->toReceive('setLimit')
                        ->with($this->limit);

                    $paginator = new Paginator($this->config);

                    expect($paginator->getLimit())->toBe($this->limit);
                });
            });

            context('when a limit is not given', function () {
                beforeEach(function () {
                    $this->config = $this->default_config;
                    unset($this->config['limit']);
                });

                it('sets the limit to "DEFAULT_LIMIT" on the instance', function () {
                    expect(Paginator::class)
                        ->toReceive('setLimit')
                        ->with(Paginator::DEFAULT_LIMIT);

                    $paginator = new Paginator($this->config);

                    expect($paginator->getLimit())->toBe(Paginator::DEFAULT_LIMIT);
                });
            });
        });

        context('setting the collection', function () {

            context('when a Collection is given', function () {
                beforeEach(function () {
                    $this->config = $this->default_config;
                });
                it('sets the Collection on the instance', function () {
                    expect(Paginator::class)
                        ->toReceive('setCollection')
                        ->with(TestModel::class);

                    $paginator = new Paginator($this->config);

                    expect($paginator->getCollection())->toBe(TestModel::class);
                });
            });

            context('when a Collection is not given', function () {
                beforeEach(function () {
                    $this->config = $this->default_config;
                    unset($this->config['collection']);
                });

                it('throws an exception', function () {
                    expect(Paginator::class)
                        ->not->toReceive('setCollection');

                    $closure = function () {
                        new Paginator($this->config);
                    };
                    expect($closure)->toThrow(new PaginatorException());
                });
            });
        });

        context('setting the query', function () {

            context('when a query array is given', function () {
                beforeEach(function () {
                    $this->find_array = [
                        [
                            'some_key' => 'some_value'
                        ],
                        'sort' => [
                            'another_key' => 'another_value'
                        ]
                    ];
                    $this->config = $this->default_config;
                    $this->config['find_query'] = $this->find_array;
                });

                it('sets the query array on the instance', function () {
                    expect(Paginator::class)
                        ->toReceive('setFindQuery')
                        ->with($this->find_array);

                    $paginator = new Paginator($this->config);

                    expect($paginator->getFindQuery())->toBe($this->find_array);
                });
            });

            context('when a query array is not given', function () {
                beforeEach(function () {
                    $this->config = $this->default_config;
                    unset($this->config['find_query']);
                });

                it('sets an empty array as the query array', function () {
                    expect(Paginator::class)
                        ->toReceive('setFindQuery')
                        ->with([]);

                    $paginator = new Paginator($this->config);

                    expect($paginator->getFindQuery())->toBe([]);
                });
            });
        });

        context('setting the current page', function () {

            context('when only a current_page is given', function () {
                beforeEach(function () {
                    $this->current_page = 34;
                    $this->config = $this->default_config;
                    $this->config['current_page'] = $this->current_page;
                });

                it('sets the current page value to current_page on the instance', function () {
                    expect(Paginator::class)
                        ->toReceive('setCurrentPage')
                        ->with($this->current_page);

                    $paginator = new Paginator($this->config);
                    expect($paginator->getCurrentPage())->toBe($this->current_page);
                });
            });

            context('when only a page is given', function () {
                beforeEach(function () {
                    $this->page = 56;
                    $this->config = $this->default_config;
                    $this->config['page'] = $this->page;
                });

                it('sets the current page value to page on the instance', function () {
                    expect(Paginator::class)
                        ->toReceive('setCurrentPage')
                        ->with($this->page);

                    $paginator = new Paginator($this->config);
                    expect($paginator->getCurrentPage())->toBe($this->page);
                });
            });

            context('when both a current_page and page are given', function () {
                beforeEach(function () {
                    $this->config = $this->default_config;

                    $this->page = 78;
                    $this->config['page'] = $this->page;

                    $this->current_page = 90;
                    $this->config['current_page'] = $this->current_page;
                });

                it('sets the current page value to current_page on the instance', function () {
                    expect(Paginator::class)
                        ->toReceive('setCurrentPage')
                        ->with($this->current_page);

                    $paginator = new Paginator($this->config);
                    expect($paginator->getCurrentPage())->toBe($this->current_page);
                    expect($paginator->getCurrentPage())->not->toBe($this->page);
                });
            });
        });
    });
});
