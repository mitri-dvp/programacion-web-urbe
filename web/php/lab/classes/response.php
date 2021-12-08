<?php
class Response {
  public $error = TRUE;
  function __construct($error){
    $this->error = $error;
  }
};
?>