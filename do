#!/usr/bin/env php
<?php
if (php_sapi_name() != "cli") {
	exit('This script must be executed in CLI');
}

print "It works\n";