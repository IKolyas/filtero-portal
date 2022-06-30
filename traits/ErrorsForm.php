<?php

namespace app\traits;

use app\base\Request;

trait ErrorsForm
{
      public function setErrors($errors, $oldFields, $tab)
      {
          $info = [];
          $info['errorsFields'] = $errors;
          $info['oldFields'] = $oldFields;
          app()->session->set($tab, $info);
      }

      public function getErrors($tab)
      {
        $sessionInfo = app()->session->get($tab);

        $errorsFields = [];
        $oldFields = [];

        if (isset($sessionInfo['errorsFields']) && !empty($sessionInfo['errorsFields'])) {
            $errorsFields = $sessionInfo['errorsFields'];
        }

        if (isset($sessionInfo['oldFields']) && !empty($sessionInfo['oldFields'])) {
            $oldFields = $sessionInfo['oldFields'];
        }

        return array($errorsFields, $oldFields);
      }
}