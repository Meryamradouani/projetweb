<?php //creer le compte
session_start();
include('connexion.php');
$id_demandeur=$_SESSION['id_demandeur'];
if(isset($_POST['submit'])){
   $titre=$_POST['titre'];
   $lieu=$_POST['lieu'];
    $description=$_POST['description'];;
    $dated=$_POST['dated'];
    $datef=$_POST['datef'];
	
	if(isset($_FILES['fichier']) and $_FILES['fichier']['error']==0)
	{
		$dossier= 'photo/';
		$temp_name=$_FILES['fichier']['tmp_name'];
		if(!is_uploaded_file($temp_name)){
		exit("le fichier est untrouvable");
		}
		if ($_FILES['fichier']['size'] >= 1000000){
			exit("Erreur, le fichier est volumineux");
		}
		$infosfichier = pathinfo($_FILES['fichier']['name']);
		$extension_upload = $infosfichier['extension'];
		
		$extension_upload = strtolower($extension_upload);
		$extensions_autorisees = array('png','jpeg','jpg');
		if (!in_array($extension_upload, $extensions_autorisees))
		{
		exit("Erreur, Veuillez inserer une image svp (extensions autorisées: png)");
		}
		$nom_photo=$titre.".".$extension_upload;
		if(!move_uploaded_file($temp_name,$dossier.$nom_photo)){
		exit("Problem dans le telechargement de l'image, Ressayez");
		}
		$ph_name=$nom_photo;
	}
	else{
		$ph_name="1.png";
	}
    $id_demandeur=$_SESSION['id_demandeur'];
	$requette="INSERT INTO demande (id_demandeur, date_debut, date_fin, lieu, titre, description, Photo) VALUES ('$id_demandeur', '$dated', '$datef', '$lieu', '$titre', '$description', '$ph_name')";
    ;
	$resultat=mysqli_query($link,$requette);
	
}
mysqli_close($link); 
?>