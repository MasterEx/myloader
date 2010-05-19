<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="el" xml:lang="el">
<head>
<META name="author" content="Periklis Ntanasis a.k.a. Master_ex">
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">
<meta name="keywords" content="personal uploader" />
<meta name="description" content="" />
<meta name="distribution" content="global" />
<title>My Personal Uploader</title>
</head>
<body>
<?php
if(isset($_POST['submit']))
{
	$tmpdir = md5($_FILES['uploadedfile']['name'].date('l jS \of F Y h:i:s A'));
	if($_FILES['uploadedfile']['size']>20000001)
	{
		echo "Files > 20Mb are not permitted";
	}
	else
	{
		if(mkdir("./uploads/".$tmpdir, 0700))
		{
			$target_path = "./uploads/".$tmpdir."/";
			$target_path = $target_path.basename( $_FILES['uploadedfile']['name']);
			$pieces = explode(".",$_FILES['uploadedfile']['name']);
			if(strcmp($pieces[count($pieces)-1],"html")==0 || strcmp($pieces[count($pieces)-1],"htm")==0 )
			{
				$target_path = $target_path."s";
			}
			if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path))
			{
				copy("./uploads/msg.html","./uploads/".$tmpdir."/index.html");
				echo "The file ".basename( $_FILES['uploadedfile']['name'])." has been uploaded<br/>";
				echo "You can access the file <a href='$target_path'>here</a><br/>";
			}
			else
			{
				echo "There was an error uploading the file, please try again! 1 ";
			}
		}
		else
		{
			echo "There was an error uploading the file, please try again! 2 ";
		}
	}
	echo '<a href="index.php">Upload a new file!</a>';
}
else
{
?>

<form enctype="multipart/form-data" action="index.php" method="POST">
<input type="hidden" name="MAX_FILE_SIZE" value="33554432" />
Choose a file to upload: <input name="uploadedfile" type="file" /><br />
<input type="submit" value="Upload File" name="submit" />
</form>

<?php
}
?>
<br/><br/>
Every file should be < 20MB and the old files are deleted in daily basis.
</body>
</html>
