<?php
// Ilyasa Fathur Rahman
// SGB-Team Reborn
set_time_limit(0);
error_reporting(0);
echo '####################################';
echo "\r\n";
echo '# Copyright : @ilyasa48 | SGB-Team #';
echo "\r\n";
echo '####################################';
echo "\r\n";
echo 'Masukkan Kode Referral (1020991) : '; 
$referral = trim(fgets(STDIN)); 
echo 'Masukkan Jumlah : '; 
$jumlah = trim(fgets(STDIN)); 
echo 'Masukkan Waktu Delay (Detik) : '; 
$delay = trim(fgets(STDIN)); 
$i=1;
while($i <= $jumlah){
echo "\r\n";
echo "[$i] [".date('h:i:s')."] Membuat email...";
echo "\r\n";
ulang_register:

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://froidcode.com/api/treasure-raiders/register.php?create=yes");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close ($ch);
$register = json_decode($result);

if($register->result == 1){
    $email = $register->content;
}else if($register->content == "email digunakan oleh user lain"){
    echo "[$i] [".date('h:i:s')."] Email telah digunakan, membuat email ulang...";
    echo "\r\n";
    goto ulang_register;
}else if($register->result == 0){
    echo "[$i] [".date('h:i:s')."] $register->content";
    echo "\r\n";
    exit();
}else{
    echo "[$i] [".date('h:i:s')."] Server FroidCode Down/Error [1]";
    echo "\r\n";
    exit();  
}

echo "[$i] [".date('h:i:s')."] Email : $email";
echo "\r\n";

echo "[$i] [".date('h:i:s')."] Memeriksa email...";
echo "\r\n";
ulang_email:
sleep(2);
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://froidcode.com/api/treasure-raiders/get_email.php?email=$email");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close ($ch);
$get_email = json_decode($result);

if($get_email->result == 1){
    $code = $get_email->content;
}else if($get_email->content == "Email belum masuk"){
    echo "[$i] [".date('h:i:s')."] Email belum masuk, memeriksa email ulang...";
    echo "\r\n";
    goto ulang_email;
}else{
    echo "[$i] [".date('h:i:s')."] Server FroidCode Down/Error [2]";
    echo "\r\n";
    exit();  
}

echo "[$i] [".date('h:i:s')."] Kode Aktivasi : $code";
echo "\r\n";
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://froidcode.com/api/treasure-raiders/finish.php?email=$email&code=$code&referral=$referral");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close ($ch);
$finish = json_decode($result);

if($finish->result == 1){
    echo "[$i] [".date('h:i:s')."] ".$finish->content."";
    echo "\r\n";
}else if($finish->result == 0){
    echo "[$i] [".date('h:i:s')."] ".$finish->content."";
    echo "\r\n";
}else{
    echo "[$i] [".date('h:i:s')."] Server FroidCode Down/Error [3]";
    echo "\r\n";
    exit();  
}
$i++;
sleep($delay);
}