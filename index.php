<?php
error_reporting(-1);
ini_set('display_errors', 1);
if ($_SERVER['REQUEST_METHOD'] == "POST") {

	if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')    $HOST = "https://";
	else $HOST = "http://";

	// Append the host(domain name, ip) to the URL.   
	$HOST .= $_SERVER['HTTP_HOST'];

	// Append the requested resource location to the URL   
	$HOST .= $_SERVER['REQUEST_URI'];

	if (isset($_POST['data'])) {

		$PHP_FILE_PATH = 'code/index.php';

		$CODE_DATA = '<?php
' . $_POST['data'];

		//UPDATING FILE
		$myFile = fopen($PHP_FILE_PATH, "w") or die("Unable to open file!");
		fwrite($myFile, $CODE_DATA);
		fclose($myFile);

		$URL = $HOST . 'code/index.php';

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $URL);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 20);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
		$response = curl_exec($ch);
		curl_close($ch);

		// $response = file_get_contents($URL);

		$res = array('status' => 1, 'msg' => 'Success!!!', 'data' => $response);
	} else $res = array('status' => 0, 'error' => 'Invalid Parameters!!!');
	echo json_encode($res);
	exit();
}

?>


<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Write PHP</title>
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="assets/plugin/bootstrap/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/plugin/notiflix/notiflix-2.7.0.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<!-- /CSS -->
</head>

<body>
	<input type="hidden" name="currentPageUrl" value="<?php echo $HOST . '/writephp/'; ?>">

	<section class="pt-5 pb-5">
		<div class="container-fluid">
			<div class="row content-row">
				<div class="col-12">
					<div class="error-box" id="error-box"></div>
				</div>

				<div class="col-md-5 pe-md-0">
					<div class="code-box">
						<div class="mb-3">
							<label class="text-danger"><strong>&lt;?php</strong></label>
							<div id="editor" name="data"></div>
						</div>
					</div>
				</div>

				<div class="col-md-2 ps-md-0 pe-md-0">
					<div class="btn-box-container">
						<div class="text-center">
							<button class="btn btn-primary" type="button" id="formSubmitButton">Run Code</button>
						</div>
					</div>
				</div>

				<div class="col-md-5 ps-md-0">
					<div class="card border-success output-card">
						<div class="card-header bg-success text-white"><strong>CODE OUTPUT</strong></div>
						<div class="card-body" id="codeOutputBody">Hello World!</div>
					</div>
				</div>

			</div>
		</div>
	</section>
	<!-- SCRIPTS -->
	<script type="text/javascript" src="assets/plugin/jquery/jquery-3.6.0.min.js"></script>
	<script type="text/javascript" src="assets/plugin/bootstrap/bootstrap.min.js"></script>
	<script type="text/javascript" src="assets/plugin/ace/ace.js"></script>
	<script type="text/javascript" src="assets/plugin/ace/ext-language_tools.js"></script>
	<script type="text/javascript" src="assets/plugin/ace/mode-php.js"></script>
	<script type="text/javascript" src="assets/plugin/notiflix/notiflix-aio-2.7.0.min.js"></script>
	<script type="text/javascript" src="assets/js/style.js"></script>
	<!-- /SCRIPTS -->
</body>

</html>
