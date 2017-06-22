<?php
class RSA{
  function getRSA($plaintext, $public_key){
    // 용량 절감과 보안 향상을 위해 평문을 압축한다.
      
    // $plaintext = gzcompress($plaintext);
      
    // 공개키를 사용하여 암호화한다.
      
    $pubkey_decoded = @openssl_pkey_get_public($public_key);
    if ($pubkey_decoded === false) return false;
      
    $ciphertext = false;
    $status = @openssl_public_encrypt($plaintext, $ciphertext, $pubkey_decoded);
    if (!$status || $ciphertext === false) return false;
      
    // 암호문을 base64로 인코딩하여 반환한다.
    return base64_encode($ciphertext);
  }

  function deRSA($ciphertext, $private_key, $password){
    // 암호문을 base64로 디코딩한다.
    $ciphertext = @base64_decode($ciphertext, true);
    if ($ciphertext === false) return false;
      
    // 개인키를 사용하여 복호화한다.
      
    $privkey_decoded = @openssl_pkey_get_private($private_key, $password);
    if ($privkey_decoded === false) return false;
      
    $plaintext = false;
    $status = openssl_private_decrypt($ciphertext, $plaintext, $privkey_decoded);
    @openssl_pkey_free($privkey_decoded);
    if (!$status || $plaintext === false) return false;
      
    // 압축을 해제하여 평문을 얻는다.
      
    //  $plaintext = @gzuncompress($plaintext);
    if ($plaintext === false) return false;
      
    // 이상이 없는 경우 평문을 반환한다.
      
    return $plaintext;
  }
}