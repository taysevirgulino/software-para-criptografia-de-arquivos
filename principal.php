<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Página Inicial do Sistema</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/jumbotron.css" rel="stylesheet">
	<script type="text/javascript" src="https://cdn.rawgit.com/ricmoo/aes-js/e27b99df/index.js"></script>
	<script type="text/javascript" src "encriptar.js"></script>

	<script>
		var key = [ 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16 ];
		var encryptedHex;		
		var text;

		window.onload = function() {
			var fileInput = document.getElementById('fileInput');
			var fileDisplayArea = document.getElementById('fileDisplayArea');

			fileInput.addEventListener('change', function(e) {
				var file = fileInput.files[0];
				var textType = /text.*/;

				if (file.type.match(textType)) {
					var reader = new FileReader();

					reader.onload = function(e) {
						fileDisplayArea.innerText = reader.result;
					}

					reader.readAsText(file);	
				} else {
					fileDisplayArea.innerText = "File not supported!"
				}
			});

			var fileInput2 = document.getElementById('fileInput2');
			var fileDisplayArea2 = document.getElementById('fileDisplayArea2');

			fileInput2.addEventListener('change', function(e) {
				var file2 = fileInput2.files[0];
				var textType2 = /text.*/;

				if (file2.type.match(textType2)) {
					var reader2 = new FileReader();

					reader2.onload = function(e) {
						fileDisplayArea2.innerText = reader2.result;
					}

					reader2.readAsText(file2);	
				} else {
					fileDisplayArea2.innerText = "File not supported!"
				}
			});
		}

		function encriptar() {

			text = fileDisplayArea.innerText;

			console.log ("Esse é o texto original: ", text);
						
			// Convert text to bytes
			var textBytes = aesjs.utils.utf8.toBytes(text);

			// The counter is optional, and if omitted will begin at 1
			var aesCtr = new aesjs.ModeOfOperation.ctr(key);
			var encryptedBytes = aesCtr.encrypt(textBytes);

			// To print or store the binary data, you may convert it to hex
			encryptedHex = aesjs.utils.hex.fromBytes(encryptedBytes);
			console.log("Esse é o texto encriptado: ", encryptedHex);

			var textFile = null,
  			makeTextFile = function (text) {
				var data = new Blob([text], {type: 'text/plain'});

				// If we are replacing a previously generated file we need to
				// manually revoke the object URL to avoid memory leaks.
				if (textFile !== null) {
				window.URL.revokeObjectURL(textFile);
				}

				textFile = window.URL.createObjectURL(data);

				return textFile;
			};


			var create = document.getElementById('create'),
				textbox = document.getElementById('textbox');

			create.addEventListener('click', function () {
				var link = document.getElementById('downloadlink');
				textbox.value = encryptedHex;
				link.href = makeTextFile(textbox.value);
				link.style.display = 'block';
			}, false);
		}

		function decriptar() {

			text = fileDisplayArea2.innerText;

			console.log ("Esse é o texto original: ", text);

			// When ready to decrypt the hex string, convert it back to bytes
			var encryptedBytes = aesjs.utils.hex.toBytes(text);

			// The counter mode of operation maintains internal state, so to
			// decrypt a new instance must be instantiated.
			var aesCtr = new aesjs.ModeOfOperation.ctr(key);
			var decryptedBytes = aesCtr.decrypt(encryptedBytes);

			// Convert our bytes back into text
			var decryptedText = aesjs.utils.utf8.fromBytes(decryptedBytes);
			console.log("Esse é o texto decriptado: ",decryptedText);

			var textFile = null,
  			makeTextFile = function (text) {
				var data = new Blob([text], {type: 'text/plain'});

				// If we are replacing a previously generated file we need to
				// manually revoke the object URL to avoid memory leaks.
				if (textFile !== null) {
				window.URL.revokeObjectURL(textFile);
				}

				textFile = window.URL.createObjectURL(data);

				return textFile;
			};


			var create2 = document.getElementById('create2'),
				textbox2 = document.getElementById('textbox2');

			create2.addEventListener('click', function () {
				var link = document.getElementById('downloadlink2');
				textbox2.value = decryptedText;
				link.href = makeTextFile(textbox2.value);
				link.style.display = 'block';
			}, false);	
		}
	</script>

  </head>

  	<body>
		<nav class="navbar navbar-static-top navbar-dark bg-inverse">
			<?php
				echo "Seja Bem-Vindo(a) ". $_SESSION['usuarioNome'];	
			?> | <a href="sair.php" style="color: #fff">Sair</a>
		</nav>

		<div class="jumbotron">
		<div class="container">
			<h1 class="display-3">Olá, Bem-Vindo(a)!</h1>
			<p>Essa página é sobre o nosso trabalho de segurança de sistemas, disciplina ministrada pelo professor Jackson =)<br/>
			Componentes do grupo: Fernando, Leo, Matheus e Tayse</p>
		</div>
		</div>

		<div class="container">
		<div class="row">
			<div class="col-md-4">
			<h2>Descrição da Atividade</h2>
			<p>Desenvolver um software que utilize conceitos de criptografia para fornecer as seguintes funcionalidades:<br />
				&raquo; Permitir que o usuário entre no sistema (autenticação)<br />
				&raquo; Permitir que o usuário encripte um arquivo (usar o algoritmo AES) <br />
				&raquo; Permitir que o usuário salve o arquivo encriptado <br />
				&raquo; Permitir que o usuário decripte o arquivo encriptado
			</p>
			</div>
			<div class="col-md-4">
				<h2>Encriptação de arquivo</h2>
				<p>O usuário escolhe um arquivo e o sistema encripta o arquivo e devolve-o encriptado.</p>
				<div id="page-wrapper">
					<input type="file" accept='text/plain' name="Arquivo" id="fileInput"><br /><br />
					<input class="btn btn-lg btn-primary btn-block" onclick="encriptar()" value="Encriptar arquivo" />
					<pre id="fileDisplayArea" style="display:none;"></pre>
				</div>
				<br />
				<textarea id="textbox" style="display:none;"></textarea>
				<button id="create">Create file</button>
				<a download="encriptado.txt" id="downloadlink" style="display: none">Download</a>
			</div>
			<div class="col-md-4">
				<h2>Decriptação de arquivo</h2>
				<p>O usuário escolhe um arquivo encriptado e recebe de volta um arquivo normal.</p>
				<div id="page-wrapper">
					<input type="file" accept='text/plain' name="Arquivo2" id="fileInput2"><br /><br />
					<input class="btn btn-lg btn-primary btn-block" onclick="decriptar()" value="Decriptar arquivo" />
					<pre id="fileDisplayArea2" style="display:none;"></pre>
				</div>
				<br />
				<textarea id="textbox2" style="display:none;"></textarea>
				<button id="create2">Create file</button>
				<a download="decriptado.txt" id="downloadlink2" style="display: none">Download</a>
			</div>
		</div>

		<hr>

		<footer>
			<p>&copy; SS 2017</p>
		</footer>
		
		</div>    
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js" integrity="sha384-THPy051/pYDQGanwU6poAc/hOdQxjnOEXzbT+OuUAFqNqFjL+4IGLBgCJC3ZOShY" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js" integrity="sha384-Plbmg8JY28KFelvJVai01l8WyZzrYWG825m+cZ0eDDS1f7d/js6ikvy1+X+guPIB" crossorigin="anonymous"></script>
  
	</body>
</html>
