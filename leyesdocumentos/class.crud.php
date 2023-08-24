<?php

require_once('../layouts/dbconexion_pdo.php');

class crud
{

	private $conn;

	public function __construct()
	{
		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;
	}

	public function runQuery($sql)
	{
		$stmt = $this->conn->prepare($sql);
		return $stmt;
	}

	//FUNCION PARA MOSTRAR LISTADO DE DEPARTAMENTOS
	public function dataview_activdades()
	{
		try {
			$stmt = $this->conn->prepare("SELECT * FROM `documento` ORDER BY nombre ASC");
			$stmt->execute();
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $results;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

	public function crear_documento()
	{
		try {
			$user = $_SESSION['user'];
			$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : "";

			$created_at = date("Y-m-d H:i:s", strtotime('now'));
			$updated_at = date("Y-m-d H:i:s", strtotime('now'));

			$stmt_check = $this->conn->prepare("SELECT COUNT(*) FROM documento WHERE nombre = :nombre AND id_empresa = :id_empresa");
			$stmt_check->bindparam(":nombre", $nombre);
			$stmt_check->bindParam(":id_empresa", $user['id_empresa']);
			$stmt_check->execute();
			$count = $stmt_check->fetchColumn();

			if ($count > 0) {
				// Ya existe un registro con el mismo término, retornar falso
				return 1;
			}

			// Check if a file was uploaded successfully
			if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] === UPLOAD_ERR_OK) {

				$uploadedFileName = $_FILES['archivo']['name'];
				$uploadedFilePath = $_FILES['archivo']['tmp_name'];

				// Use the uploaded filename as the document title
				$titulo = $uploadedFileName;

				// Assuming you have a directory named "uploads" to store the uploaded files
				$targetDirectory = "../uploads/";
				$targetFilePath = $targetDirectory . $uploadedFileName;

				// Move the uploaded file to the target directory
				if (move_uploaded_file($uploadedFilePath, $targetFilePath)) {


					$stmt_check2 = $this->conn->prepare("SELECT COUNT(*) FROM documento WHERE titulo = :titulo AND id_empresa = :id_empresa");
					$stmt_check2->bindParam(":titulo", $titulo);
					$stmt_check2->bindParam(":id_empresa", $user['id_empresa']);
					$stmt_check2->execute();
					$count2 = $stmt_check2->fetchColumn();
					if ($count2 > 0) {
						// Ya existe un registro con el mismo término, retornar falso
						return 7;
					}

					$stmt = $this->conn->prepare("INSERT INTO documento(id_empresa, nombre, titulo, creacion, modificado) 
                VALUES(:id_empresa, :nombre, :titulo, :created_at, :updated_at)");
					$stmt->bindParam(":id_empresa", $user['id_empresa']);
					$stmt->bindParam(":nombre", $nombre);
					$stmt->bindParam(":titulo", $titulo);
					$stmt->bindParam(":created_at", $created_at);
					$stmt->bindParam(":updated_at", $updated_at);
					$stmt->execute();




					return 2; // Document created successfully.
				} else {
					return 4;
				}
			} else {
				return 5;
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
			return 3; // An error occurred.
		}
	}


	public function editar_documento()
	{
		try {
			$id = (isset($_POST['id'])) ? $_POST['id'] : "";
			$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : "";
			$updated_at = date("Y-m-d H:i:s", strtotime('now'));

			$nombre2 = strtolower($nombre);
			$stmt_check = $this->conn->prepare("SELECT COUNT(*) FROM documento WHERE LOWER(nombre) = :nombre AND id != :id");
			$stmt_check->bindparam(":nombre", $nombre2);
			$stmt_check->bindparam(":id", $id);
			$stmt_check->execute();
			$count = $stmt_check->fetchColumn();

			if ($count > 0) {
				// Ya existe un registro con el mismo término y diferente ID, retornar falso
				return 1;
			}


			$stmt = $this->conn->prepare("UPDATE documento SET 
			nombre=:nombre, 
			modificado=:updated_at
			WHERE id=:id");
			$stmt->bindparam(":nombre", $nombre);
			$stmt->bindparam(":updated_at", $updated_at);
			$stmt->bindparam(":id", $id);
			$stmt->execute();

			return 2;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return 3;
		}
	}
	//FIN FUNCION PARA EDITAR UN DEPARTAMENTO EN LA BD

	//FUNCION PARA ELIMINAR UN DEPARTAMENTO DE LA BD 
	public function eliminar_documento($id, $titulo)
	{
		try {
			// Luego, elimina el registro de la base de datos
			$stmt = $this->conn->prepare("DELETE FROM documento WHERE id=:id");
			$stmt->bindParam(":id", $id);
			$stmt->execute();

			// Finalmente, elimina el archivo del servidor
			$archivoAEliminar = "../uploads/" . $titulo; // Ajusta esta ruta
			if (unlink($archivoAEliminar)) {
				return true; // Eliminación exitosa
			} else {
				return false; // Error en la eliminación del archivo
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false; // Error en la eliminación
		}
	}

	//FIN FUNCION PARA ELIMINAR UN DEPARTAMENTO DE LA BD 

	//SELECT DE CATEGORIAS 
	public function getcategorias()
	{
		$query = "SELECT * FROM tipo_categoria";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();

		if ($stmt->rowCount() > 0) {
			$data = array();
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$data[] = $row;
			}
			return $data;
		}
	}
	//FIN SELECT DE CATEGORIAS

}
