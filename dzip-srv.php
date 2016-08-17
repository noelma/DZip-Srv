<?php
	/**
	 * \file dzip-srv.php
	 * \brief Class de décompression sur serveur distant
	 * \author Mathieu NOËL
	 * \version 1.1
	 * \date 04/01/2016
	 *
	 * Micro-framework permettant la décompression d'archive sur serveur distant.
	 * Dans le cas d'une offre mutualisé, l'utilisateur ne peut généralement pas utiliser un client SSH
	 * Cette classe permet de décompresser des archives déjà presente sur sont serveur.
	 */
	session_start();//on démarre la session
	
	$errors = array(); // on crée une vérif de champs
	$success = array();
	if(!isset($_POST['inputPathFile']) || $_POST['inputPathFile'] == ''){
		$errors['inputPathFile'] = 'Le emplacement de l\'archive n\'est pas renseigné';
	}
	if(!isset($_POST['inputNameFile']) || $_POST['inputNameFile'] == ''){
		$errors['inputNameFile'] = 'Le nom de l\'archive n\'est pas renseigné';
	}
	if(!isset($_POST['inputExtension']) || $_POST['inputExtension'] == ''){
		$errors['inputExtension'] = 'L\'extension n\'est pas renseigné';
	}else{
		if( $_POST['inputExtension'] != '.zip' &&
			$_POST['inputExtension'] != '.rar' && 
			$_POST['inputExtension'] != '.tar.gz' &&
			$_POST['inputExtension'] != '.tar'){
				$errors['inputExtension'] = 'L\'extension n\'est pas prise en charge';
			}
	}
	
	if(!isset($_POST['inputPathDZip']) || $_POST['inputPathDZip'] == ''){
		$errors['inputPathDZip'] = 'Le chemin du fichier de sortie n\'est pas renseigné';
	}
	//Si le jeton est présent dans la session et dans le formulaire
	if(isset($_SESSION['token']) && isset($_SESSION['token_time']) && isset($_POST['token'])){
		//Si le jeton de la session correspond à celui du formulaire
		if($_SESSION['token'] == $_POST['token']){
			//On stocke le timestamp qu'il était il y a 15 minutes
			$timestamp_ancien = time() - (15*60);
			//Si le jeton n'est pas expiré
			if(!($_SESSION['token_time'] >= $timestamp_ancien)){
				$errors['token_time'] = "Une erreur est survenue, votre mail n'a pu être envoyé";
			}
		}else{
			$errors['token'] = "Une erreur est survenue, votre mail n'a pu être envoyé";
		}
	}else{
		$errors['token'] = "Une erreur est survenue, votre mail n'a pu être envoyé";
	}
	
	$pathFile = htmlspecialchars($_POST['inputPathFile']);
	$nameFile = htmlspecialchars($_POST['inputNameFile']);
	$extension = htmlspecialchars($_POST['inputExtension']);
	$pathDZip = htmlspecialchars($_POST['inputPathDZip']);
	
	if(empty($errors)){
		if($extension =='.zip'){
			if(extension_loaded('zip')){
				//déclaration de l'objet de manipulation d'archive required
				$zip = new ZipArchive(); 
				$res = $zip->open($pathFile.$nameFile.$extension);
				//si l'ouverture de l'archive fonctionne
				if ($res === TRUE){
					//si l'extraction à réussit
					if($zip->extractTo($pathDZip)){
						$success['return'] = 'La décompression de '.$nameFile.$extension.' c\'est déroulé parfaitement !';
						$_SESSION['success'] = $success;
						$zip->close();
					}else{$errors['extractFailed'] = 'L\'extraction de '.$nameFile.$extension.' à échoué !';}	
				}else{$errors['openFailed'] = 'L\'extraction de '.$nameFile.$extension.' à échoué !';}
			}else{$errors['extension_loaded'] = 'L\'extension ZIP n\'est pas activé sur votre serveur !';}
			
		}else if($extension =='.rar'){
			if(extension_loaded('rar')){
				$rar_file =  RarArchive::rar_open($pathFile.$nameFile.$extension);
				$list = rar_list($rar_file);
				foreach($list as $file) {
					$entry = rar_entry_get($rar_file, $file->getName());
					$entry->extract($pathDZip); // extract to the current dir
				}
				rar_close($rar_file);
			}else{$errors['extension_loaded'] = 'L\'extension RAR n\'est pas activé sur votre serveur !';}
		}
		//si l'extention n'est pas 'zip' ou 'rar' alors elle est forcement 'tar' ou 'tar gz'
		else{
			if(extension_loaded('phar')){
				try {
					$phar = new PharData($pathFile.$nameFile.$extension);
					if($phar->extractTo($pathDZip)){
						$success['return'] = 'La décompression de '.$nameFile.$extension.' c\'est déroulé parfaitement !';
						$_SESSION['success'] = $success;
					}
					else{ $errors['extractFailed'] = 'L\'extraction de '.$nameFile.$extension.' à échoué !'; }
				} catch (Exception $e){$errors['extractFailed'] = 'L\'extraction de '.$nameFile.$extension.' à échoué !'; }
			}else{$errors['extension_loaded'] = 'L\'extension TAR et TAR.GZ n\'est pas activé sur votre serveur !';}
		}
	}
	if(!empty($errors)){ // si erreur on renvoie vers la page précédente
		$_SESSION['errors'] = $errors;//on stocke les erreurs
		//on stocke les valeurs des champs pour les réutiliser dans le formulaire
		$_SESSION['inputs']['inputPathFile'] = $pathFile;
		$_SESSION['inputs']['inputNameFile'] = $nameFile;
		$_SESSION['inputs']['inputExtension'] = $extension;
		$_SESSION['inputs']['inputPathDZip'] = $pathDZip;
	}
	header('Location: index.php');
?>
