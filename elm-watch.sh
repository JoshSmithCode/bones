#!/bin/bash

echo $1;

cd ./src/View/Apps/$1;
chokidar '**/*.elm' -c "elm make ./$1.elm --output ../../../../public/build/$1.js" --initial