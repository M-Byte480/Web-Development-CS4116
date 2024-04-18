<?php

function encrypt($data)
{
    global $secret_encryption_key, $secret_encryption_method;
    require_once (__DIR__ . '/../secrets.settings.php');
    $key = $secret_encryption_key;
    $method = $secret_encryption_method;

    // Salt
    $salt = openssl_random_pseudo_bytes(openssl_cipher_iv_length($method));

    $encrypted = openssl_encrypt($data, $method, $key, 0, $salt);

    // Concatenate the $salt and the encrypted data
    $encrypted = base64_encode($salt . $encrypted);

    return $encrypted;
}

function decrypt($encrypted)
{
    global $secret_encryption_key, $secret_encryption_method;
    require_once (__DIR__ . '/../secrets.settings.php');
    $key = $secret_encryption_key;
    $method = $secret_encryption_method;

    // Decode the encrypted data
    $encrypted = base64_decode($encrypted);

    // Extract the $salt and the encrypted data
    $salt = substr($encrypted, 0, openssl_cipher_iv_length($method));
    $encrypted = substr($encrypted, openssl_cipher_iv_length($method));

    // Decrypt the data
    $decrypted = openssl_decrypt($encrypted, $method, $key, 0, $salt);

    // Display the decrypted data
    echo "Decrypted: " . $decrypted . "\n";
}



