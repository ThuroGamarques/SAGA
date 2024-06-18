<?php
session_start();
$con = mysqli_connect('localhost', 'root', '', 'saga_db');
// $con = mysqli_connect('localhost', 'root', 'usbw', 'saga_db');

if (isset($_SESSION['ativ']))
{
    $matr = $_POST["matr"];
    $codg = $_SESSION["ativ"];

    $cmd = "SELECT * FROM aluno WHERE regx_user=(SELECT regx_user FROM usuario WHERE codg_user='$codg')";
    $rst = mysqli_query($con, $cmd);

    while ($r = mysqli_fetch_array($rst))
    {
        $regx = $r[1];
        $cicl = $r[3] + 1;
        $_ano = date('Y');
        $_sem = date('n') >= 1 && date('n') <= 6 ? '2' : '1';
    }

    foreach ($matr as $iden)
    {
        $data[] = ['regx_user' => intval($regx),
                   'iden_matr' => intval($iden),
                   'ntp1_crsn' => 0.00,
                   'ntp2_crsn' => 0.00,
                   'ntp3_crsn' => 0.00,
                   'nttt_crsn' => 0.00,
                   'falt_crsn' => 0,
                   'cicl_alun' => "$cicl",
                   '_ano_crsn' => $_ano,
                   '_sem_crsn' => $_sem,
                   'situ_crsn' => 'Em Curso'];
    }

    foreach ($data as $json)
    {
        $data_json = json_encode($json);

        echo "JSON enviado: $data_json";

        $ch = curl_init("http://localhost:8080/aux/cursando/insert");

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER,
        [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_json)
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);

        $response = curl_exec($ch);

        if (curl_errno($ch)) 
        {
            $response = 'Erro cURL: ' . curl_error($ch);
        }
        else
        {
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            
            if ($http_code >= 400) $response = "Erro HTTP: $http_code";
        }

        curl_close($ch);
    }

    echo $response;
}
else
{
    header("location:..");
}
?>