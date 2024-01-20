<?php
if (isset($_POST['files'])) {
	$error = ""; //error holder
	if (isset($_POST['createzip'])) {
		$post = $_POST;
		$file_folder = "files/"; // folder to load files
		if (extension_loaded('zip')) {
			// Checking ZIP extension is available
			if (isset($post['files']) and count($post['files']) > 0) {
				// Checking files are selected
				$zip = new ZipArchive(); // Load zip library 
				$zip_name = time() . ".zip"; // Zip name
				if ($zip->open($zip_name, ZIPARCHIVE::CREATE) !== TRUE) {
					// Opening zip file to load files
					$error .= "* Sorry ZIP creation failed at this time";
				}
				foreach ($post['files'] as $file) {
					$zip->addFile($file_folder . $file); // Adding files into zip
				}
				$zip->close();
				if (file_exists($zip_name)) {
					// push to download the zip
					header('Content-type: application/zip');
					header('Content-Disposition: attachment; filename="' . $zip_name . '"');
					readfile($zip_name);
					// remove zip file is exists in temp path
					unlink($zip_name);
				}

			} else
				$error .= "* Please select file to zip ";
		} else
			$error .= "* You dont have ZIP extension";
	}
}
?>
<!DOCTYPE html>
<html>

<head>
	<title>Create a Zip File Using PHP and Download Multiple Files</title>
</head>

<body>
	<h1>Create a Zip File Using PHP and Download Multiple Files</h1>
	<form name="zips" action="" method="post">
		<input type="checkbox" id="checkAll" /><label>Select All</label><br />
		<input class="chk" type="checkbox" name="files[]" value="SampleFile.pdf" /><label>PDF File</label><br />
		<input class="chk" type="checkbox" name="files[]" value="SampleFile.docx" /><label>Word File</label><br />
		<input class="chk" type="checkbox" name="files[]" value="AllPHPTricks.png" /><label>Image File</label><br />
		<input type="submit" id="submit" name="createzip" value="Download All Seleted Files">
	</form>

	<br /><br />



	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	<script type="text/javascript">
		$('#submit').prop("disabled", true);
		$("#checkAll").change(function () {
			$("input:checkbox").prop('checked', $(this).prop("checked"));
			$('#submit').prop("disabled", false);
			if ($('.chk').filter(':checked').length < 1) {
				$('#submit').attr('disabled', true);
			}
		});

		$('input:checkbox').click(function () {
			if ($(this).is(':checked')) {
				$('#submit').prop("disabled", false);
			} else {
				if ($('.chk').filter(':checked').length < 1) {
					$('#submit').attr('disabled', true);
				}
			}
		});		
	</script>
</body>

</html>