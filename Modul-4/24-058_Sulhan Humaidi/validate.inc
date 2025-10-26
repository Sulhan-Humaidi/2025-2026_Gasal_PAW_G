<?php
// Fungsi diubah untuk menerima $errors sebagai referensi (&)
function validateName(&$errors, $field_list, $field_name)
{
    if (!isset($field_list[$field_name]) || empty($field_list[$field_name]))
    {

        $errors[$field_name] = 'tidak boleh kosong';
        return false;
    }

    $pattern = "/^[a-zA-Z'-]+\$/"; // format nama (alfabet)
    if (!preg_match($pattern, $field_list[$field_name]))
    {
       
        $errors[$field_name] = 'tidak sesuai format';
        return false;
    }
    
    return true;
}
?>