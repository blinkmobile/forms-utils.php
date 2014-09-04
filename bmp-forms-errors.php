<?php
namespace blinkmobile\forms\utils\errors;

class Validation
{
  private $errors = array();

  function __construct ($errorList)
  {
    $this->convertToNewFormat($errorList);
  }

  public function getMessage ($field, $msg)
  {
    $pos = strrpos($msg, '/ ');

    if ($pos === false) {
      $message = $msg;
    } else {
      $message = substr($msg, $pos + 1);
    }
    return $message;
  }

  private function convertToNewFormat ($errorsList = null)
  {
    if (!empty($errorsList)) {
      //converting array into $fieldPath => $message
      foreach ($errorsList as $key => $value) {
        $message = $this->getMessage($key, $value);
        $pos = strrpos($key, '/');

        if ($pos === false) {
          $this->errors[$key] = $message;
        } else {
          $this->setMessage($key, $message);
        }//end else ($pos === false)
      }// end foreach
    }// end if
  }

  private function setMessage ($path, $msg)
  {
    $path = str_replace(']/', '/', $path);
    $path = str_replace('[', '/', $path);
    $path = trim($path, '/');
    $fields = explode('/', $path);
    $temp =& $this->errors;
    foreach ($fields as $field) {
        if (!isset($temp[$field])) {
            $temp[$field] = array();
        }
        $temp =& $temp[$field];
    }
    $temp = $msg;
  }

  public function getErrors ()
  {
    return empty($this->errors)? null: $this->errors;
  }
}
