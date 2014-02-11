#!/bin/bash

########################
#
# Processes received newsletter subscription request confirmation
# emails by executing PHP_SCRIPT
#
########################
WORKING_DIR=/home/bobiles/public_html/devsystem
PHP_SCRIPT=readnewsletterconfs.php
PHP_CLI=php


cd $WORKING_DIR
echo `pwd`
$PHP_CLI $PHP_SCRIPT
