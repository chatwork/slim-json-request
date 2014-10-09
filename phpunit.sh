#!/bin/sh

cd `dirname ${0}`

./vendor/bin/phpunit --configuration ./phpunit.xml ./tests
