<?php

use Kahlan\Plugin\Double;
use Phalcon\Paginator\Adapter\Collection as Paginator;

describe(Paginator::class, function () {

    given('default_config', function () {
        return [
            'limit' => 3,
        ];
    });

    describe('->__construct()', function () {
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
});
