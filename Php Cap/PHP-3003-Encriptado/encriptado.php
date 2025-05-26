<?php
$key = "Enelaguaclaraquebrotaenlafuenteunlindopescadosalederepente";

function encriptar($data, $key)
{
  $llaveEncriptada = base64_decode($key);
  $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length("aes-256-cbc"));
  $cadena = openssl_encrypt($data, "aes-256-cbc", $llaveEncriptada,0,$iv);
  return base64_encode($cadena."::".$iv);
}

function desencriptar($data, $key)
{
  $llaveEncriptada = base64_decode($key);
  $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length("aes-256-cbc"));
  list($cadena,$iv) = array_pad(explode("::",base64_decode($data),2),2,null);
  return openssl_decrypt($cadena, "aes-256-cbc", $llaveEncriptada,0,$iv);
}

$cadena = "Lindo pescadito, no quieres salir? a jugar con mi aro, vamos al jardin";
print $cadena."<br>";
$cadena = encriptar($cadena,$key);
print $cadena."<br>";
$cadena = desencriptar($cadena,$key);
print $cadena."<br>";
?>