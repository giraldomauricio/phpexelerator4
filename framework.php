<?

// ###################################################################
// phpEXelerator v.4.0
// (R) 2005-2013
// ###################################################################
// Start application configuration

ini_set('max_execution_time', '1800');
ini_set('max_input_time', '1800');
ini_set('memory_limit', '256M');
ini_set('post_max_size', '256M');
ini_set('upload_max_filesize', '256M');

session_start();

date_default_timezone_set('America/New_York');

require("lib/config.php");

if ($_GET["sandbox"])
  $_SESSION["sandbox"] = $_GET["sandbox"];
if (file_exists("shaversion.php") && $_SESSION["sandbox"] != "true") {
  include("shaversion.php");
  if ($shaversion != "" and file_exists($shaversion))
    header("Location: " . $shaversion);
}
if (file_exists("../shaversion.php"))
  include "../shaversion.php";

define("DBSERVER", $db_server);
define("SECURE", $secure);
define("DBNAME", $db_name);
define("DBUSER", $db_user);
define("DBPASSWORD", $db_password);
define("LIBRARY", $app_root);
define("LOGTYPE", $log_type);
define("LOGFOLDER", $log_folder);
define("DEBUG", $debug);
define("VERBOSE", $verbose);
define("VISUALERRORS", $visual_errors);


if ($_SERVER['HTTPS'] != "on" && SECURE) {
  $redirect = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
  header("Location: $redirect");
}

// ###################################################################
// ################# FRAMEWORK #######################################
// ###################################################################
// Load all classes


require_once LIBRARY . "lib/context.php";
require_once LIBRARY . "lib/log.php";
require_once LIBRARY . "lib/utils.class.php";

$architecture = array("lib", "models", "controllers");


foreach ($architecture as $loader) {

  $mydir = dir(LIBRARY.$loader."/");
  while (($file = $mydir->read())) {
    if (substr($file, 0, 1) != "." && substr($file, 0, 1) != "_") {
      if (DEBUG)
        logFactory::log($this, "Framework", " Loading [" . $file . "]..");
      require_once LIBRARY.$loader."/" . $file;
      if (DEBUG)
        logFactory::log($this, "Framework", "[" . $file . "] loaded successfully.");
    }
  }
}
?>