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
	public function dataview_link()
	{
		$user = $_SESSION['user'];
		$query = "SELECT * FROM links_interes 
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
	// FUNCION PARA CREAR UN LINK EN LA BD
	public function crear_link()
	{
		try {
			$user = $_SESSION['user'];
			$titulo = (isset($_POST['titulo'])) ? $_POST['titulo'] : "";
			$website = (isset($_POST['website'])) ? $_POST['website'] : "";
			$status = (isset($_POST['status'])) ? $_POST['status'] : "";
			$created_at = date("Y-m-d H:i:s", strtotime('now'));
			$updated_at = date("Y-m-d H:i:s", strtotime('now'));
			$stmt = $this->conn->prepare("INSERT INTO links_interes(titulo, website, status, creacion, modificado,id_empresa) 
        VALUES(:titulo, :website, :status, :created_at, :updated_at,:id_empresa)");
			$stmt->bindparam(":titulo", $titulo);
			$stmt->bindparam(":website", $website);
			$stmt->bindparam(":status", $status);
			$stmt->bindparam(":created_at", $created_at);
			$stmt->bindparam(":updated_at", $updated_at);
			$stmt->bindparam(":id_empresa", $user['id_empresa']);
			$stmt->execute();

			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}
	// FIN FUNCION PARA CREAR UN LINK EN LA BD

	// FUNCION PARA EDITAR UN LINK EN LA BD
	public function editar_link()
	{
		try {
			$user = $_SESSION['user'];
			$id = (isset($_POST['id'])) ? $_POST['id'] : "";
			$titulo = (isset($_POST['titulo'])) ? $_POST['titulo'] : "";
			$website = (isset($_POST['website'])) ? $_POST['website'] : "";
			$status = (isset($_POST['status'])) ? $_POST['status'] : "";
			$updated_at = date("Y-m-d H:i:s", strtotime('now'));

			$stmt = $this->conn->prepare("UPDATE links_interes SET 
        titulo=:titulo, 
        website=:website,  
        status=:status, 
        modificado=:updated_at,
		id_empresa=:id_empresa

        WHERE id=:id");
			$stmt->bindparam(":id_empresa", $user['id_empresa']);
			$stmt->bindparam(":titulo", $titulo);
			$stmt->bindparam(":website", $website);
			$stmt->bindparam(":status", $status);
			$stmt->bindparam(":updated_at", $updated_at);
			$stmt->bindparam(":id", $id);
			$stmt->execute();

			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}
	// FIN FUNCION PARA EDITAR UN LINK EN LA BD

	// FUNCION PARA ELIMINAR UN LINK DE LA BD 
	public function eliminar_link($id)
	{
		$stmt = $this->conn->prepare("DELETE FROM links_interes WHERE id=:id");
		$stmt->bindparam(":id", $id);
		$stmt->execute();

		return true;
	}
	// FIN FUNCION PARA ELIMINAR UN LINK DE LA BD
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
