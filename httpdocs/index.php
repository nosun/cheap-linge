<?php

define('DOCROOT', strtr(dirname(__FILE__), '\\', '/'));
define('BLROOT', dirname(DOCROOT));
define('LIBPATH', BLROOT . '/libraries');
define('TPLPATH', DOCROOT . '/templates');
define('SITESPATH', BLROOT . '/sites');
define('TIMESTAMP', $_SERVER['REQUEST_TIME']);

require_once LIBPATH . '/core.php';
try {
  Bl_Core::init();
  Bl_Core::run();
} catch (Exception $ex) {
  Bl_Core::errorDispatch($ex);
}
