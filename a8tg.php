<?php
if(@$_GET['do'] == 'php'){
    phpinfo();
    exit();
}

$http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
$url=$http_type.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?do=php';
$Body=file_get_contents($url);

//判断操作系统
preg_match_all('/<tr><td class="e">System\b[ \t]*<\/td>[^\r\n]+/i', $Body, $result);
if(!$result[0])exit('未获取到数据!');
preg_match_all('/\bWindows\b/i', $result[0][0], $result);
if($result[0]){
	$System='Windows';
}else{
	$System='Linux';
}

//判断PHP版本
preg_match_all('/<h1 class="p">PHP Version [\d.]+<\/h1>/i', $Body, $result);
preg_match_all('/\d+\.\d+(?=\.)/i', $result[0][0], $result);
$phpver=$result[0][0];

//判断PHP架构
preg_match_all('/<tr><td class="e">Architecture\b[ \t]*<\/td>[^\r\n]+/i', $Body, $result);
preg_match_all('/>x86\b/i', $result[0][0], $result);
$x86=($result[0])?1:0;
preg_match_all('/<tr><td class="e">Architecture\b[ \t]*<\/td>[^\r\n]+/i', $Body, $result);
preg_match_all('/>x64\b/i', $result[0][0], $result);
$x64=($result[0])?1:0;

if($x86){
	$Architecture='x86';
	$Architecture_='x86(32位)';
}else if($x64){
	$Architecture='x64';
	$Architecture_='x64(64位)';
}else{	//有的PHP版本中没有该项(如有CentOS系统中的PHP7.0版本没有该项，x86-64需要用64位的扩展)
	if($phpver*1 >= 7){
		$Architecture='x64';
		$Architecture_='x64(64位)';
	}else{
		$Architecture='x86';
		$Architecture_='x86(32位)';
	}
}

//判断PHP线程安全
preg_match_all('/<tr><td class="e">Thread Safety\b[ \t]*<\/td>[^\r\n]+/i', $Body, $result);
preg_match_all('/>enabled\b/i', $result[0][0], $result);
if($result[0]){
	$Thread='ts';
}else{
	$Thread='nts';
}

//判断扩展存放路径
//<tr><td class="e">extension_dir</td><td class="v">D:\phpStudy\PHPTutorial\php\php-5.5.38\ext</td><td class="v">D:\phpStudy\PHPTutorial\php\php-5.5.38\ext</td></tr>
preg_match_all('/<tr><td class="e">extension_dir[ \t]*<\/td><td\b[^\r\n]+?(?=<\/td>)/i', $Body, $result);
$extpath=preg_replace('/\bextension_dir\b[ \t]*/i','',$result[0][0]);
$extpath=preg_replace('/<[^>]+>/i','',$extpath);

//判断php.ini位置
preg_match_all('/<tr><td class="e">Loaded Configuration File[ \t]*<\/td>[^\r\n]+/i', $Body, $result);
$phpini=preg_replace('/\bLoaded Configuration File\b[ \t]*/i','',$result[0][0]);
$phpini=preg_replace('/<[^>]+>/i','',$phpini);

if($phpver*1 >= 7){
	if($System=='Windows'){
		$ExtLink="http://www.a8tg.com/xload/win/XLoader_Win_php" . $phpver . "_" . $Thread . "_" . $Architecture . ".dll";
	}else{
		$ExtLink="http://www.a8tg.com/xload/lin/XLoader_Lin_php" . $phpver . "_" . $Architecture . ".so";
	}
}else{
	$ExtLink="javascript:alert('适用于PHP5.X的XLoad扩展需要进入官网下载中心进行下载。');";
}


if($phpver*1 >= 7){
	if($System=='Windows'){
		$url="/XLoader_Win_php" . $phpver . "_" . $Thread . "_" . $Architecture . ".dll";
	}else{
		$url="/XLoader_Lin_php" . $phpver . "_" . $Architecture . ".so";
	}
}else{
	$url="javascript:alert('适用于PHP5.X的XLoad扩展需要进入官网下载中心进行下载。');";
}

?>

<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>XLoad扩展自动适配</title>
</head>
<body>
<style type="text/css">
.DownTB{
	background:#c3dbff;
	border:1px #9ed0ae solid;
	border-collapse:collapse;
}
.DownTB TD{
	color:#187937;
	text-align:center;
	border:1px #bdd2c2 dashed;
}
.DownTB .D_LIN1{
	color:#777777;
	background:#e9f4f7;
}
.DownTB .D_LIN2{
	color:#777777;
	background:#d3e9ef;
}
.hei {color:#333333;}
</style>
<p align="center"><b>适合您下载的 XLoad 扩展文件</b></p>
<table width="80%" align="center" class="DownTB" border="0" cellspacing="0" cellpadding="5">
	<tr>
		<td width="25%"><b class="hei">操作系统 </b></td>
		<td><b class="hei">PHP版本</b></td>
		<td><b class="hei">PHP架构</b></td>
		<td><b class="hei">线程安全</b></td>
	</tr>
	<tr class="D_LIN1">
		<td><?=$System?></td>
		<td><?=$phpver?></td>
		<td><?=$Architecture_?></td>
		<td><?=$Thread?></td>
	</tr>
</table>
<br>
<table width="80%" align="center" class="DownTB" border="0" cellspacing="0" cellpadding="5">
	<tr class="D_LIN1">
		<td><b class="hei">第一步：扩展存放路径</b></td>
		<td style="text-align:left;padding-left:10px"><?=$extpath?></td>
	</tr>
	<tr class="D_LIN1">
		<td width="25%"><b class="hei">第二部：下载扩展到扩展目录</b></td>
		<td style="text-align:left;padding-left:10px"><a href="<?=$ExtLink?>">点此下载</a></td>
	</tr>
	<tr class="D_LIN1">
		<td><b class="hei">第三步：配置文件(php.ini)</b></td>
		<td style="text-align:left;padding-left:10px"><?=$phpini?></td>
	</tr>
	<tr class="D_LIN1">
		<td><b class="hei">第四步：配置代码(php.ini)</b></td>
		<td style="text-align:left;padding-left:10px">extension=<?=$extpath?><?=$url?></td>
	</tr>
	
</table>
<body>
<html>