<?php
global $db_host, $db_username, $db_password, $db_database, $db_some_secret, $secret_encryption_method, $secret_encryption_key;
require_once (__DIR__ . '/../secrets.settings.php');

function encrypt($data)
{
    global $secret_encryption_key, $secret_encryption_method;

    $salt = openssl_random_pseudo_bytes(openssl_cipher_iv_length($secret_encryption_method));

    $encrypted = openssl_encrypt($data, $secret_encryption_method, $secret_encryption_key, 0, $salt);

    // Concatenate the $salt and the encrypted data
    return base64_encode($salt . $encrypted);
}

function decrypt($encrypted)
{
    global $secret_encryption_key, $secret_encryption_method;

    // Decode the encrypted data
    $encrypted = base64_decode($encrypted);

    $salt = substr($encrypted, 0, openssl_cipher_iv_length($secret_encryption_method));
    $encrypted = substr($encrypted, openssl_cipher_iv_length($secret_encryption_method));

    // Decrypt the data
    return openssl_decrypt($encrypted, $secret_encryption_method, $secret_encryption_key, 0, $salt);
}



