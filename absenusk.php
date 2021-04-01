<?php
error_reporting(0);
function curl($url, $ua, $data = null){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookieabsen.txt');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $ua);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	$result = curl_exec($ch);
	return $result;
}
function getcok($url, $ua = null){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookieabsen.txt');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $ua);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	$result = curl_exec($ch);
	return $result;
}
function absen($url, $ua, $data2 = null){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookieabsen.txt');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $ua);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data2);
	$result = curl_exec($ch);
	return $result;
}
$ua = array(
    "accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
    "accept-language: en-GB,en-US;q=0.9,en;q=0.8,id;q=0.7",
    "content-type: application/x-www-form-urlencoded",
    "origin: https://simkuliah.unsyiah.ac.id",
    "referer: https://simkuliah.unsyiah.ac.id/index.php/login",
    "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36"
);
echo "Absensi Mahasiswa USK\n";
echo "[*] Masukkan NPM: ";
$npm = trim(fgets(STDIN));
echo "[*] Masukkan Password: ";
$pass = trim(fgets(STDIN));
$data = "username=$npm&password=$pass";
$cookie = getcok("https://simkuliah.unsyiah.ac.id/index.php/absensi", $ua);
$login = curl("https://simkuliah.unsyiah.ac.id/index.php/login", $ua, $data);
$kelas = explode("var kd_mt_kul_8 = '", $login);
$kelas = explode("'", $kelas[1]);
$kd_mt_kul = $kelas[0];
$mulai = $kelas[2];
$akhir = $kelas[4];
$pertemuan = $kelas[6];
$sks = $kelas[8];
$id = $kelas[10];
$kelas_new = $kelas[18];
if(isset($kelas[1])){
	$data2 = "kelas=$kelas_new&kd_mt_kul8=$kd_mt_kul&jadwal_mulai=$mulai&jadwal_berakhir=$akhir&pertemuan=$pertemuan&sks_mengajar=$sks&id=$id";
	$absen = absen("https://simkuliah.unsyiah.ac.id/index.php/absensi/konfirmasi_kehadiran", $ua, $data2);
	if($absen == "success"){
		echo "Absen berhasil";
	}
	else{
		echo "Belum masuk jadwal absen";
	}
}
else{
	echo "Login gagal";
}
?>