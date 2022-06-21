<?php

namespace app\services;
use Exception;

define("DEBUG", 1);

class Exceptions 
{
      public function __construct()
      {
            if(DEBUG) {
                  error_reporting(-1);  //показываем ошибки
            } else {
                  error_reporting(0);  //скрываем ошибки
            }

            set_error_handler([$this, 'errorHandler']);                         // перехватываем ошибки (метод (set_error_handler) для пользовательских обработчиков ошибок) 
            ob_start();                                                        // буферизация (в обработчике фатальных ошибок выключается вывод исключения встроенной функцией php)
            register_shutdown_function([$this, 'fatalErrorHandler']);         // перехватываем фатальные ошибки
            set_exception_handler([$this, 'exeptionHandler']);               // позволяет зарегистрировать собственных обработчик исключений
            
      }

      // Метод вывода ошибок в шаблоне

      protected function displayError($errno, $errstr, $errfile , $errline = 5)
      {          
            if(DEBUG){
                  app()->renderer->render('exceptions.index', [$errno, $errstr, $errfile, $errline]);
            }
            die();
      }


      // Метод обработки ошибок

      public function errorHandler($errno, $errstr, $errfile = ' ', $errline = 5)   
      {
            $this->displayError($errno, $errstr, $errfile, $errline);
            return true;
      }


      // Метод обработки фатальных ошибок

      public function fatalErrorHandler()
      {
            $error = error_get_last(); //получении информации о последней произошедшей ошибки
            
            if(!empty($error) && $error['type'] & (E_ERROR | E_PARSE | E_COMPILE_ERROR | E_CORE_ERROR))
            {
                  ob_end_clean(); // очищаем буфер
                  $this->displayError($error['type'], $error['message'], $error['file'], $error['line']); //выводим ошибку в шаблоне
            } else {
                  ob_end_flush(); // отключаем буферизацию вывода исключений
            }

      }

      // Собственный обработчик исключений 

      public function exeptionHandler(Exception $e)
      {
            $this->displayError('Исключение', $e->getMessage(), $e->getFile(), $e->getLine());
      }

}