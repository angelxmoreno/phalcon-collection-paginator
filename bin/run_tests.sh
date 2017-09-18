#!/usr/bin/env bash

docker exec test-fpm ./bin/kahlan --cc=true --src=src --spec=spec/suite --reporter=verbose --coverage=4 --clover=clover.xml