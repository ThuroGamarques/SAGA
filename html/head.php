<link rel="shortcut icon" type="img/png" href="img/logos/logo-colors.png">
<title>SAGA</title>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="css/styles.css">
<link rel="stylesheet" href="css/studnt.css">
<link rel="stylesheet" href="css/homepg.css">
<link rel="stylesheet" href="css/mybook.css">
<link rel="stylesheet" href="css/calend.css">
<link rel="stylesheet" href="css/rqests.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<script type="text/javascript" src="js/dataformat.js"></script>
<script type="text/javascript" src="js/animations.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<?php
// /* WAMP --> */ $conn = mysqli_connect('localhost', 'root', '', 'saga_db');
/* USBW --> */ $conn = mysqli_connect('localhost', 'root', 'usbw', 'saga_db');

session_start();

if (isset($_SESSION['ativ']))
{
	$ativ = $_SESSION['ativ'];

	$cmd1 = "SELECT flag_user FROM usuario WHERE codg_user='$ativ'";
	$rst1 = mysqli_query($conn, $cmd1);

	while ($a = mysqli_fetch_array($rst1)) $flag = $a[0];

	switch ($flag)
	{
		case 'A':
			$cmd2 = "SELECT u.regx_user,u.mail_user,u.nome_user,c.nome_curs,a.cicl_alun,u.codg_user,
					u.senh_user,u.fone_user,u.foto_user
			FROM usuario AS u INNER JOIN aluno AS a ON u.regx_user=a.regx_user 
							INNER JOIN curso AS c ON a.curs_alun=c.codg_curs
			WHERE u.flag_user='A' AND u.codg_user='$ativ'";
			$rst2 = mysqli_query($conn, $cmd2);

			while ($b = mysqli_fetch_array($rst2))
			{
				$rmat = $b[0];
				$mail = $b[1];
				$name = $b[2];
				$curs = $b[3];
				$cicl = $b[4];
				$codg = $b[5];
				$pass = $b[6];
				$fone = $b[7];
				$imge = $b[8];
			}
		break;
		
		case 'S':
		break;

		case 'F':
		break;
	}
}
?>