<?php
  define('BASE_DIR', dirname(__FILE__));
  require_once(BASE_DIR.'/config.php');
  
//Added for HS light control
   function toggle_light() {
     $lightStatus = shell_exec('gpio -g read 21');
     if ($lightStatus == 0) {
	shell_exec('gpio -g write 21 on');
	shell_exec('gpio -g write 13 off');
     }
     else {
	shell_exec('gpio -g write 21 off');
	shell_exec('gpio -g write 13 on');
     }
   }

  function disable_inhibit() {
     $lightStatus = shell_exec('gpio -g read 21');
     if ($lightStatus == 0) 
      shell_exec('gpio -g write 13 on');
  }
     

  function sys_cmd($cmd) {
    if(strncmp($cmd, "reboot", strlen("reboot")) == 0) {
      shell_exec('sudo shutdown -r now');
    } else if(strncmp($cmd, "shutdown", strlen("shutdown")) == 0) {
      shell_exec('sudo shutdown -h now');
//Added for HS light control
    } else if(strncmp($cmd, "light", strlen("light")) == 0) {
      toggle_light();
    } else {
      // unknown
    }
  }


  if(isset($_GET['cmd'])) {
    $cmd=$_GET['cmd'];
    sys_cmd($cmd);
  }

?>
