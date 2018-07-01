<?php
//Sistem Informasi ini berbasis OPEN SOURCE dengan lisensi GNU/GPL. 
//
//OPEN SOURCE HAJIROBE dengan segala hormat tidak bertanggung jawab dan tidak memiliki pertanggungjawaban
//kepada apapun atau siapa pun akibat terjadinya kehilangan atau kerusakan yang mungkin muncul yang berasal
//dari buah karya ini.
//
//Sistem Informasi ini akan selalu dikembangkan dan jika ditemukan kesalahan logika ataupun kesalahan program,
//hal ini bukanlah disengaja. Melainkan hal tersebut adalah salah satu dari tahapan pengembangan lebih lanjut. 

//Sistem Informasi Sekolah (SISFOKOL) untuk SD v1.0, dikembangkan oleh OPEN SOURCE HAJIROBE (Agus Muhajir).
//Dan didistribusikan oleh BIASAWAE PRODUCTION (http://www.biasawae.com)
//
//Bila Anda mempunyai pertanyaan, komentar, saran maupun kritik layangkan saja ke hajirodeon@yahoo.com .
//Semoga program ini berguna bagi Anda.
//
//Ikutilah perkembangan terbaru Sistem Informasi ini di BIASAWAE PRODUCTION.

session_start();

///cek session
require("include/cek.php");  
	
  

//ambil nilai konfigurasi tertentu
include("../include/config.php"); 

//koneksi db
require_once('../Connections/sisfokol.php'); 

//fungsi-fungsi
include("../include/function.php"); 

$nocache;


//ambil nilai
$pageNum_rs1  = cegah($_REQUEST["pageNum_rs1"]);
$totalRows_rs1  = cegah($_REQUEST["totalRows_rs1"]);
$jurikod  = cegah($_REQUEST["jurikod"]);


$currentPage = $HTTP_SERVER_VARS["PHP_SELF"];

$maxRows_rs1 = 20;
$pageNum_rs1 = 0;
if (isset($HTTP_GET_VARS['pageNum_rs1'])) {
  $pageNum_rs1 = $HTTP_GET_VARS['pageNum_rs1'];
}
$startRow_rs1 = $pageNum_rs1 * $maxRows_rs1;

mysql_select_db($database_sisfokol, $sisfokol);

$query_rs1 = "SELECT m_siswa.*, siswa_kelas.* ".
				"FROM m_siswa, siswa_kelas ".
				"WHERE m_siswa.kd = siswa_kelas.kd_siswa ".
				"AND siswa_kelas.kd_kelas = '$kelikod' ".
				"AND siswa_kelas.status = 'true'";

					
$query_limit_rs1 = sprintf("%s LIMIT %d, %d", $query_rs1, $startRow_rs1, $maxRows_rs1);
$rs1 = mysql_query($query_limit_rs1, $sisfokol) or die(mysql_error());
$row_rs1 = mysql_fetch_assoc($rs1);

if (isset($HTTP_GET_VARS['totalRows_rs1'])) {
  $totalRows_rs1 = $HTTP_GET_VARS['totalRows_rs1'];
} else {
  $all_rs1 = mysql_query($query_rs1);
  $totalRows_rs1 = mysql_num_rows($all_rs1);
}
$totalPages_rs1 = ceil($totalRows_rs1/$maxRows_rs1)-1;

