<?php
  require_once('db_functions.php');
  require_once('user_functions.php');

  destroy_auth_db();
  destroy_enterprise_db();

  /* for demo app only, make sure we've created sqlite auth db */
  if (!auth_db_initialized()) { initialize_auth_db(); }
  
  /* for demo app only, make sure we've created sqlite enterprise db */
  if (!enterprise_db_initialized()) { initialize_enterprise_db(); }

  require_once('lib.php');

?>
