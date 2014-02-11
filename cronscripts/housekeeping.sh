#!/bin/bash
#################################################
# CDN 09/08/07
#
# Shell Script to launch housekeeping php scripts
#
#
# Modification History
# ====================
#
# 
# 21/05/2012	CDN		TEST Directory removed
#
#################################################

# ukhost4u web server path
LIVE_DIR=/home/bobiles/public_html
TEST_DIR=/home/bobiles/public_html/devsystem


# local dev machine path
#LIVE_DIR=/var/www/church
#TEST_DIR=/var/www/church/devsystem

# run php script via php cli
cd $LIVE_DIR
php -f housekeeping.cron.php

# 21/05/2012	CDN		TEST Directory removed
#cd $TEST_DIR
#php -f housekeeping.cron.php

