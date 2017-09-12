<?php

namespace CollectionModel;

use League\FactoryMuffin\FactoryMuffin;
use League\FactoryMuffin\Faker\Facade as Faker;
use Phalcon\Mvc\Collection;

/**
 * Class TestModel
 *
 * @package CollectionModel
 */
class TestModel extends Collection
{
    public static function populate()
    {
        $fm = new FactoryMuffin();
        $fm->define(self::class)->setDefinitions([
            'title' => Faker::sentence(5),
            'name' => Faker::unique()->firstName()
        ]);
        $fm->seed(10, self::class);
    }

    public static function cleanUp()
    {
        $rows = self::find();

        foreach ($rows as $row) {
            $row->delete();
        }
    }
}