<?php

// $required_fields_array - array containing the list of all required fields
// $form_errors  - return array, containing all errors

function check_empty_fields($required_fields_array) {
    //initialise an array to store error messages
    $form_errors = array();

    //loop through the required fields array, populate the form error array
    foreach ($required_fields_array as $name_of_field) {
        if (!isset($_POST[$name_of_field]) || $_POST[$name_of_field] == NULL) {
            $form_errors[] = $name_of_field . " is a required field";
        }
    }
    return $form_errors;
}

//$fields_to_check_length array of fields to check min length

function check_min_length($fields_to_check_length) {
    //initialise an array to store error messages
    $form_errors = array();

    foreach ($fields_to_check_length as $name_of_field => $minimum_length_required) {
        if (strlen(trim($_POST[$name_of_field])) < $minimum_length_required) {
            $form_errors[] = $name_of_field . " is too short, must be {$minimum_length_required} characters long";
        }
    }
    return $form_errors;
}

//Check for valid email address
function check_email($data) {
    //initialise an array to store error messages
    $form_errors = array();
    $key = 'email';
    //check if the key email exist in data array
    if (array_key_exists($key, $data)) {
        //check if the email field has a value
        if ($_POST[$key] != null) {

            // Remove all illegal characters from email
            $key = filter_var($key, FILTER_SANITIZE_EMAIL);
            //check if input is a valid email address
            if (filter_var($_POST[$key], FILTER_VALIDATE_EMAIL) === false) {
                $form_errors[] = $key . " is not a valid email address";
            }
        }
    }
    return $form_errors;
}
