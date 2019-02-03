# Phalcon Collection Paginator
A Phalcon paginator adapter for Phalcon Collections
[![Build Status](http://img.shields.io/travis/angelxmoreno/phalcon-collection-paginator.svg?style=flat-square)](https://travis-ci.org/angelxmoreno/phalcon-collection-paginator)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/ced9387624bb40d590ea862f582939a9)](https://www.codacy.com/app/angelxmoreno/phalcon-collection-paginator?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=angelxmoreno/phalcon-collection-paginator&amp;utm_campaign=Badge_Grade)
[![Code Climate](http://img.shields.io/codeclimate/github/angelxmoreno/phalcon-collection-paginator.svg?style=flat-square)](https://codeclimate.com/github/angelxmoreno/phalcon-collection-paginator)
[![License](http://img.shields.io/:license-mit-blue.svg?style=flat-square)](http://angelxmoreno.mit-license.org)

## Why create this?
Being familiar with the various [Pagination data adapters](https://docs.phalconphp.com/3.4/en/db-pagination#data-adapters) 
available to the `Phalcon\Mvc\Model`, I expected to see similar adapters for `Phalcon\Mvc\Collection`. This project is to provide a pagination data adapter for ODM in Phalcon.
  
## Installation

1. Use composer
2. Run
    ```bash
    composer require angelxmoreno/phalcon-collection-paginator
    ```
3. Make sure to include Composer's autoload.php file as part of your bootstrapping process
    ```bash
    require 'vendor/autoload.php';
    ```

## Configuration
|  Property  	|                                            Description                                           	| Optional 	| Default 	|
|:----------:	|:------------------------------------------------------------------------------------------------:	|:--------:	|:-------:	|
| limit      	| The number of items to fetch at a time                                                           	| yes      	| 30      	|
| page       	| The current page set to fetch                                                                    	| yes      	| 1       	|
| collection 	| The collection class' FQN to use for fetching                                                    	| no       	| `none`  	|
| find_query 	| An array to use when building the query for the page set. *Must be a `find()` compatible array.* 	| yes      	| []      	|


## Example

```php
<?php

use App\Models\Cars;
use Phalcon\Paginator\Adapter\Collection as CollectionPaginator;

// In a controller you could have something like so:

// An array of defaults settings
$default_pagination_settings = [
   'limit' => CollectionPaginator::DEFAULT_LIMIT,
   'page' => 1,
   'collection' => Cars::class,
   'find_query' => [
       'year' => 1980
   ]
];

// Merge the default array with the query string params
$pagination_settings = array_merge($default_pagination_settings, $this->request->getQuery());

// Create a Collection Paginator instance with the pagination settings
$paginator = CollectionPaginator($pagination_settings);

// Get the paginated results \stdClass and set it to the view
$this->view->results = $paginator->getPaginate();
```

`CollectionPaginator->getPaginate()` returns an [\stdClass](https://olddocs.phalconphp.com/en/3.0.0/reference/pagination.html#page-attributes).

## Running tests

```bash
docker-comose up
./bin/run_tests.sh
docker-comose down
```

## Contributing

1. Fork the repo
2. Branch from master
3. Open a PR

## License

(The MIT license)

Copyright (c) 2017 Angel S. Moreno

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