$queryString_rs1 = "";
if (!empty($HTTP_SERVER_VARS['QUERY_STRING'])) {
  $params = explode("&", $HTTP_SERVER_VARS['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rs1") == false && 
        stristr($param, "totalRows_rs1") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rs1 = "&" . implode("&", $newParams);
  }
}
$queryString_rs1 = sprintf("&totalRows_rs1=%d%s", $totalRows_rs1, $queryString_rs1);


//kelas
mysql_select_db($database_sisfokol, $sisfokol);
$query_rs_kelas = "SELECT * FROM m_kelas ORDER BY kelas ASC";
$rs_kelas = mysql_query($query_rs_kelas, $sisfokol) or die(mysql_error());
$row_rs_kelas = mysql_fetch_assoc($rs_kelas);
$totalRows_rs_kelas = mysql_num_rows($rs_kelas);

//keli
mysql_select_db($database_sisfokol, $sisfokol);
$query_rs_keli = "SELECT * FROM m_kelas ORDER BY kelas ASC";
$rs_keli = mysql_query($query_rs_keli, $sisfokol) or die(mysql_error());
$row_rs_keli = mysql_fetch_assoc($rs_keli);
$totalRows_rs_keli = mysql_num_rows($rs_keli);
				
//ruang
mysql_select_db($database_sisfokol, $sisfokol);
$query_rs_ruang = "SELECT * FROM m_ruang ORDER BY ruang ASC";
$rs_ruang = mysql_query($query_rs_ruang, $sisfokol) or die(mysql_error());
$row_rs_ruang = mysql_fetch_assoc($rs_ruang);
$totalRows_rs_ruang = mysql_num_rows($rs_ruang);

//rui
mysql_select_db($database_sisfokol, $sisfokol);
$query_rs_rui = "SELECT * FROM m_ruang ORDER BY ruang ASC";
$rs_rui = mysql_query($query_rs_rui, $sisfokol) or die(mysql_error());
$row_rs_rui = mysql_fetch_assoc($rs_rui);
$totalRows_rs_rui = mysql_num_rows($rs_rui);
?>
<html>
<head>
<title>Penempatan Siswa</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<META HTTP-EQUIV="REFRESH" CONTENT="<?php echo $lama_akses;?>;URL=../logout.php">
<link href="style/admin.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}

function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
</head>

<body bgcolor="#FFFFFF" text="#000000" leftmargin="5" topmargin="5" marginwidth="0" marginheight="0">
<div align="center">
  <?php include("include/header.php"); ?>
  <?php include("include/menu.php"); ?>
  <br>
  <table width="990" height="400" border="0" cellpadding="0" cellspacing="0">
    <tr valign="top"> 
      <td> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td><img src="images/adm_akt_penempatan_siswa.gif" width="328" height="40"></td>
          </tr>
          <tr> 
            <td><div align="right">
                <?php include("include/tapel.php"); ?>
              </div></td>
          </tr>
          <tr>
            <td><div align="right">
                <?php include("include/smt.php"); ?>
              </div></td>
          </tr>
        </table>
        <select name="keli" id="keli" onChange="MM_jumpMenu('parent',this,0)">
          <?
			if ($kelikod == "")
				{			
				?>
          <option selected>
                <?php 
				//jika kosong
					echo "--Pilih Kelas--";
				?>
                </option>
                <?
				}
				
			else
			
				{
				?>
                <option selected> 
                <?
			//kelas terpilih
			mysql_select_db($database_sisfokol, $sisfokol);
			$query_rs_kela = "SELECT * FROM m_kelas WHERE kd = '$kelikod'";
			$rs_kela = mysql_query($query_rs_kela, $sisfokol) or die(mysql_error());
			$row_rs_kela = mysql_fetch_assoc($rs_kela);
			$totalRows_rs_kela = mysql_num_rows($rs_kela);			
			?>
                <? 
					echo $row_rs_kela['kelas']; 
				?></option>
                <?
				}
			?>
                <?
			do 
				{  
				?>
                <option value="akt_penempatan.php?kelikod=<? echo $row_rs_keli['kd']; ?>&kelas=<? echo $row_rs_keli['kelas']?>"><? echo $row_rs_keli['kelas']?></option>
                <?
				} 
		
			while ($row_rs_keli = mysql_fetch_assoc($rs_keli));
			
			$rows = mysql_num_rows($rs_keli);
  				if($rows > 0) 
						{
      					mysql_data_seek($rs_keli, 0);
						$row_rs_keli = mysql_fetch_assoc($rs_keli);
  						}
		?>

              </select>

        <?
		if ($kelikod == "")
				{?>
        <br>
        <br>
        <table width="100%" height="300" border="0" cellpadding="0" cellspacing="0">
          <tr valign="top">
            <td><strong><font color="#FF0000">Kelas Belum Dipilih</font></strong></td>
  </tr>
</table>
        <? 
				
				}
			  
			  
			  ///nek isih kosong
	else if ($totalRows_rs1 == 0)
		{
		?>
<br><br>        <table width="100%" height="300" border="0" cellpadding="0" cellspacing="0">
          <tr valign="top">
            <td> <font color="#FF0000"><strong>TIDAK ADA DATA SISWA</strong></font> 
            </td>
          </tr>
        </table>
		<?
		}
			else if ($totalRows_rs1 != 0)//nek eneng isine...
	  	{ 
	?>
        <br>
        <br>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr> 
              <td> <div align="right"> </div></td>
            </tr>
          </table>
          
        <table width="434" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC" bgcolor="#66CCCC">
          <tr> 
            <td width="100"><font color="#FFFFFF"><strong>NIS</strong></font></td>
            <td width="163"><font color="#FFFFFF"><strong>Nama</strong></font></td>
            <td width="63"><font color="#FFFFFF"><strong>Kelas </strong></font></td>
            <td width="82"><font color="#FFFFFF"><strong>Ruang</strong></font></td>
          </tr>
        </table>
        <table width="434" border="1" cellpadding="3" cellspacing="0" bordercolor="#CCCCCC">
          <?php 	
		do { 
		
		
		if ($warna_set ==0)
			{
			$warna = '#F8F8F8';
			$warna_set = 1;
			}
		
		else
			
			{
			$warna = '#F0F4F8';
			$warna_set = 0;
			}
		?>
          <tr valign="top" bgcolor="<? echo $warna; ?>"> 
            <td width="99"> 
              <?php 
			echo $row_rs1['nis']; 
			?> </td>
            <td width="161"> 
              <?php 
			echo $row_rs1['nama']; 
			?> </td>
            <td width="61"><select name="kelas" id="kelas" onChange="MM_jumpMenu('parent',this,0)">
                <?
			if ($_REQUEST['kelkod'] == "")
				{
				//kelasi
				$kd_siswa = $row_rs1['kd'];
				
				mysql_select_db($database_sisfokol, $sisfokol);
				$query_rs_kelasi = "SELECT m_kelas.*, siswa_kelas.* FROM m_kelas, siswa_kelas ".
									"WHERE m_kelas.kd = siswa_kelas.kd_kelas ".
									"AND status = 'true' AND kd_siswa = '$kd_siswa'";
				$rs_kelasi = mysql_query($query_rs_kelasi, $sisfokol) or die(mysql_error());
				$row_rs_kelasi = mysql_fetch_assoc($rs_kelasi);
				$totalRows_rs_kelasi = mysql_num_rows($rs_kelasi);
				?>
                <option selected><?php echo $row_rs_kelasi['kelas']; ?></option>
                <?
				}
				
			else
			
				{
				?>
                <option selected> 
                <?
			//kelas terpilih
			mysql_select_db($database_sisfokol, $sisfokol);
			$query_rs_terkel = "SELECT * FROM m_kelas WHERE kd = '$kelkod'";
			$rs_terkel = mysql_query($query_rs_terkel, $sisfokol) or die(mysql_error());
			$row_rs_terkel = mysql_fetch_assoc($rs_terkel);
			$totalRows_rs_terkel = mysql_num_rows($rs_terkel);			
			?>
                <? echo $row_rs_terkel['kelas']; ?></option>
                <?
				}
			?>
                <?
			do 
				{  
				?>
                <option value="akt_penempatan1.php?kd_siswa=<?php echo $kd_siswa;?>&inc_tapel=<?php echo $inc_tapel;?>&kelikod=<?php echo $_REQUEST['kelikod'];?>&kelas=<?php echo $_REQUEST['kelas'];?>&kelkod=<? echo $row_rs_kelas['kd'] ?>&kelas=<? echo $row_rs_kelas['kelas'] ?>"><? echo $row_rs_kelas['kelas']?></option>
                <?
				} 
		
			while ($row_rs_kelas = mysql_fetch_assoc($rs_kelas));
			
			$rows = mysql_num_rows($rs_kelas);
  				if($rows > 0) 
						{
      					mysql_data_seek($rs_kelas, 0);
						$row_rs_kelas = mysql_fetch_assoc($rs_kelas);
  						}
		?>
              </select>
              &nbsp;</td>
            <td width="79"><select name="ruang" id="ruang" onChange="MM_jumpMenu('parent',this,0)">
                <?
			if ($_REQUEST['rukod'] == "")
				{
				//ruangi
				$kd_siswa = $row_rs1['kd'];
				
				mysql_select_db($database_sisfokol, $sisfokol);
				$query_rs_ruangi = "SELECT m_ruang.*, siswa_ruang.* FROM m_ruang, siswa_ruang ".
									"WHERE m_ruang.kd = siswa_ruang.kd_ruang ".
									"AND status = 'true' AND kd_siswa = '$kd_siswa'";
				$rs_ruangi = mysql_query($query_rs_ruangi, $sisfokol) or die(mysql_error());
				$row_rs_ruangi = mysql_fetch_assoc($rs_ruangi);
				$totalRows_rs_ruangi = mysql_num_rows($rs_ruangi);
				?>
                <option selected> 
                <?php 
				//jika kosong
				if ($row_rs_ruangi['ruang'] == "")
					{
					echo "--Pilih Ruang--";
					}
				
				else
					{				
					echo $row_rs_ruangi['ruang']; 
					}
				?>
                </option>
                <?
				}
				
			else
			
				{
				?>
                <option selected> 
                <?
			//ruang terpilih
			mysql_select_db($database_sisfokol, $sisfokol);
			$query_rs_ru = "SELECT * FROM m_ruang WHERE kd = '$rukod'";
			$rs_ru = mysql_query($query_rs_ru, $sisfokol) or die(mysql_error());
			$row_rs_ru = mysql_fetch_assoc($rs_ru);
			$totalRows_rs_ru = mysql_num_rows($rs_ru);			
			?>
                <? echo $row_rs_ru['ruang']; ?></option>
                <?
				}
			?>
                <?
			do 
				{  
				?>
                <option value="akt_penempatan1.php?kd_siswa=<?php echo $kd_siswa;?>&inc_tapel=<?php echo $inc_tapel;?>&kelikod=<?php echo $_REQUEST['kelikod'];?>&kelas=<?php echo $_REQUEST['kelas'];?>&rukod=<? echo $row_rs_ruang['kd'] ?>&ruang=<? echo $row_rs_ruang['ruang'] ?>"><? echo $row_rs_ruang['ruang']?></option>
                <?
				} 
		
			while ($row_rs_ruang = mysql_fetch_assoc($rs_ruang));
			
			$rows = mysql_num_rows($rs_ruang);
  				if($rows > 0) 
						{
      					mysql_data_seek($rs_ruang, 0);
						$row_rs_ruang = mysql_fetch_assoc($rs_ruang);
  						}
		?>
              </select> &nbsp;</td>
          </tr>
          <?php } while ($row_rs1 = mysql_fetch_assoc($rs1)); ?>
        </table>
        <br> <br> <?php if ($pageNum_rs1 > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_rs1=%d%s", $currentPage, 0, $queryString_rs1); ?>">Awal</a> 
        <?php 
		  		}
		  else
		  		{
				?>
        <font color="#CCCCCC">Awal</font> 
        <?
		  } // Show if not first page ?> <?php if ($pageNum_rs1 > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_rs1=%d%s", $currentPage, max(0, $pageNum_rs1 - 1), $queryString_rs1); ?>">Sebelumnya</a> 
        <?php 
		  		}
		  else
		  		{
				?>
        <font color="#CCCCCC">Sebelumnya</font> 
        <?
		  } // Show if not first page ?> <?php if ($pageNum_rs1 < $totalPages_rs1) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_rs1=%d%s", $currentPage, min($totalPages_rs1, $pageNum_rs1 + 1), $queryString_rs1); ?>">Selanjutnya</a> 
        <?php 
		  		}
		  else
		  		{?>
        <font color="#CCCCCC">Selanjutnya</font> 
        <?
		  } // Show if not last page ?> <?php if ($pageNum_rs1 < $totalPages_rs1) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_rs1=%d%s", $currentPage, $totalPages_rs1, $queryString_rs1); ?>">Terakhir</a> 
        <?php 
		  		}
		  else
		  		{?>
        <font color="#CCCCCC">Terakhir</font> 
        <?
		  } // Show if not last page 
		  
		  }
		  
		  
		  
		  ?>
</td>
    </tr> 
  </table>
  <br>
  <?php include("include/footer.php"); ?>
</div>
</body>
</html>
<?php 
mysql_close($sisfokol);
?>