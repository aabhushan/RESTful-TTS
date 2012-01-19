#! /bin/bash

NAME=$3
TEXT=$1
SPEECHPATH=$2

say ${TEXT} -o $2/${NAME}.aiff
/usr/local/bin/lame ${SPEECHPATH}/${NAME}.aiff ${SPEECHPATH}/${NAME}.mp3 2> ${SPEECHPATH}/${NAME}.log
#afplay ${NAME}.mp3
rm ${SPEECHPATH}/${NAME}.aiff
