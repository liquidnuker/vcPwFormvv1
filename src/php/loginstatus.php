<?php 
class LoginStatus {
  // ret array
  function setUser($username, $loggedin) {
     $userinfo = array(
      'loggedin' => $loggedin,
      'loggedinuser' => $username
     );
     return $userinfo; 
  } 
}

?>