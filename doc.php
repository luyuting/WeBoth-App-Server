<!DOCTYPE html>
<html>
<head>
	<title>Doc</title>
	<meta charset = "utf-8"/>
	<meta name = "viewport" content = "width = device-width, initial-scale = 1, maximum-scale = 1, user-scalable = no">
	<script src = "js/jquery-1.11.1.min.js"></script>
	<script>
		$(function() {
			$("table tr").each(function() {
				$(this).find("td").eq(1).bind("mouseover", function() {
					$(this).css("cursor", "pointer").attr("title", "点击查询" + $(this).text() + "源代码")
					.bind("click", function() {
						location.href  = "doc.php?action=" + $(this).text() + "#code";
					});
				})
			});
		});
	</script>
<style>
	@charset "utf-8";
	body {
		word-break: break-all;
	}
	h2 {
		text-align: center;
		font-size: 28px;
	}
	* {
		font-family: 'consolas';
		font-size:14px;
	}
	#code {
		
		width: calc(100% - 100px);
		margin: 0 auto;
		padding: 0 20px;
		border: 1px solid #e1e1e1;
		-webkit-box-shadow: 0 0 3px #eee,inset 0 0 3px #fff;
		box-shadow: 0 0 3px #eee,inset 0 0 3px #fff;
		background: #fbfbfb;
		border-radius:7px;
	}
	table{
		width: calc(100% - 60px);
		margin: 10px auto;
		border-collapse: collapse;
		border-spacing: 0;
		clear:both;
	}
	th {
		height: auto;
		border-bottom: 0;
		color: #666;
		background-color: #f2f2f2;
		white-space: nowrap;
	}
	tr{
		background-color: #f9f9f9 !important;
	}
	tr td:first-child {
		text-align: center;
	}
	td,th{
		padding: 6px 12px;
		border: 1px solid #dddddd;
	}
</style>
</head>
<body>
<?php 
	header("content-type : text/html; charset = utf-8"); 
	
	$arr = array();
	
	$file = 'doc.txt';
	$fp = fopen($file, "r");      
	while (!feof($fp)) { 
		$buffer = fgets($fp); 
		$col = explode("\t", ($buffer));	
		$col[count($col)-1] = trim($col[count($col)-1]);
		$arr[] = $col;
	}
	fclose($fp);     
?>
	<h2>Action Table</h2>
	<table>
		<thead>
			<tr>
				<th>Index</th>
				<th>Action</th>
				<th>Description</th>
			</tr>
		</thead>
		<tbody>
		<?php
			for($i = 0; $i < count($arr); $i ++) {
				$index = $i + 1;
				echo "<tr><td>{$index}</td>";
				for($j = 0; $j < count($arr[$i]); $j ++) {
					echo "<td>{$arr[$i][$j]}</td>";
				}
				echo "</tr>";
			}
		?>
		</tbody>
	<table>
	<h2>Action Code</h2>
	<div id = "code">
		<?php empty($_GET['action'])? $action = 'UserLoginAction': $action = $_GET['action']; ?>
		<?= highlight_file('action/' . $action . '.php') ?>
	</div>
</body>
</html>