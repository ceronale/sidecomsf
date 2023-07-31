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
	public function dataview_departamentos()
	{
		$user = $_SESSION['user'];
		$query = "SELECT d.*, tc.categoria as nombre_categoria, d.categoria as id_categoria FROM departamentos d
		INNER JOIN tipo_categoria tc
		ON d.categoria = tc.id
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
	public function crear_periodo()
	{
		try {
			$user = $_SESSION['user'];
			$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : "";
			$fecha_inicio = (isset($_POST['fecha_inicio'])) ? $_POST['fecha_inicio'] : "";
			$fecha_fin = (isset($_POST['fecha_fin'])) ? $_POST['fecha_fin'] : "";
			$created_at = date("Y-m-d H:i:s", strtotime('now'));


			$stmt = $this->conn->prepare("INSERT INTO periodos(id_empresa,nombre,fecha_inicio,fecha_fin,creacion) 
				VALUES(:id_empresa,:nombre,:fecha_inicio,:fecha_fin,:creacion)");
			$stmt->bindparam(":id_empresa", $user['id_empresa']);
			$stmt->bindparam(":nombre", $nombre);
			$stmt->bindparam(":fecha_inicio", $fecha_inicio);
			$stmt->bindparam(":fecha_fin", $fecha_fin);
			$stmt->bindparam(":creacion", $created_at);


			$stmt->execute();

			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}


	public function crear_calculo()
	{
		try {

			$monto = (isset($_POST['monto'])) ? $_POST['monto'] : "";
			$cantidad_trabajadores = (isset($_POST['cantidad'])) ? $_POST['cantidad'] : "";
			$frecuencia = (isset($_POST['frecuencia'])) ? $_POST['frecuencia'] : "";
			$presupuesto = (isset($_POST['presupuesto'])) ? $_POST['presupuesto'] : "";
			$id_beneficio = (isset($_POST['id_beneficio'])) ? $_POST['id_beneficio'] : "";
			$id_periodo = (isset($_POST['id_periodo'])) ? $_POST['id_periodo'] : "";



			$stmt = $this->conn->prepare("INSERT INTO calculos_beneficios(id_beneficio, id_periodo, monto, cantidad_trabajadores, frecuencia, presupuesto) 
	VALUES (:id_beneficio, :id_periodo, :monto, :cantidad_trabajadores, :frecuencia, :presupuesto)");
			$stmt->bindparam(":id_beneficio", $id_beneficio);
			$stmt->bindparam(":id_periodo", $id_periodo);
			$stmt->bindparam(":monto", $monto);
			$stmt->bindparam(":cantidad_trabajadores", $cantidad_trabajadores);
			$stmt->bindparam(":frecuencia", $frecuencia);
			$stmt->bindparam(":presupuesto", $presupuesto);

			$stmt->execute();

			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}
	public function crear_calculox()
	{
		try {
			$monto = (isset($_POST['monto'])) ? $_POST['monto'] : "";
			$cantidad_trabajadores = (isset($_POST['cantidad'])) ? $_POST['cantidad'] : "";
			$frecuencia = (isset($_POST['frecuencia'])) ? $_POST['frecuencia'] : "";
			$presupuesto = (isset($_POST['presupuesto'])) ? $_POST['presupuesto'] : "";
			$id_beneficio = (isset($_POST['id_beneficio'])) ? $_POST['id_beneficio'] : "";
			$id_periodo = (isset($_POST['id_periodo'])) ? $_POST['id_periodo'] : "";


			$stmt = $this->conn->prepare("UPDATE calculos_beneficios 
	SET monto = :monto, cantidad_trabajadores = :cantidad_trabajadores, frecuencia = :frecuencia, presupuesto = :presupuesto 
	WHERE id_beneficio = :id_beneficio AND id_periodo = :id_periodo");
			$stmt->bindparam(":monto", $monto);
			$stmt->bindparam(":cantidad_trabajadores", $cantidad_trabajadores);
			$stmt->bindparam(":frecuencia", $frecuencia);
			$stmt->bindparam(":presupuesto", $presupuesto);
			$stmt->bindparam(":id_beneficio", $id_beneficio);
			$stmt->bindparam(":id_periodo", $id_periodo);
			$stmt->execute();

			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}
	public function editar_departamento()
	{
		try {

			$id = (isset($_POST['id'])) ? $_POST['id'] : "";
			$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : "";
			$categoria = (isset($_POST['categoria'])) ? $_POST['categoria'] : "";
			$status = (isset($_POST['status'])) ? $_POST['status'] : "";
			$updated_at = date("Y-m-d H:i:s", strtotime('now'));

			$stmt = $this->conn->prepare("UPDATE departamentos SET 
				nombre=:nombre, 
				categoria=:categoria,  
				status=:status, 
				modificado=:updated_at
				WHERE id=:id");
			$stmt->bindparam(":nombre", $nombre);
			$stmt->bindparam(":categoria", $categoria);
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
	//FIN FUNCION PARA EDITAR UN DEPARTAMENTO EN LA BD

	//FUNCION PARA ELIMINAR UN DEPARTAMENTO DE LA BD 
	public function eliminar_departamento($id)
	{

		$stmt = $this->conn->prepare("DELETE FROM departamentos WHERE id=:id");
		$stmt->bindparam(":id", $id);
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
	public function getBeneficios()
	{
		$user = $_SESSION['user'];
		$query = "SELECT * FROM beneficios WHERE id_empresa = " . $user['id_empresa'];
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
	public function getNivelEmpresarial()
	{
		$user = $_SESSION['user'];
		$query = "SELECT * FROM nivel_organizativo WHERE id_empresa = " . $user['id_empresa'] . " ORDER BY orden ASC";
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

	public function getPeriodos()
	{
		$user = $_SESSION['user'];
		$query = "SELECT * FROM periodos WHERE id_empresa = " . $user['id_empresa'];
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

	public function getNivelBeneficios($periodo)
	{
		$user = $_SESSION['user'];
		$query = "SELECT bno.id_beneficios, bno.id_nivel_organizativo
          FROM beneficios_nivel_organizativo bno 
          JOIN beneficios b ON bno.id_beneficios = b.id 
          WHERE b.id_empresa = " . $user['id_empresa'] . " AND bno.id_periodo = " . $periodo;
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

	public function getNivelBeneficiosinicial()
	{
		$user = $_SESSION['user'];
		$max_periodo_query = "SELECT MAX(id) AS max_id_periodo FROM periodos WHERE id_empresa = :id_empresa";
		$stmt_max = $this->conn->prepare($max_periodo_query);
		$stmt_max->bindValue(':id_empresa', $user['id_empresa']);
		$stmt_max->execute();
		$max_periodo_result = $stmt_max->fetch(PDO::FETCH_ASSOC);
		$max_id_periodo = $max_periodo_result['max_id_periodo'];

		$query = "SELECT bno.id_beneficios, bno.id_nivel_organizativo, bno.id_periodo
        FROM beneficios_nivel_organizativo bno
        JOIN beneficios b ON bno.id_beneficios = b.id
        WHERE b.id_empresa = :id_empresa AND bno.id_periodo = :max_id_periodo";
		$stmt = $this->conn->prepare($query);
		$stmt->bindValue(':id_empresa', $user['id_empresa']);
		$stmt->bindValue(':max_id_periodo', $max_id_periodo);
		$stmt->execute();
		$data = array();
		if ($stmt->rowCount() > 0) {
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$data[] = $row;
			}
		}
		$data['max_id_periodo'] = $max_id_periodo; // Agregar el valor de max_id_periodo
		return $data;
	}


	public function insertNivelBeneficio($beneficioId, $nivelId, $id_pe)
	{
		try {
			$query = "INSERT INTO beneficios_nivel_organizativo(id_beneficios, id_nivel_organizativo,id_periodo) VALUES(:beneficioId, :nivelId,:id_pe)";
			$stmt = $this->conn->prepare($query);
			$stmt->bindParam(':beneficioId', $beneficioId);
			$stmt->bindParam(':nivelId', $nivelId);
			$stmt->bindParam(':id_pe', $id_pe);

			$stmt->execute(); // Ejecutar la consulta
			return 2;
		} catch (PDOException $e) {
			return 3;
		}
	}
	public function deleteNivelBeneficio(
		$beneficioId,
		$nivelId,
		$id_pe
	) {
		$query = "DELETE FROM beneficios_nivel_organizativo WHERE id_beneficios = :beneficioId AND id_nivel_organizativo = :nivelId AND id_periodo = :id_pe";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':beneficioId', $beneficioId);
		$stmt->bindParam(':nivelId', $nivelId);
		$stmt->bindParam(':id_pe', $id_pe);
		$stmt->execute(); // Ejecutar la consulta

		// Mensaje de depuración
		error_log('La función deleteNivelBeneficio() se ejecutó correctamente.');
	}

	public function getCalculoBeneficio($id_beneficio, $id_periodo)
	{
		$id_beneficio = trim($id_beneficio);
		$id_beneficio = intval($id_beneficio);
		$query = "SELECT * FROM calculos_beneficios WHERE id_beneficio = :id_beneficio AND id_periodo = :id_periodo";
		$stmt = $this->conn->prepare($query);
		$stmt->bindValue(':id_beneficio', $id_beneficio);
		$stmt->bindValue(':id_periodo', $id_periodo);
		$stmt->execute();
		$data = array();

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$data[] = $row;
		}
		return $data;
	}

	public function getCalculoBeneficioPorEmpresa($id_empresa)
	{
		$user = $_SESSION['user'];

		$query = "SELECT cb.* 
              FROM calculos_beneficios cb 
              JOIN periodos p ON cb.id_periodo = p.id 
              WHERE p.id_empresa = :id_empresa";
		$stmt = $this->conn->prepare($query);
		$stmt->bindValue(':id_empresa', $user['id_empresa']);
		$stmt->execute();
		$data = array();

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$data[] = $row;
		}
		return $data;
	}

	public function eliminar_beneficio($id, $idp)
	{

		var_dump($id, $idp);
		$stmt2 = $this->conn->prepare("DELETE FROM beneficios_nivel_organizativo WHERE id_beneficios=:id AND id_periodo = :idp ");
		$stmt2->bindparam(":id", $id);
		$stmt2->bindparam(":idp", $idp);
		$stmt2->execute();

		return true;
	}
	public function get_nombre_moneda()
	{
		$user = $_SESSION['user'];
		extract($this->get_datos_empresa($user['id_empresa']));

		$stmt = $this->conn->prepare("SELECT * FROM paises WHERE id=:id_pais");
		$stmt->execute(array(":id_pais" => $id_pais));
		$editRow = $stmt->fetch(PDO::FETCH_ASSOC);
		return $editRow;
	}

	public function get_datos_empresa($id_empresa)
	{
		$stmt = $this->conn->prepare("SELECT *, nombre as nombre_empresa FROM empresas WHERE id=:id_empresa");
		$stmt->execute(array(":id_empresa" => $id_empresa));
		$editRow = $stmt->fetch(PDO::FETCH_ASSOC);
		return $editRow;
	}
}
