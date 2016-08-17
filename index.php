<?php
  session_start();
  //On génére un jeton totalement unique (c'est capital :D)
	$token = uniqid(rand(), true);
	//Et on le stocke
	$_SESSION['token'] = $token;
	//On enregistre aussi le timestamp correspondant au moment de la création du token
	$_SESSION['token_time'] = time();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>DZip-Srv 1.1</title>
		<style>.col-md-4,.col-sm-4,.container{padding-left:15px;padding-right:15px}.fichier,.fichier:hover{text-align:center;vertical-align:middle}.form-control,input[type=file],span{display:block}.container-fluid{margin-right:auto;margin-left:auto}.row{margin-left:-15px;margin-right:-15px}.col-md-4,.col-sm-4{position:relative;min-height:1px}@media (min-width:992px){.col-md-4{float:left;width:33.33333333%}.col-md-offset-4{margin-left:33.33333333%}}@media (min-width:768px){.col-sm-4{float:left;width:33.33333333%}.col-sm-offset-4{margin-left:33.33333333%}}.alert{padding:15px;margin-bottom:20px;border:1px solid transparent;border-radius:4px}.alert-success{color:#3c763d;background-color:#dff0d8;border-color:#d6e9c6}.alert-danger{color:#a94442;background-color:#f2dede;border-color:#ebccd1}label{display:inline-block;max-width:100%;margin-bottom:5px;font-weight:700}input[type=radio],input[type=checkbox]{margin:4px 0 0;margin-top:1px\9;line-height:normal}input[type=radio]:focus,input[type=checkbox]:focus,input[type=file]:focus{outline:dotted thin;outline:-webkit-focus-ring-color auto 5px;outline-offset:-2px}.form-control{width:100%;height:34px;padding:5px 0 5px 5px;font-size:14px;line-height:1.42857143;color:#555;background-color:#fff;background-image:none;border:1px solid #ccc;border-radius:4px;-webkit-box-shadow:inset 0 1px 1px rgba(0,0,0,.075);box-shadow:inset 0 1px 1px rgba(0,0,0,.075);-webkit-transition:border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;-o-transition:border-color ease-in-out .15s,box-shadow ease-in-out .15s;transition:border-color ease-in-out .15s,box-shadow ease-in-out .15s}.form-control:focus{border-color:#66afe9;outline:0;-webkit-box-shadow:inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgba(102,175,233,.6);box-shadow:inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgba(102,175,233,.6)}.form-control::-moz-placeholder{color:#999;opacity:1}.form-control:-ms-input-placeholder{color:#999}.form-control::-webkit-input-placeholder{color:#999}.form-group{margin-bottom:15px}.checkbox,.radio{position:relative;display:block;margin-top:10px;margin-bottom:10px}.checkbox label,.radio label{min-height:20px;padding-left:20px;margin-bottom:0;font-weight:400;cursor:pointer}.bloc-titre{text-align:center}.fichier{width:60px;height:97px;background:#AA3939}.fichier-topright{border-top:14px solid #FFF;border-left:14px solid #D46A6A;float:right}.icon{width:52.5px;height:74.25px}.fichier>.name{color:#fff;margin-left:auto;margin-right:auto;position:relative;top:50%}.fichier:hover{background:#CC4646}.icon{background:#AA3939}fichier:hover{background:#CC4646;-webkit-transition:background .2s;-moz-transition:background .2s;-o-transition:background .2s;transition:background .5s}.btn{display:inline-block;padding:6px 40px;margin-bottom:0;font-weight:400;line-height:1.42857;text-align:center;white-space:nowrap;vertical-align:middle;cursor:pointer;-moz-user-select:none;background-image:none;border:1px solid transparent}.btn-submit{margin-top: 1em;color:#fff;background-color:#267513}.btn-submit:hover{background-color:#2e8c17;-webkit-transition:background-color .2s;-moz-transition:background-color .2s;-o-transition:background-color .2s;transition:background-color .5s}</style>
	</head>
	
	<body>
		<div class="container">
			<div class="row">
				<div class="col-md-4 col-sm-4 col-md-offset-4 col-sm-offset-4 bloc-titre">
					<h1>DZip-Srv 1.1</h1>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4 col-sm-4 col-md-offset-4 col-sm-offset-4">
					<?php if(array_key_exists('errors',$_SESSION)): ?>
					<div class="alert alert-danger">
						<?= implode('<br>', $_SESSION['errors']); ?>
					</div>
					<?php endif; ?>
					<?php if(array_key_exists('success',$_SESSION)): ?>
						<div class="alert alert-success">
							<?= implode('<br>', $_SESSION['success']); ?>
						</div>
					<?php endif; ?>
				</div>
				<div class="formulaire_contact">
					<form action="dzip-srv.php" method="post">	
						<div class="col-md-4 col-sm-4 col-md-offset-4 col-sm-offset-4">
							<div class="form-group">
								<label for="inputPathFile">Emplacement de l'archive sur votre serveur</label>
								<input type="text" class="form-control" id="inputPathFile" name="inputPathFile" value="<?php echo isset($_SESSION['inputs']['inputPathFile'])? $_SESSION['inputs']['inputPathFile'] : './'; ?>" required>
							</div>
							<div class="form-group">
								<label for="inputNameFile">Nom de l'archive (sans l'extention)</label>
								<input type="text" class="form-control" id="inputNameFile" name="inputNameFile" value="<?php echo isset($_SESSION['inputs']['inputNameFile'])? $_SESSION['inputs']['inputNameFile'] : ''; ?>" placeholder="Exemple : myFile" required>
							</div>
							<div class="form-group">
								<label for="inputExtension">Format de décompression</label>
									<div class="form-group">
									<?php if(extension_loaded('zip')): ?>
									
									<label class="radio-inline">
										<input type="radio" name="inputExtension" id="inlineRadio1" value=".zip" <?php echo isset($_SESSION['inputs']['inputExtension']) ? $_SESSION['inputs']['inputExtension'] == '.zip' ? 'checked' : '' : ''; ?>> 
										<span class="fichier">
											<span class="fichier-topright"></span>
											<span class="name">.zip</span>
										</span>
									</label>
									<?php endif; ?>
									<?php if(extension_loaded('phar')): ?>
									
									<label class="radio-inline">
										<input type="radio" name="inputExtension" id="inlineRadio2" value=".tar" <?php echo isset($_SESSION['inputs']['inputExtension']) ? $_SESSION['inputs']['inputExtension'] == '.tar' ? 'checked' : '' : ''; ?>> 
										<span class="fichier">
											<span class="fichier-topright"></span>
											<span class="name">.tar</span>
										</span>
									</label>
									<label class="radio-inline">
										<input type="radio" name="inputExtension" id="inlineRadio3" value=".tar.gz" <?php echo isset($_SESSION['inputs']['inputExtension']) ? $_SESSION['inputs']['inputExtension'] == '.tar.gz' ? 'checked' : '' : ''; ?>> 
										<span class="fichier">
											<span class="fichier-topright"></span>
											<span class="name">.tar.gz</span>
										</span>
									</label>
									<?php endif; ?>
									<?php if(extension_loaded('rar')): ?>
									
									<label class="radio-inline">
										<input type="radio" name="inputExtension" id="inlineRadio3" value=".rar" <?php echo isset($_SESSION['inputs']['inputExtension']) ? $_SESSION['inputs']['inputExtension'] == '.rar' ? 'checked' : '' : ''; ?>> 
										<span class="fichier">
											<span class="fichier-topright"></span>
											<span class="name">.rar</span>
										</span>
									</label>
									<?php endif; ?>
									
								</div>
							</div>
							<label for="inputPathDZip">Extraire vers :</label>
							<input type="text" class="form-control" id="inputPathDZip" name="inputPathDZip" value="<?php echo isset($_SESSION['inputs']['inputPathDZip'])? $_SESSION['inputs']['inputPathDZip'] : './'; ?>" required>
							<input type="hidden" name="token" id="token" value="<?php echo $token; ?>"/>
							<button type="submit" class="btn btn-submit">Envoyer</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<?php
		unset($_SESSION['inputs']); 
		unset($_SESSION['success']);
		unset($_SESSION['errors']);?>
	</body>
	<!-- Copyright © Mathieu NOËL-->
</html>
