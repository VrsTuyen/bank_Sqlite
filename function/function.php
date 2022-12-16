<?php
function gender($gender)
{
  return strToLower($gender) == 'm' ? 'Male' : 'Female';
}

function checkPermission($permissions, $permission)
{
  return in_array($permission, $permissions);
}
?>