#!/bin/bash

cd docker && docker-compose -f docker-compose-dev.yml up laravel-exchange nginx-exchange redis-exchange db-exchange phpmyadmin-exchange