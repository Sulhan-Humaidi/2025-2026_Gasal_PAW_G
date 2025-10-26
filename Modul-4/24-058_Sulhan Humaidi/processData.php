<?php
require 'validate.inc';

$errors = [];
if (validateName($errors, $_POST, 'surname'))
{
    echo 'Data OK!';
} 
else 
{
    echo 'Data invalid! <br>';
    foreach ($errors as $field => $error_message) {
        echo $field . ': ' . $error_message;
    }
}
?>