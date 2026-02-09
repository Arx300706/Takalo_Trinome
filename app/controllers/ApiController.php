<?php

namespace app\controllers;

use flight\Engine;
use app\models\ImageModel;
use Flight;

class ApiController
{

	protected Engine $app;

	public function __construct($app)
	{
		$this->app = $app;
	}

	public function getImages()
	{
		$imageModel = new ImageModel($this->app->db());
		$images = $imageModel->getImages();

		$this->app->render('listeImages', ['images' => $images]);
	}

	public function getImage($id)
	{
		$imageModel = new ImageModel($this->app->db());
		$image = $imageModel->getImage($id);

		$this->app->render('image', ['image' => $image]);
	}

	public function save()
	{
		$uploadDir = "upload/";
		$maxSize = 2 * 1024 * 1024;
		$allowedMimeTypes = ['image/jpeg', 'image/png'];
		$imageModel = new ImageModel($this->app->db());
		$webDirUpload = '/upload/';

		// Vérifie si un fichier est soumis
		if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
			$file = $_FILES['image'];
			$description = $_POST['description'];

			if ($file['error'] !== UPLOAD_ERR_OK) {
				header("Location: addNewPhoto.php?errorAdd=1"); //erreur d'upload
			}
			// Vérifie la taille
			if ($file['size'] > $maxSize) {
				header("Location: addNewPhoto.php?errorAdd=2"); //fichier trop lourd
			}

			// Vérifie le type MIME avec `finfo`
			$finfo = finfo_open(FILEINFO_MIME_TYPE);
			$mime = finfo_file($finfo, $file['tmp_name']);

			if (!in_array($mime, $allowedMimeTypes)) {
				header("Location: addNewPhoto.php?errorAdd=3"); //type de fichier non autorisé
			}

			// renommer le fichier
			// $originalName = pathinfo($file['name'], PATHINFO_FILENAME);
			$extension = pathinfo($file['name'], PATHINFO_EXTENSION);
			$newName = 'upload' . '_' . uniqid() . '.' . $extension;
			$imageModel->setPath($webDirUpload . $newName);
			$imageModel->setDescription($description);

			// Déplace le fichier
			if (move_uploaded_file($file['tmp_name'], $uploadDir . $newName)) {
				$imageModel->save();

				// addNewImage($_SESSION['User']['Id_membre'], $uploadDir . $newName);
				// ModifyPhotoDeProfil($_SESSION['Resultat']['Id_membre'], $uploadDir . $newName);
				Flight::redirect('/api/images');
			} else {
				header("Location: addNewPhoto.php?errorAdd=1"); //erreur de deplacement
			}
		} else {
			header("Location: addNewPhoto.php?errorAdd=1"); //erreur d'upload
		}
	}



	public function updateUser($id)
	{
		// You could actually update data from the database if you had one set up
		// $statement = $this->app->db()->runQuery("UPDATE users SET email = ? WHERE id = ?", [ $this->app->data['email'], $id ]);
		$this->app->json(['success' => true, 'id' => $id], 200, true, 'utf-8', JSON_PRETTY_PRINT);
	}
}
