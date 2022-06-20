<?php

namespace app\traits;

trait RandomCookie
{
      public function randomCookie()
      {
          $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
          $pass = "";
          $alphabetLen = strlen($alphabet);
          for($i = 0; $i < 15; $i++)
          {
              $n = rand(0, $alphabetLen-1);
              $pass .= $alphabet[$n];
          }
          
          return $pass;
      }
}