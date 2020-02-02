<?php
function curl($url, $data = null, $headers = null, $proxy = null)
{
    $ch = curl_init();
    $options = array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_HEADER => true,
        CURLOPT_TIMEOUT => 30,
    );

    if ($proxy != "") {
        $options[CURLOPT_HTTPPROXYTUNNEL] = true;
        $options[CURLOPT_PROXYTYPE] = CURLPROXY_SOCKS4;
        $options[CURLOPT_PROXY] = $proxy;
    }


    if ($data != "") {
        $options[CURLOPT_POST] = true;
        $options[CURLOPT_POSTFIELDS] = $data;
    }

    if ($headers != "") {
        $options[CURLOPT_HTTPHEADER] = $headers;
    }

    curl_setopt_array($ch, $options);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

function fetch_value($str, $find_start, $find_end)
{
    $start = @strpos($str, $find_start);
    if ($start === false) {
        return "";
    }
    $length = strlen($find_start);
    $end    = strpos(substr($str, $start + $length), $find_end);
    return trim(substr($str, $start + $length, $end));
}
function get_token_cek_pubg() {
    $curl = curl("https://www.midasbuy.com/id/buy/pubgm");
    $id_token = fetch_value($curl, 'var token_', '="');
    $token = fetch_value($curl, 'var token_'.$id_token.'="', '"');
    return $token;
}
function cek_name_pubg($id) {
 $token = get_token_cek_pubg();
 $curl = curl('https://www.midasbuy.com/interface/getCharac?ctoken='.$token.'&appid=1450015065&currency_type=IDR&country=ID&midasbuyArea=SouthEastAsia&sc=&from=&task_token=&pf=mds_hkweb_pc-v2-android-midasweb&zoneid=1&_id=0.89205184795053&openid='.$id.'');
 $nama = urldecode(fetch_value($curl, '"charac_name":"', '"'));
 if ($nama) {
     echo "Nama : $nama\n";
 }  else {
    echo "ID : $id Tidak Ditemukan! \n";
 }
}
echo "ID PUGB ? : ";
$id = trim(fgets(STDIN));
if ($id != null) {
    cek_name_pubg($id);
} else {
   echo "Silahkan Masukan ID\n";
}