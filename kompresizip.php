<!DOCTYPE html>
	<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Upload file progress bar dengan PHP dan MySQL. Tutorial oleh tutorialweb.net">
    <link href="css/bootstrap.min.css" rel="stylesheet">
   <style type='text/css'>
      body{ background-image:url(background/back5.jpg); }
   </style>
    <style type="text/css">
    .form_upload {
       
        width: 700px;
        padding: 20px;
      
    </style>
   
		<title>Kompresi File di PHP</title></head>
	<center><body>
		<br>
		<br>
		<br>
		<br>
		<br>
		<h1>Silahkan Upload File</h1>
		<br>
		<div class="form_upload">
		<center><form class="form-inline" method="post" action="" enctype="multipart/form-data">
					<div class="input-group">
						<label class="input-group-btn">
							<span class="btn btn-danger btn-lg">
								Pilih File&hellip; <input type="file" id="file" name="file" placeholder="Pilih File" style="display: none;" required>
							</span>
						</label>
						<input type="text" class="form-control input-lg" size="50" readonly required>
					</div>
					<div class="input-group">
						<input type="submit" class="btn btn-lg btn-primary" name="Submit" value="Kompressi">
					</div>
					
				</form></center>
		</div>
		<br>
		<br>

		<?php
		if(isset($_POST['Submit'])) {
			$namafile = $_FILES['file']['name'];
			$dir = dirname(__FILE__);
			if (is_uploaded_file($_FILES['file']['tmp_name'])) {
				$cp = move_uploaded_file ($_FILES['file']['tmp_name'], $dir."/".$namafile);
				if ($cp) {
					//kompresi
					$zip = new ZipArchive();
					$file_terkompresi = "data.zip";
					if ($zip->open($file_terkompresi, ZipArchive::CREATE)!==TRUE) {
						die("cannot open create zip file\n");
					}
					$zip->addFile($dir."/".$namafile, $namafile);
					$zip->close();
					echo "<h2>File berhasil diupload dan dikompresi.</h2>";
					echo sprintf("File asal <strong>%s</strong> ( %s bite(s) )", 
						$_FILES['file']['name'], filesize($dir."/".$namafile));
					echo sprintf("<br/>File terkompresi <a href='%s'><strong>%s</strong></a> ( %s bite(s) )", 
						$file_terkompresi, $file_terkompresi, filesize($dir."/".$file_terkompresi));
				}
			} else {
				die("Gagal upload");
			}
		}
		?>

	<script src="js/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>
    <script src="js/upload.js"></script>
    <script>
	$(function() {
	  $(document).on('change', ':file', function() {
		var input = $(this),
			numFiles = input.get(0).files ? input.get(0).files.length : 1,
			label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
		input.trigger('fileselect', [numFiles, label]);
	  });

	  $(document).ready( function() {
		  $(':file').on('fileselect', function(event, numFiles, label) {

			  var input = $(this).parents('.input-group').find(':text'),
				  log = numFiles > 1 ? numFiles + ' files selected' : label;

			  if( input.length ) {
				  input.val(log);
			  } else {
				  if( log ) alert(log);
			  }

		  });
	  });
	  
	});
	</script>
	</body>
</center>
</html>