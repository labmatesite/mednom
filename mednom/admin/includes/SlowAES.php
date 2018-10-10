<?php

require_once __DIR__ . '/SlowAES/aes_fast.php';
require_once __DIR__ . '/SlowAES/cryptoHelpers.php';

/*
 * Encrypts and decrypts plaintext with a given key.  Written to be compatible
 * with it's counterpart in js.  Uses AES.  Uses the slowAES encryption lib,
 * which is more than fast enough for our purposes; using it here because it
 * has several parallel versions in different languages (mainly php and js).
 *
 * Usage: Encrypt takes any string as the plaintext and any string as the key.
 *      Decrypt takes the output of encrypt and the same key used to encrypt.
 *
 * Details you might care about:
 *      The encryption output is really 3 space-seperated strings: 
 *      - The length of the original plaintext string as an integer
 *      - The Initialization Vector (iv).  This is just a random string that
 *        will be different each encryption, and can be sent in the clear
 *        with the ciphertext.  This is a hex string.
 *      - The ciphertext itself, as a hex string.
 *
 * Crypto details you won't care about unless you're setting up another set of
 * methods to match these ones:
 *      - AES (Rijndael, or very close, I think)
 *      - 256 bit key
 *      - 128 bit IV
 *      - CBC mode
 *
 **/
function slowaes_encrypt( $plaintext, $key ){

    // Set up encryption parameters.
    $plaintext_utf8 = utf8_encode($plaintext);
    $inputData = cryptoHelpers::convertStringToByteArray($plaintext);
    $keyAsNumbers = cryptoHelpers::toNumbers(bin2hex($key));
    $keyLength = count($keyAsNumbers);
    $iv = cryptoHelpers::generateSharedKey(16);

    $encrypted = AES::encrypt(
        $inputData,
        AES::modeOfOperation_CBC,
        $keyAsNumbers,
        $keyLength,
        $iv
    );

    // Set up output format (space delimeted "plaintextsize iv cipher")
    $retVal = $encrypted['originalsize'] . " "
        . cryptoHelpers::toHex($iv) . " "
        . cryptoHelpers::toHex($encrypted['cipher']);

    return $retVal;
}

function slowaes_decrypt( $input, $key ){

    // Split the input into its parts
    $cipherSplit = explode( " ", $input);
    $originalSize = intval($cipherSplit[0]);
    $iv = cryptoHelpers::toNumbers($cipherSplit[1]);
    $cipherText = $cipherSplit[2];

    // Set up encryption parameters
    $cipherIn = cryptoHelpers::toNumbers($cipherText);
    $keyAsNumbers = cryptoHelpers::toNumbers(bin2hex($key));
    $keyLength = count($keyAsNumbers);

    $decrypted = AES::decrypt(
        $cipherIn,
        $originalSize,
        AES::modeOfOperation_CBC,
        $keyAsNumbers,
        $keyLength,
        $iv
    );

    // Byte-array to text.
    $hexDecrypted = cryptoHelpers::toHex($decrypted);
    $retVal = pack("H*" , $hexDecrypted);

    return $retVal;
}

//echo slowaes_decrypt('133 bd3300014d97e839cacc706c103bb5fd08cf489bd8408be456c4a0c057874409 c82083f2ecd5f303314b7426f09175e3a830198a845a178c4d990a121fa415547f7091d8f0ea49ea093209bbd34900b37b3afd6343f730cb4e22fd3a0d0e0f4e21390fbd47210c4fba67f55c71d130bf35f68252c1fbd4723796a25fb3480bf2b882315930f1386c80d4100f115c71316772a9696c29e29250baf832f0e67a28a15a8fba52729c2f44c4713b1c9040d5', 'B@nanablu3');
//echo hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE));
//echo slowaes_encrypt('helloworld','hello');
//echo slowaes_decrypt(slowaes_encrypt('helloworld','hello'),'helloo');