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


	public function dataview_nivelempresarial()
	{
		$user = $_SESSION['user'];
		$query = "SELECT * FROM nivel_organizativo 
          WHERE id_empresa = " . $user['id_empresa'];
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
	//FIN FUNCION PARA MOSTRAR LISTADO DE DEPARTAMENTOS  

	//FUNCION PARA CREAR UN DEPARTAMENTO EN LA BD
	public function crear_nivelempresarial()
	{
		try {
			$user = $_SESSION['user'];
			$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : "";
			$status = (isset($_POST['status'])) ? $_POST['status'] : "";
			$orden = (isset($_POST['orden'])) ? $_POST['orden'] : "";
			$created_at = date("Y-m-d H:i:s", strtotime('now'));
			$updated_at = date("Y-m-d H:i:s", strtotime('now'));

			// Verificar si el valor de $orden ya existe en la tabla para la id_empresa actual
			$stmt = $this->conn->prepare("SELECT orden FROM nivel_organizativo WHERE id_empresa = :id_empresa AND orden = :orden");
			$stmt->bindParam(":id_empresa", $user['id_empresa']);
			$stmt->bindParam(":orden", $orden);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);

			if ($result) {
				// El valor de $orden ya existe en la tabla
				return 0;
			}




			$stmt_check = $this->conn->prepare("SELECT COUNT(*) FROM nivel_organizativo WHERE id_empresa = :id_empresa AND nombre = :nombre");
			$stmt_check->bindparam(":id_empresa", $user['id_empresa']);
			$stmt_check->bindparam(":nombre", $nombre);
			$stmt_check->execute();
			$count = $stmt_check->fetchColumn();

			if ($count > 0) {
				// Ya existe un registro con el mismo término, retornar falso
				return 1;
			}




			$stmt = $this->conn->prepare("INSERT INTO nivel_organizativo(id_empresa,nombre,status,orden,creacion,modificacion) 
        VALUES(:id_empresa,:nombre,:status,:orden,:created_at,:updated_at)");
			$stmt->bindparam(":id_empresa", $user['id_empresa']);
			$stmt->bindparam(":nombre", $nombre);
			$stmt->bindparam(":status", $status);
			$stmt->bindparam(":orden", $orden);
			$stmt->bindparam(":created_at", $created_at);
			$stmt->bindparam(":updated_at", $updated_at);
			$stmt->execute();

			return 2;
		} catch (PDOException $e) {
			throw $e;
			echo $e->getMessage();
			return false;
		}
	}
	//FIN FUNCION PARA CREAR UN DEPARTAMENTOS EN LA BD

	//FUNCION PARA EDITAR UN DEPARTAMENTO EN LA BD
	public function editar_nivelempresarial()
	{
		try {

			$id = (isset($_POST['id'])) ? $_POST['id'] : "";
			$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : "";
			$status = (isset($_POST['status'])) ? $_POST['status'] : "";
			$orden = (isset($_POST['orden'])) ? $_POST['orden'] : "";
			$updated_at = date("Y-m-d H:i:s", strtotime('now'));

			// Verificar si el valor de $orden ya existe en la tabla para otros registros de la id_empresa actual
			$stmt = $this->conn->prepare("SELECT id FROM nivel_organizativo WHERE id_empresa = :id_empresa AND orden = :orden AND id != :id");
			$user = $_SESSION['user'];
			$stmt->bindParam(":id_empresa", $user['id_empresa']);
			$stmt->bindParam(":orden", $orden);
			$stmt->bindParam(":id", $id);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);

			if ($result) {
				// El valor de $orden ya existe en la tabla para otros registros de la id_empresa actual
				return 0;
			}




			$user = $_SESSION['user'];

			$nombre2 = strtolower($nombre);
			$stmt_check = $this->conn->prepare("SELECT COUNT(*) FROM glosario WHERE id_empresa = :id_empresa AND LOWER(nombre) = :nombre AND id != :id");
			$stmt_check->bindparam(":id_empresa", $user['id_empresa']);
			$stmt_check->bindparam(":nombre", $nombre2);
			$stmt_check->bindparam(":id", $id);
			$stmt_check->execute();
			$count = $stmt_check->fetchColumn();

			if ($count > 0) {
				// Ya existe un registro con el mismo término y diferente ID, retornar falso
				return 1;
			}

			$stmt = $this->conn->prepare("UPDATE nivel_organizativo SET 
        nombre=:nombre, 
        status=:status,  
        orden=:orden, 
        modificacion=:updated_at
        WHERE id=:id");
			$stmt->bindparam(":nombre", $nombre);
			$stmt->bindparam(":status", $status);
			$stmt->bindparam(":orden", $orden);
			$stmt->bindparam(":updated_at", $updated_at);
			$stmt->bindparam(":id", $id);
			$stmt->execute();

			return 2;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}
	//FIN FUNCION PARA EDITAR UN DEPARTAMENTO EN LA BD

	//FUNCION PARA ELIMINAR UN DEPARTAMENTO DE LA BD 
	public function eliminar_nivelempresarial($id)
	{

		$stmt = $this->conn->prepare("DELETE FROM nivel_organizativo WHERE id=:id");
		$stmt->bindparam(
			":id",
			$id
		);
		$stmt->execute();

		return true;
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
