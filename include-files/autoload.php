<?php
  include 'env.php';
  
  if (!function_exists('env')) {
      function env($key, $default = null)
      {
          $value = getenv($key);
          if (!$value) {
              return $default;
          }
          return $value;
      }
  }
