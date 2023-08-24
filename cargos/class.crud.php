<?php

require_once('../layouts/dbconexion_pdo.php');
define('METHOD', 'AES-256-CBC');
define('SECRET_KEY', 'SideComs*');
define('SECRET_IV', '202020');

class crud
{

	private $conn;

	public static function encryption($string)
	{
		$output = FALSE;
		$key = hash('sha256', SECRET_KEY);
		$iv = substr(hash('sha256', SECRET_IV), 0, 16);
		$output = openssl_encrypt($string, METHOD, $key, 0, $iv);
		$output = base64_encode($output);
		return $output;
	}

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

	//FUNCION PARA MOSTRAR LISTADO DE USUARIOS
	public function dataview_cargos($categoria)
	{
		$user = $_SESSION['user'];
		$query = "SELECT c.*, d.nombre AS nombre_departamento, e.nombre AS nombre_empresa
          FROM cargos c
          JOIN departamentos d ON c.id_departamento = d.id
          JOIN empresas e ON c.id_empresa = e.id
          WHERE c.categoria = " . $categoria . " 
          AND c.id_empresa = " . $user['id_empresa'] . "
          ORDER BY c.id_departamento";
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
	//FIN FUNCION PARA MOSTRAR LISTADO DE USUARIOS  



	//FUNCION PARA CREAR UN USUARIO EN LA BD
	public function crear_cargo()
	{
		try {

			$departamento = isset($_POST['departamento']) ? $_POST['departamento'] : "";
			$cargo = isset($_POST['cargo']) ? $_POST['cargo'] : "";
			$categoria = $_GET['ca'];
			$cargo2 =  strtolower($cargo);
			$user = $_SESSION['user'];

			$stmt2 = $this->conn->prepare("SELECT * FROM cargos WHERE LOWER(nombre)=:cargo AND id_departamento=:departamento AND categoria=:categoria AND id_empresa =:id_empresa");
			$stmt2->execute(array(':categoria' => $categoria, ':cargo' => $cargo2, ':departamento' => $departamento, ':id_empresa' => $user['id_empresa']));
			$userRow = $stmt2->fetch(PDO::FETCH_ASSOC);

			if ($stmt2->rowCount() == 0) {




				$descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : "";
				$status = isset($_POST['status']) ? $_POST['status'] : "";
				$created_at = date("Y-m-d H:i:s", strtotime('now'));
				$updated_at = date("Y-m-d H:i:s", strtotime('now'));


				$stmt = $this->conn->prepare("INSERT INTO cargos 
            (id_empresa, nombre, descripcion, id_departamento, categoria, creacion, modificado, status)
            VALUES
            (:id_empresa, :nombre, :descripcion, :id_departamento, :categoria, :created_at, :updated_at, :status)");

				$stmt->bindParam(":id_empresa", $user['id_empresa']);
				$stmt->bindParam(":nombre", $cargo);
				$stmt->bindParam(":categoria", $categoria);
				$stmt->bindParam(":descripcion", $descripcion);
				$stmt->bindParam(":id_departamento", $departamento);
				$stmt->bindParam(":status", $status);
				$stmt->bindParam(":created_at", $created_at);
				$stmt->bindParam(":updated_at", $updated_at);

				$stmt->execute();

				$last_id = $this->conn->lastInsertId();


				if ($categoria == 1) {
					$tabla = "valoracioncargosadmon";
					$tabla2 = "descripcion_cargos_admin";
				}

				if ($categoria == 2) {
					$tabla = "valoracioncargostaller";
					$tabla2 = "descripcion_cargos_taller";
				}

				$stmt2 = $this->conn->prepare("INSERT INTO " . $tabla . "
            ( id_cargo, id_departamento, status, creacion)
            VALUES
            ( :id_cargo, :departamento, :status, :creacion)");

				$stmt2->bindParam(":id_cargo", $last_id);
				$stmt2->bindParam(":departamento", $departamento);
				$stmt2->bindParam(":status", $status);
				$stmt2->bindParam(":creacion", $created_at);

				$stmt2->execute();


				$stmt3 = $this->conn->prepare("INSERT INTO " . $tabla2 . "
            ( id_cargo, status, creacion)
            VALUES
            ( :id_cargo, :status, :creacion)");

				$stmt3->bindParam(":id_cargo", $last_id);
				$stmt3->bindParam(":status", $status);
				$stmt3->bindParam(":creacion", $created_at);

				$stmt3->execute();

				return 2;
			} else {
				return 1;
			}
		} catch (PDOException $e) {
			throw new Exception('Error al crear el cargo: ' . $e->getMessage());
			return 0;
		}
	}


	//FIN FUNCION PARA CREAR UN USUARIOS EN LA BD

	//FUNCION PARA EDITAR UN USUARIO EN LA BD
	public function editar_cargo()
	{

		try {
			$departamento = isset($_POST['departamento']) ? $_POST['departamento'] : "";
			$cargo = isset($_POST['cargo']) ? $_POST['cargo'] : "";
			$categoria = isset($_POST['categoria']) ? $_POST['categoria'] : "";

			$departamentoold = isset($_POST['departamentoold']) ? $_POST['departamentoold'] : "";
			$cargoold = isset($_POST['cargoold']) ? $_POST['cargoold'] : "";
			$id = isset($_POST['id']) ? $_POST['id'] : "";

			$descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : "";
			$status = isset($_POST['status']) ? $_POST['status'] : "";
			$updated_at = date("Y-m-d H:i:s", strtotime('now'));
			$user = $_SESSION['user'];

			if (strtolower($cargo) != strtolower($cargoold) || $departamento != $departamentoold) {
				$cargo2 =  strtolower($cargo);

				$stmt2 = $this->conn->prepare("SELECT * FROM cargos WHERE LOWER(nombre)=:cargo AND id_departamento=:departamento AND categoria=:categoria AND id_empresa = :id_empresa");
				$stmt2->execute(array(':categoria' => $categoria, ':cargo' => $cargo2, ':departamento' => $departamento, ':id_empresa' => $user['id_empresa']));
				$userRow = $stmt2->fetch(PDO::FETCH_ASSOC);

				if ($stmt2->rowCount() == 0) {
					$stmt = $this->conn->prepare("UPDATE cargos SET
				nombre = :cargo,
				descripcion = :descripcion,
				id_departamento = :departamento,
				modificado = :updated_at,
				status = :status
				WHERE id = :id");

					$stmt->bindParam(":cargo", $cargo);
					$stmt->bindParam(":descripcion", $descripcion);
					$stmt->bindParam(":departamento", $departamento);
					$stmt->bindParam(":status", $status);
					$stmt->bindParam(":updated_at", $updated_at);
					$stmt->bindParam(":id", $id);

					$stmt->execute();

					return 2;
				} else {
					return 1;
				}
			} else {
				$stmt = $this->conn->prepare("UPDATE cargos SET
				nombre = :cargo,
				descripcion = :descripcion,
				id_departamento = :departamento,
				modificado = :updated_at,
				status = :status
				WHERE id = :id");

				$stmt->bindParam(":cargo", $cargo);
				$stmt->bindParam(":descripcion", $descripcion);
				$stmt->bindParam(":departamento", $departamento);
				$stmt->bindParam(":status", $status);
				$stmt->bindParam(":updated_at", $updated_at);
				$stmt->bindParam(":id", $id);

				$stmt->execute();

				return 2;
			}
		} catch (PDOException $e) {
			throw new Exception('Error al actualizar el cargo: ' . $e->getMessage());
			return 0;
		}
	}

	//FIN FUNCION PARA EDITAR UN USUARIO EN LA BD

	//FUNCION PARA ELIMINAR UN USUARIO DE LA BD 
	public function eliminar_cargo($id)
	{

		$stmt = $this->conn->prepare("DELETE FROM cargos WHERE id=:id");
		$stmt->bindparam(":id", $id);
		$stmt->execute();

		return true;
	}
	//FIN FUNCION PARA ELIMINAR UN USUARIO DE LA BD 

	public function editar_valoracion_adm($id_cargo)
	{
		try {

			$puntaje = isset($_POST['puntaje']) ? $_POST['puntaje'] : "";
			$grado = isset($_POST['grado']) ? $_POST['grado'] : "";
			$educacion = isset($_POST['educacion']) ? $_POST['educacion'] : "";
			$experiencia = isset($_POST['experiencia']) ? $_POST['experiencia'] : "";
			$problemas = isset($_POST['problemas']) ? $_POST['problemas'] : "";
			$supervision = isset($_POST['supervision']) ? $_POST['supervision'] : "";
			$financiera = isset($_POST['financiera']) ? $_POST['financiera'] : "";
			$maquinarias = isset($_POST['maquinarias']) ? $_POST['maquinarias'] : "";
			$contactos = isset($_POST['contactos']) ? $_POST['contactos'] : "";
			$decisiones = isset($_POST['decisiones']) ? $_POST['decisiones'] : "";
			$informacion = isset($_POST['informacion']) ? $_POST['informacion'] : "";
			$esfuerzo = isset($_POST['esfuerzo']) ? $_POST['esfuerzo'] : "";
			$mental = isset($_POST['mental']) ? $_POST['mental'] : "";
			$sensorial = isset($_POST['sensorial']) ? $_POST['sensorial'] : "";
			$ambiental = isset($_POST['ambiental']) ? $_POST['ambiental'] : "";
			$riesgo = isset($_POST['riesgo']) ? $_POST['riesgo'] : "";
			$updated_at = date("Y-m-d H:i:s", strtotime('now'));
			$formatodetallado = 1;
			$id_realizado_por = $_SESSION['user_session'];

			$stmt = $this->conn->prepare("UPDATE valoracioncargosadmon SET
			educacion = :educacion,
			experiencia = :experiencia,
			problemas = :problemas,
			supervision = :supervision,
			financiera = :financiera,
			maquinarias = :maquinarias,
			contactos = :contactos,
			decisiones = :decisiones,
			informacion = :informacion,
			esfuerzo = :esfuerzo,
			mental = :mental,
			sensorial = :sensorial,
			ambiental = :ambiental,
			riesgo = :riesgo,
			puntaje = :puntaje,
			grado = :grado,
			id_realizado_por = :id_realizado_por,
			modificado = :updated_at
			WHERE id_cargo = :id_cargo");
			$stmt->bindParam(":id_cargo", $id_cargo);
			$stmt->bindParam(":educacion", $educacion);
			$stmt->bindParam(":experiencia", $experiencia);
			$stmt->bindParam(":problemas", $problemas);
			$stmt->bindParam(":supervision", $supervision);
			$stmt->bindParam(":financiera", $financiera);
			$stmt->bindParam(":maquinarias", $maquinarias);
			$stmt->bindParam(":contactos", $contactos);
			$stmt->bindParam(":decisiones", $decisiones);
			$stmt->bindParam(":informacion", $informacion);
			$stmt->bindParam(":esfuerzo", $esfuerzo);
			$stmt->bindParam(":mental", $mental);
			$stmt->bindParam(":sensorial", $sensorial);
			$stmt->bindParam(":ambiental", $ambiental);
			$stmt->bindParam(":riesgo", $riesgo);
			$stmt->bindParam(":puntaje", $puntaje);
			$stmt->bindParam(":grado", $grado);
			$stmt->bindParam(":id_realizado_por", $id_realizado_por);
			$stmt->bindParam(":updated_at", $updated_at);
			$stmt->execute();

			$stmt = $this->conn->prepare("UPDATE cargos SET
			puntaje = :puntaje,
			grado = :grado,
			formatodetallado = :formatodetallado,
			modificado = :updated_at
			WHERE id = :id_cargo");
			$stmt->bindParam(":id_cargo", $id_cargo);
			$stmt->bindParam(":puntaje", $puntaje);
			$stmt->bindParam(":grado", $grado);
			$stmt->bindParam(":formatodetallado", $formatodetallado);
			$stmt->bindParam(":updated_at", $updated_at);
			$stmt->execute();

			return true;
		} catch (PDOException $ex) {
			$stat[0] = false;
			$stat[1] = $ex->getMessage();
			return $stat;
		}
	}

	public function editar_valoracion_adm_direct($id_cargo)
	{
		try {

			$puntaje = isset($_POST['puntajevalorado']) ? $_POST['puntajevalorado'] : "";
			$grado = isset($_POST['gradovalorado']) ? $_POST['gradovalorado'] : "";
			$updated_at = date("Y-m-d H:i:s", strtotime('now'));

			$stmt = $this->conn->prepare("UPDATE cargos SET
			puntaje = :puntaje,
			grado = :grado,
			modificado = :updated_at
			WHERE id = :id_cargo");
			$stmt->bindParam(":id_cargo", $id_cargo);
			$stmt->bindParam(":puntaje", $puntaje);
			$stmt->bindParam(":grado", $grado);
			$stmt->bindParam(":updated_at", $updated_at);
			$stmt->execute();

			return true;
		} catch (PDOException $ex) {
			$stat[0] = false;
			$stat[1] = $ex->getMessage();
			return $stat;
		}
	}

	public function editar_valoracion_taller($id_cargo)
	{
		try {

			$puntaje = isset($_POST['puntaje']) ? $_POST['puntaje'] : "";
			$grado = isset($_POST['grado']) ? $_POST['grado'] : "";
			$educacion = isset($_POST['educacion']) ? $_POST['educacion'] : "";
			$experiencia = isset($_POST['experiencia']) ? $_POST['experiencia'] : "";
			$problemas = isset($_POST['problemas']) ? $_POST['problemas'] : "";
			$maquinarias = isset($_POST['maquinarias']) ? $_POST['maquinarias'] : "";
			$contactos = isset($_POST['contactos']) ? $_POST['contactos'] : "";
			$decisiones = isset($_POST['decisiones']) ? $_POST['decisiones'] : "";
			$informacion = isset($_POST['informacion']) ? $_POST['informacion'] : "";
			$esfuerzo = isset($_POST['esfuerzo']) ? $_POST['esfuerzo'] : "";
			$mental = isset($_POST['mental']) ? $_POST['mental'] : "";
			$sensorial = isset($_POST['sensorial']) ? $_POST['sensorial'] : "";
			$ambiental = isset($_POST['ambiental']) ? $_POST['ambiental'] : "";
			$riesgo = isset($_POST['riesgo']) ? $_POST['riesgo'] : "";
			$updated_at = date("Y-m-d H:i:s", strtotime('now'));
			$id_realizado_por = $_SESSION['user_session'];
			$formatodetallado = 1;

			$stmt = $this->conn->prepare("UPDATE valoracioncargostaller SET
			educacion = :educacion,
			experiencia = :experiencia,
			problemas = :problemas,
			maquinarias = :maquinarias,
			contactos = :contactos,
			decisiones = :decisiones,
			informacion = :informacion,
			esfuerzo = :esfuerzo,
			mental = :mental,
			sensorial = :sensorial,
			ambiental = :ambiental,
			riesgo = :riesgo,
			puntaje = :puntaje,
			grado = :grado,
			id_realizado_por = :id_realizado_por,
			modificado = :updated_at
			WHERE id_cargo = :id_cargo");
			$stmt->bindParam(":id_cargo", $id_cargo);
			$stmt->bindParam(":educacion", $educacion);
			$stmt->bindParam(":experiencia", $experiencia);
			$stmt->bindParam(":problemas", $problemas);
			$stmt->bindParam(":maquinarias", $maquinarias);
			$stmt->bindParam(":contactos", $contactos);
			$stmt->bindParam(":decisiones", $decisiones);
			$stmt->bindParam(":informacion", $informacion);
			$stmt->bindParam(":esfuerzo", $esfuerzo);
			$stmt->bindParam(":mental", $mental);
			$stmt->bindParam(":sensorial", $sensorial);
			$stmt->bindParam(":ambiental", $ambiental);
			$stmt->bindParam(":riesgo", $riesgo);
			$stmt->bindParam(":puntaje", $puntaje);
			$stmt->bindParam(":grado", $grado);
			$stmt->bindParam(":id_realizado_por", $id_realizado_por);
			$stmt->bindParam(":updated_at", $updated_at);
			$stmt->execute();

			$stmt = $this->conn->prepare("UPDATE cargos SET
			puntaje = :puntaje,
			grado = :grado,
			formatodetallado = :formatodetallado,
			modificado = :updated_at
			WHERE id = :id_cargo");
			$stmt->bindParam(":id_cargo", $id_cargo);
			$stmt->bindParam(":puntaje", $puntaje);
			$stmt->bindParam(":grado", $grado);
			$stmt->bindParam(":formatodetallado", $formatodetallado);
			$stmt->bindParam(":updated_at", $updated_at);
			$stmt->execute();

			return true;
		} catch (PDOException $ex) {
			$stat[0] = false;
			$stat[1] = $ex->getMessage();
			return $stat;
		}
	}

	public function editar_valoracion_taller_direct($id_cargo)
	{
		try {

			$puntaje = isset($_POST['puntajevalorado']) ? $_POST['puntajevalorado'] : "";
			$grado = isset($_POST['gradovalorado']) ? $_POST['gradovalorado'] : "";
			$updated_at = date("Y-m-d H:i:s", strtotime('now'));

			$stmt = $this->conn->prepare("UPDATE cargos SET
			puntaje = :puntaje,
			grado = :grado,
			modificado = :updated_at
			WHERE id = :id_cargo");
			$stmt->bindParam(":id_cargo", $id_cargo);
			$stmt->bindParam(":puntaje", $puntaje);
			$stmt->bindParam(":grado", $grado);
			$stmt->bindParam(":updated_at", $updated_at);
			$stmt->execute();

			return true;
		} catch (PDOException $ex) {
			$stat[0] = false;
			$stat[1] = $ex->getMessage();
			return $stat;
		}
	}


	public function get_departamentos($categoria)
	{
		try {
			$user = $_SESSION['user'];
			$stmt = $this->conn->prepare("SELECT * FROM departamentos 
			WHERE id_empresa = " . $user['id_empresa'] . " 
			AND categoria = " . $categoria);
			$stmt->execute();
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $results;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}
	public function get_grados_administrativos($id)
	{
		try {
			$stmt = $this->conn->prepare("SELECT tipo_empresa, grado, minimo, maximo FROM tipo_escala_empresarial 
			JOIN empresas ON tipo_escala_empresarial.tipo_empresa COLLATE utf8_unicode_ci = 
			empresas.id_escala_administrativo COLLATE utf8_unicode_ci WHERE tipo_escala_empresarial.categoria = 1 
			 AND empresas.id = :id");
			$stmt->bindparam(":id", $id);
			$stmt->execute();
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $results;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

	public function get_grados_taller($id)
	{
		try {
			$stmt = $this->conn->prepare("SELECT tipo_empresa, grado, minimo, maximo FROM tipo_escala_empresarial 
			JOIN empresas ON tipo_escala_empresarial.tipo_empresa COLLATE utf8_unicode_ci = 
			empresas.id_escala_planta COLLATE utf8_unicode_ci WHERE tipo_escala_empresarial.categoria = 2
			 AND empresas.id = :id");
			$stmt->bindparam(":id", $id);
			$stmt->execute();
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $results;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

	public function get_cargo_descripcion_admin($id)
	{
		try {
			$stmt = $this->conn->prepare("SELECT descripcion_cargos_admin.*, cargos.nombre AS nombre_cargo, departamentos.nombre AS nombre_departamento 
			FROM descripcion_cargos_admin JOIN cargos ON descripcion_cargos_admin.id_cargo = 
			cargos.id JOIN departamentos ON cargos.id_departamento = departamentos.id WHERE descripcion_cargos_admin.id_cargo =:id");
			$stmt->bindparam(":id", $id);
			$stmt->execute();
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $results;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

	public function get_cargo_descripcion_taller($id)
	{
		try {
			$stmt = $this->conn->prepare("SELECT descripcion_cargos_taller.*, cargos.nombre AS nombre_cargo, departamentos.nombre AS nombre_departamento 
			FROM descripcion_cargos_taller JOIN cargos ON descripcion_cargos_taller.id_cargo = 
			cargos.id JOIN departamentos ON cargos.id_departamento = departamentos.id WHERE descripcion_cargos_taller.id_cargo =:id");
			$stmt->bindparam(":id", $id);
			$stmt->execute();
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $results;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}


	public function update_descripcion_cargo(
		$id_cargo,
		$organigrama,
		$proposito,
		$funcion2,
		$funcion1,
		$funcion3,
		$funcion4,
		$funcion5,
		$funcion6,
		$funcion7,
		$funcion8,
		$funcion9,
		$funcion10,
		$actividad1,
		$actividad2,
		$actividad3,
		$actividad4,
		$actividad5,
		$actividad6,
		$actividad7,
		$actividad8,
		$actividad9,
		$actividad10,
		$actividad11,
		$actividad12,
		$actividad13,
		$actividad14,
		$actividad15,
		$selectactividad1,
		$selectactividad2,
		$selectactividad3,
		$selectactividad4,
		$selectactividad5,
		$selectactividad6,
		$selectactividad7,
		$selectactividad8,
		$selectactividad9,
		$selectactividad10,
		$selectactividad11,
		$selectactividad12,
		$selectactividad13,
		$selectactividad14,
		$selectactividad15,
		$conocimiento1Valor,
		$conocimiento2Valor,
		$conocimiento3Valor,
		$conocimiento4Valor,
		$conocimiento5Valor,
		$conocimiento6Valor,
		$conocimiento7Valor,
		$conocimiento1texto,
		$conocimiento2texto,
		$conocimiento3texto,
		$conocimiento4texto,
		$conocimiento5texto,
		$conocimiento6texto,
		$conocimiento7texto,
		$competencia1,
		$competencia2,
		$competencia3,
		$competencia4,
		$competencia5,
		$competencia6,
		$competencia7,
		$competencia8,
		$competencia9,
		$competencia10,
		$presupuesto,
		$ingreso,
		$gasto,
		$empleados,
		$obreros,
		$ejecutivos,
		$conocimiento,
		$adicional,
		$relacionesInternas,
		$relacionesExternas,
		$ambientales,
		$riesgo,
		$comentarios,
		$destrezas,
		$fecha_preparacion,
		$revisado,
		$supervisor,
		$ambiente,
		$instrumento,
		$manipulacion,
		$traslado,
		$destrezainstrumento,
		$destrezaequipo,
		$destrezasistema,
		$destrezacomputacion,
		$destrezaotro,
		$experiencia,
		$idiomas
	) {
		try {
			$updated_at = date("Y-m-d H:i:s", strtotime('now'));
			$stmt = $this->conn->prepare("UPDATE descripcion_cargos_admin SET
            organigrama = :organigrama,
            proposito = :proposito,
            funcion1 = :funcion1,
            funcion2 = :funcion2,
            funcion3 = :funcion3,
            funcion4 = :funcion4,
            funcion5 = :funcion5,
            funcion6 = :funcion6,
            funcion7 = :funcion7,
            funcion8 = :funcion8,
            funcion9 = :funcion9,
            funcion10 = :funcion10,
            actividad1 = :actividad1,
            actividad2 = :actividad2,
            actividad3 = :actividad3,
            actividad4 = :actividad4,
            actividad5 = :actividad5,
            actividad6 = :actividad6,
            actividad7 = :actividad7,
            actividad8 = :actividad8,
            actividad9 = :actividad9,
            actividad10 = :actividad10,
            actividad11 = :actividad11,
            actividad12 = :actividad12,
            actividad13 = :actividad13,
            actividad14 = :actividad14,
            actividad15 = :actividad15,
            selectactividad1 = :selectactividad1,
            selectactividad2 = :selectactividad2,
            selectactividad3 = :selectactividad3,
            selectactividad4 = :selectactividad4,
            selectactividad5 = :selectactividad5,
            selectactividad6 = :selectactividad6,
            selectactividad7 = :selectactividad7,
            selectactividad8 = :selectactividad8,
            selectactividad9 = :selectactividad9,
            selectactividad10 = :selectactividad10,
            selectactividad11 = :selectactividad11,
            selectactividad12 = :selectactividad12,
            selectactividad13 = :selectactividad13,
            selectactividad14 = :selectactividad14,
            selectactividad15 = :selectactividad15,
            conocimiento1 = :conocimiento1Valor,
            conocimiento2 = :conocimiento2Valor,
            conocimiento3 = :conocimiento3Valor,
            conocimiento4 = :conocimiento4Valor,
            conocimiento5 = :conocimiento5Valor,
            conocimiento6 = :conocimiento6Valor,
            conocimiento7 = :conocimiento7Valor,
            conocimiento1texto = :conocimiento1texto,
            conocimiento2texto = :conocimiento2texto,
            conocimiento3texto = :conocimiento3texto,
            conocimiento4texto = :conocimiento4texto,
            conocimiento5texto = :conocimiento5texto,
            conocimiento6texto = :conocimiento6texto,
            conocimiento7texto = :conocimiento7texto,
            competencia1 = :competencia1,
            competencia2 = :competencia2,
            competencia3 = :competencia3,
            competencia4 = :competencia4,
            competencia5 = :competencia5,
            competencia6 = :competencia6,
            competencia7 = :competencia7,
            competencia8 = :competencia8,
            competencia9 = :competencia9,
            competencia10 = :competencia10,
            presupuesto = :presupuesto,
            ingreso = :ingreso,
            gasto = :gasto,
            empleados = :empleados,
            obreros = :obreros,
			ejecutivos = :ejecutivos,
            conocimiento = :conocimiento,
            especialidad_adicional = :adicional,
            ambiental = :ambientales,
            riesgo = :riesgo,
            comentarios_riesgo = :comentarios,
            destrezas = :destrezas,
			relacion_externa = :relacionesExternas,
			relacion_interna = :relacionesInternas,
            modificado = :updated_at,
			fecha_preparacion = :fecha_preparacion,
			revisado = :revisado,
            supervisor = :supervisor,
			ambiente = :ambiente,
			instrumento = :instrumento,
			manipulacion = :manipulacion,
			traslado = :traslado,
			destrezainstrumento = :destrezainstrumento,
			destrezaequipo = :destrezaequipo,
			destrezasistema = :destrezacomputacion,
			destrezacomputacion = :destrezacomputacion,
			destrezaotro = :destrezaotro,
			experiencia = :experiencia,
			idiomas = :idiomas
            WHERE id_cargo = :id_cargo");

			$stmt->bindParam(':organigrama', $organigrama);
			$stmt->bindParam(':proposito', $proposito);
			$stmt->bindParam(':funcion1', $funcion1);
			$stmt->bindParam(':funcion2', $funcion2);
			$stmt->bindParam(':funcion3', $funcion3);
			$stmt->bindParam(':funcion4', $funcion4);
			$stmt->bindParam(':funcion5', $funcion5);
			$stmt->bindParam(':funcion6', $funcion6);
			$stmt->bindParam(':funcion7', $funcion7);
			$stmt->bindParam(':funcion8', $funcion8);
			$stmt->bindParam(':funcion9', $funcion9);
			$stmt->bindParam(':funcion10', $funcion10);
			$stmt->bindParam(':actividad1', $actividad1);
			$stmt->bindParam(':actividad2', $actividad2);
			$stmt->bindParam(':actividad3', $actividad3);
			$stmt->bindParam(':actividad4', $actividad4);
			$stmt->bindParam(':actividad5', $actividad5);
			$stmt->bindParam(':actividad6', $actividad6);
			$stmt->bindParam(':actividad7', $actividad7);
			$stmt->bindParam(':actividad8', $actividad8);
			$stmt->bindParam(':actividad9', $actividad9);
			$stmt->bindParam(':actividad10', $actividad10);
			$stmt->bindParam(':actividad11', $actividad11);
			$stmt->bindParam(':actividad12', $actividad12);
			$stmt->bindParam(':actividad13', $actividad13);
			$stmt->bindParam(':actividad14', $actividad14);
			$stmt->bindParam(':actividad15', $actividad15);
			$stmt->bindParam(':selectactividad1', $selectactividad1);
			$stmt->bindParam(':selectactividad2', $selectactividad2);
			$stmt->bindParam(':selectactividad3', $selectactividad3);
			$stmt->bindParam(':selectactividad4', $selectactividad4);
			$stmt->bindParam(':selectactividad5', $selectactividad5);
			$stmt->bindParam(':selectactividad6', $selectactividad6);
			$stmt->bindParam(':selectactividad7', $selectactividad7);
			$stmt->bindParam(':selectactividad8', $selectactividad8);
			$stmt->bindParam(':selectactividad9', $selectactividad9);
			$stmt->bindParam(':selectactividad10', $selectactividad10);
			$stmt->bindParam(':selectactividad11', $selectactividad11);
			$stmt->bindParam(':selectactividad12', $selectactividad12);
			$stmt->bindParam(':selectactividad13', $selectactividad13);
			$stmt->bindParam(':selectactividad14', $selectactividad14);
			$stmt->bindParam(':selectactividad15', $selectactividad15);
			$stmt->bindParam(':conocimiento1Valor', $conocimiento1Valor);
			$stmt->bindParam(':conocimiento2Valor', $conocimiento2Valor);
			$stmt->bindParam(':conocimiento3Valor', $conocimiento3Valor);
			$stmt->bindParam(':conocimiento4Valor', $conocimiento4Valor);
			$stmt->bindParam(':conocimiento5Valor', $conocimiento5Valor);
			$stmt->bindParam(':conocimiento6Valor', $conocimiento6Valor);
			$stmt->bindParam(':conocimiento7Valor', $conocimiento7Valor);
			$stmt->bindParam(':conocimiento1texto', $conocimiento1texto);
			$stmt->bindParam(':conocimiento2texto', $conocimiento2texto);
			$stmt->bindParam(':conocimiento3texto', $conocimiento3texto);
			$stmt->bindParam(':conocimiento4texto', $conocimiento4texto);
			$stmt->bindParam(':conocimiento5texto', $conocimiento5texto);
			$stmt->bindParam(':conocimiento6texto', $conocimiento6texto);
			$stmt->bindParam(':conocimiento7texto', $conocimiento7texto);
			$stmt->bindParam(':competencia1', $competencia1);
			$stmt->bindParam(':competencia2', $competencia2);
			$stmt->bindParam(':competencia3', $competencia3);
			$stmt->bindParam(':competencia4', $competencia4);
			$stmt->bindParam(':competencia5', $competencia5);
			$stmt->bindParam(':competencia6', $competencia6);
			$stmt->bindParam(':competencia7', $competencia7);
			$stmt->bindParam(':competencia8', $competencia8);
			$stmt->bindParam(':competencia9', $competencia9);
			$stmt->bindParam(':competencia10', $competencia10);
			$stmt->bindParam(':presupuesto', $presupuesto);
			$stmt->bindParam(':ingreso', $ingreso);
			$stmt->bindParam(':gasto', $gasto);
			$stmt->bindParam(':empleados', $empleados);
			$stmt->bindParam(':obreros', $obreros);
			$stmt->bindParam(':ejecutivos', $ejecutivos);
			$stmt->bindParam(':conocimiento', $conocimiento);
			$stmt->bindParam(':adicional', $adicional);
			$stmt->bindParam(':ambientales', $ambientales);
			$stmt->bindParam(':riesgo', $riesgo);
			$stmt->bindParam(':comentarios', $comentarios);
			$stmt->bindParam(":destrezas", $destrezas);
			$stmt->bindParam(":updated_at", $updated_at);
			$stmt->bindParam(":relacionesExternas", $relacionesExternas);
			$stmt->bindParam(":relacionesInternas", $relacionesInternas);
			$stmt->bindParam(":id_cargo", $id_cargo);
			$stmt->bindParam(":fecha_preparacion", $fecha_preparacion);
			$stmt->bindParam(":revisado", $revisado);
			$stmt->bindParam(":supervisor", $supervisor);
			$stmt->bindParam(":ambiente", $ambiente);
			$stmt->bindParam(":instrumento", $instrumento);
			$stmt->bindParam(":manipulacion", $manipulacion);
			$stmt->bindParam(":traslado", $traslado);
			$stmt->bindParam(":destrezainstrumento", $destrezainstrumento);
			$stmt->bindParam(":destrezaequipo", $destrezaequipo);
			$stmt->bindParam(":destrezasistema", $destrezasistema);
			$stmt->bindParam(":destrezacomputacion", $destrezacomputacion);
			$stmt->bindParam(":destrezaotro", $destrezaotro);
			$stmt->bindParam(":experiencia", $experiencia);
			$stmt->bindParam(":idiomas", $idiomas);
			$stmt->execute();
			return 2;
		} catch (PDOException $e) {
			throw new Exception('Error al actualizar la descripción del cargo: ' . $e->getMessage());
			return 0;
		}
	}

	public function update_descripcion_cargo_taller(
		$id_cargo,
		$funciones,
		$actividades,
		$ambiente1,
		$ambiente2,
		$ambiente3,
		$ambiente4,
		$ambiente5,
		$instrumento1,
		$instrumento2,
		$manipular_elementos,
		$maquina1,
		$maquina2,
		$maquina3,
		$maquina4,
		$maquina5,
		$maquina6,
		$otras_maquinas,
		$traslado1,
		$traslado2,
		$traslado3,
		$traslado4,
		$frecuencia_traslado,
		$observacion_ambiente,
		$conocimiento,
		$especialidad_carrera,
		$especialidad_adicional,
		$experiencia,
		$relacion_interna,
		$relacion_externa,
		$riesgo,
		$comentarios_riesgo,
		$habilidad1,
		$habilidad2,
		$habilidad3,
		$habilidad4,
		$habilidad5,
		$habilidad6,
		$habilidad7,
		$habilidad8,
		$destrezas,
		$proposito,
		$funcion2,
		$funcion1,
		$funcion3,
		$funcion4,
		$funcion5,
		$funcion6,
		$funcion7,
		$funcion8,
		$funcion9,
		$funcion10,
		$actividad1,
		$actividad2,
		$actividad3,
		$actividad4,
		$actividad5,
		$actividad6,
		$actividad7,
		$actividad8,
		$actividad9,
		$actividad10,
		$actividad11,
		$actividad12,
		$actividad13,
		$actividad14,
		$actividad15,
		$selectactividad1,
		$selectactividad2,
		$selectactividad3,
		$selectactividad4,
		$selectactividad5,
		$selectactividad6,
		$selectactividad7,
		$selectactividad8,
		$selectactividad9,
		$selectactividad10,
		$selectactividad11,
		$selectactividad12,
		$selectactividad13,
		$selectactividad14,
		$selectactividad15,
		$competencia1,
		$competencia2,
		$competencia3,
		$competencia4,
		$competencia5,
		$competencia6,
		$competencia7,
		$competencia8,
		$competencia9,
		$competencia10,
		$destrezainstrumento,
		$destrezaequipo,
		$destrezasistema,
		$destrezacomputacion,
		$destrezaotro
	) {
		try {
			$updated_at = date("Y-m-d H:i:s", strtotime('now'));

			$stmt = $this->conn->prepare("UPDATE descripcion_cargos_taller SET 
			 proposito = :proposito,
            funcion1 = :funcion1,
            funcion2 = :funcion2,
            funcion3 = :funcion3,
            funcion4 = :funcion4,
            funcion5 = :funcion5,
            funcion6 = :funcion6,
            funcion7 = :funcion7,
            funcion8 = :funcion8,
            funcion9 = :funcion9,
            funcion10 = :funcion10,
            actividad1 = :actividad1,
            actividad2 = :actividad2,
            actividad3 = :actividad3,
            actividad4 = :actividad4,
            actividad5 = :actividad5,
            actividad6 = :actividad6,
            actividad7 = :actividad7,
            actividad8 = :actividad8,
            actividad9 = :actividad9,
            actividad10 = :actividad10,
            actividad11 = :actividad11,
            actividad12 = :actividad12,
            actividad13 = :actividad13,
            actividad14 = :actividad14,
            actividad15 = :actividad15,
            selectactividad1 = :selectactividad1,
            selectactividad2 = :selectactividad2,
            selectactividad3 = :selectactividad3,
            selectactividad4 = :selectactividad4,
            selectactividad5 = :selectactividad5,
            selectactividad6 = :selectactividad6,
            selectactividad7 = :selectactividad7,
            selectactividad8 = :selectactividad8,
            selectactividad9 = :selectactividad9,
            selectactividad10 = :selectactividad10,
            selectactividad11 = :selectactividad11,
            selectactividad12 = :selectactividad12,
            selectactividad13 = :selectactividad13,
            selectactividad14 = :selectactividad14,
            selectactividad15 = :selectactividad15,
			competencia1 = :competencia1,
            competencia2 = :competencia2,
            competencia3 = :competencia3,
            competencia4 = :competencia4,
            competencia5 = :competencia5,
            competencia6 = :competencia6,
            competencia7 = :competencia7,
            competencia8 = :competencia8,
            competencia9 = :competencia9,
            competencia10 = :competencia10,
            funciones = :funciones,
            actividades = :actividades,
            ambiente1 = :ambiente1,
            ambiente2 = :ambiente2,
            ambiente3 = :ambiente3,
            ambiente4 = :ambiente4,
            ambiente5 = :ambiente5,
            instrumento1 = :instrumento1,
            instrumento2 = :instrumento2,
            manipular_elementos = :manipular_elementos,
            maquina1 = :maquina1,
            maquina2 = :maquina2,
            maquina3 = :maquina3,
            maquina4 = :maquina4,
            maquina5 = :maquina5,
            maquina6 = :maquina6,
            otras_maquinas = :otras_maquinas,
            traslado1 = :traslado1,
            traslado2 = :traslado2,
            traslado3 = :traslado3,
            traslado4 = :traslado4,
            frecuencia_traslado = :frecuencia_traslado,
            observacion_ambiente = :observacion_ambiente,
            conocimiento = :conocimiento,
            especialidad_carrera = :especialidad_carrera,
            especialidad_adicional = :especialidad_adicional,
            experiencia = :experiencia,
            relacion_interna = :relacion_interna,
            relacion_externa = :relacion_externa,
            riesgo = :riesgo,
            comentarios_riesgo = :comentarios_riesgo,
            habilidad1 = :habilidad1,
            habilidad2 = :habilidad2,
            habilidad3 = :habilidad3,
            habilidad4 = :habilidad4,
            habilidad5 = :habilidad5,
            habilidad6 = :habilidad6,
            habilidad7 = :habilidad7,
            habilidad8 = :habilidad8,
            destrezas = :destrezas,
            modificado = :updated_at,
			destrezainstrumento = :destrezainstrumento,
			destrezaequipo = :destrezaequipo,
			destrezasistema = :destrezacomputacion,
			destrezacomputacion = :destrezacomputacion,
			destrezaotro = :destrezaotro
            WHERE id_cargo = :id_cargo");

			$stmt->bindParam(":funciones", $funciones);
			$stmt->bindParam(":actividades", $actividades);
			$stmt->bindParam(":ambiente1", $ambiente1);
			$stmt->bindParam(":ambiente2", $ambiente2);
			$stmt->bindParam(":ambiente3", $ambiente3);
			$stmt->bindParam(":ambiente4", $ambiente4);
			$stmt->bindParam(":ambiente5", $ambiente5);
			$stmt->bindParam(":instrumento1", $instrumento1);
			$stmt->bindParam(":instrumento2", $instrumento2);
			$stmt->bindParam(":manipular_elementos", $manipular_elementos);
			$stmt->bindParam(":maquina1", $maquina1);
			$stmt->bindParam(":maquina2", $maquina2);
			$stmt->bindParam(":maquina3", $maquina3);
			$stmt->bindParam(":maquina4", $maquina4);
			$stmt->bindParam(":maquina5", $maquina5);
			$stmt->bindParam(":maquina6", $maquina6);
			$stmt->bindParam(":otras_maquinas", $otras_maquinas);
			$stmt->bindParam(":traslado1", $traslado1);
			$stmt->bindParam(":traslado2", $traslado2);
			$stmt->bindParam(":traslado3", $traslado3);
			$stmt->bindParam(":traslado4", $traslado4);
			$stmt->bindParam(":frecuencia_traslado", $frecuencia_traslado);
			$stmt->bindParam(":observacion_ambiente", $observacion_ambiente);
			$stmt->bindParam(":conocimiento", $conocimiento);
			$stmt->bindParam(":especialidad_carrera", $especialidad_carrera);
			$stmt->bindParam(":especialidad_adicional", $especialidad_adicional);
			$stmt->bindParam(":experiencia", $experiencia);
			$stmt->bindParam(":relacion_interna", $relacion_interna);
			$stmt->bindParam(":relacion_externa", $relacion_externa);
			$stmt->bindParam(":riesgo", $riesgo);
			$stmt->bindParam(":comentarios_riesgo", $comentarios_riesgo);
			$stmt->bindParam(":habilidad1", $habilidad1);
			$stmt->bindParam(":habilidad2", $habilidad2);
			$stmt->bindParam(":habilidad3", $habilidad3);
			$stmt->bindParam(":habilidad4", $habilidad4);
			$stmt->bindParam(":habilidad5", $habilidad5);
			$stmt->bindParam(":habilidad6", $habilidad6);
			$stmt->bindParam(":habilidad7", $habilidad7);
			$stmt->bindParam(":habilidad8", $habilidad8);
			$stmt->bindParam(":destrezas", $destrezas);
			$stmt->bindParam(":updated_at", $updated_at);
			$stmt->bindParam(":id_cargo", $id_cargo);
			$stmt->bindParam(':proposito', $proposito);
			$stmt->bindParam(':funcion1', $funcion1);
			$stmt->bindParam(':funcion2', $funcion2);
			$stmt->bindParam(':funcion3', $funcion3);
			$stmt->bindParam(':funcion4', $funcion4);
			$stmt->bindParam(':funcion5', $funcion5);
			$stmt->bindParam(':funcion6', $funcion6);
			$stmt->bindParam(':funcion7', $funcion7);
			$stmt->bindParam(':funcion8', $funcion8);
			$stmt->bindParam(':funcion9', $funcion9);
			$stmt->bindParam(':funcion10', $funcion10);
			$stmt->bindParam(':actividad1', $actividad1);
			$stmt->bindParam(':actividad2', $actividad2);
			$stmt->bindParam(':actividad3', $actividad3);
			$stmt->bindParam(':actividad4', $actividad4);
			$stmt->bindParam(':actividad5', $actividad5);
			$stmt->bindParam(':actividad6', $actividad6);
			$stmt->bindParam(':actividad7', $actividad7);
			$stmt->bindParam(':actividad8', $actividad8);
			$stmt->bindParam(':actividad9', $actividad9);
			$stmt->bindParam(':actividad10', $actividad10);
			$stmt->bindParam(':actividad11', $actividad11);
			$stmt->bindParam(':actividad12', $actividad12);
			$stmt->bindParam(':actividad13', $actividad13);
			$stmt->bindParam(':actividad14', $actividad14);
			$stmt->bindParam(':actividad15', $actividad15);
			$stmt->bindParam(':selectactividad1', $selectactividad1);
			$stmt->bindParam(':selectactividad2', $selectactividad2);
			$stmt->bindParam(':selectactividad3', $selectactividad3);
			$stmt->bindParam(':selectactividad4', $selectactividad4);
			$stmt->bindParam(':selectactividad5', $selectactividad5);
			$stmt->bindParam(':selectactividad6', $selectactividad6);
			$stmt->bindParam(':selectactividad7', $selectactividad7);
			$stmt->bindParam(':selectactividad8', $selectactividad8);
			$stmt->bindParam(':selectactividad9', $selectactividad9);
			$stmt->bindParam(':selectactividad10', $selectactividad10);
			$stmt->bindParam(':selectactividad11', $selectactividad11);
			$stmt->bindParam(':selectactividad12', $selectactividad12);
			$stmt->bindParam(':selectactividad13', $selectactividad13);
			$stmt->bindParam(':selectactividad14', $selectactividad14);
			$stmt->bindParam(':selectactividad15', $selectactividad15);
			$stmt->bindParam(':competencia1', $competencia1);
			$stmt->bindParam(':competencia2', $competencia2);
			$stmt->bindParam(':competencia3', $competencia3);
			$stmt->bindParam(':competencia4', $competencia4);
			$stmt->bindParam(':competencia5', $competencia5);
			$stmt->bindParam(':competencia6', $competencia6);
			$stmt->bindParam(':competencia7', $competencia7);
			$stmt->bindParam(':competencia8', $competencia8);
			$stmt->bindParam(':competencia9', $competencia9);
			$stmt->bindParam(':competencia10', $competencia10);
			$stmt->bindParam(":destrezainstrumento", $destrezainstrumento);
			$stmt->bindParam(":destrezaequipo", $destrezaequipo);
			$stmt->bindParam(":destrezasistema", $destrezasistema);
			$stmt->bindParam(":destrezacomputacion", $destrezacomputacion);
			$stmt->bindParam(":destrezaotro", $destrezaotro);
			$stmt->execute();



			return 2;
		} catch (PDOException $e) {
			throw new Exception('Error al actualizar la descripción del cargo: ' . $e->getMessage());
			return 0;
		}
	}

	//BUSCAR VALORACION DE CARGO ADM POR ID DE CARGO
	public function get_formato_cargo($id_cargo)
	{
		$stmt = $this->conn->prepare("SELECT formatodetallado
	FROM cargos 
	WHERE id=:id_cargo");
		$stmt->execute(array(":id_cargo" => $id_cargo));
		$editRow = $stmt->fetch(PDO::FETCH_ASSOC);
		return $editRow;
	}
	//FIN BUSCAR VALORACION DE CARGO ADM POR ID DE CARGO


	//BUSCAR VALORACION DE CARGO ADM POR ID DE CARGO
	public function get_valoracion_adm($id_cargo)
	{
		$stmt = $this->conn->prepare("SELECT vca.*, c.nombre as nombrecargo, d.nombre as nombredepartamento, c.grado as gradocargo
		FROM valoracioncargosadmon vca
		INNER JOIN cargos c ON c.id = vca.id_cargo
		INNER JOIN departamentos d ON d.id = vca.id_departamento
		WHERE id_cargo=:id_cargo");
		$stmt->execute(array(":id_cargo" => $id_cargo));
		$editRow = $stmt->fetch(PDO::FETCH_ASSOC);
		return $editRow;
	}
	//FIN BUSCAR VALORACION DE CARGO ADM POR ID DE CARGO

	//BUSCAR VALORACION DE CARGO TALLER POR ID DE CARGO
	public function get_valoracion_taller($id_cargo)
	{
		$stmt = $this->conn->prepare("SELECT vct.*, c.nombre as nombrecargo, d.nombre as nombredepartamento, c.grado as gradocargo
		FROM valoracioncargostaller vct
		INNER JOIN cargos c ON c.id = vct.id_cargo
		INNER JOIN departamentos d ON d.id = vct.id_departamento
		WHERE id_cargo=:id_cargo");
		$stmt->execute(array(":id_cargo" => $id_cargo));
		$editRow = $stmt->fetch(PDO::FETCH_ASSOC);
		return $editRow;
	}


	public function get_relaciones_externas()
	{
		try {
			$stmt = $this->conn->prepare("SELECT * FROM relaciones_externas");
			$stmt->execute();
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $results;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}
	public function get_competencias()
	{
		try {
			$stmt = $this->conn->prepare("SELECT * FROM competencias ORDER BY nombre ASC");
			$stmt->execute();
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $results;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

	public function get_grado_x_puntaje_adm($puntaje)
	{
		$user = $_SESSION['user'];
		$id_escala = "";
		$stmt2 = $this->conn->prepare("SELECT * FROM empresas WHERE id=:id_empresa");
		$stmt2->execute(array(':id_empresa' => $user['id_empresa']));
		$userRow = $stmt2->fetch(PDO::FETCH_ASSOC);

		if ($stmt2->rowCount() == 1) {
			$id_escala = $userRow['id_escala_administrativo'];

			$stmt = $this->conn->prepare("SELECT grado FROM tipo_escala_empresarial WHERE tipo_empresa = :id_escala AND minimo <= :puntaje 
		AND maximo >= :puntaje AND categoria = 1");
			$stmt->execute(array(":id_escala" => $id_escala, ":puntaje" => $puntaje));
			$editRow = $stmt->fetch(PDO::FETCH_ASSOC);
			return $editRow;
		}
	}

	public function get_grado_x_puntaje_taller($puntaje)
	{
		$user = $_SESSION['user'];
		$id_escala = "";
		$stmt2 = $this->conn->prepare("SELECT * FROM empresas WHERE id=:id_empresa");
		$stmt2->execute(array(':id_empresa' => $user['id_empresa']));
		$userRow = $stmt2->fetch(PDO::FETCH_ASSOC);

		if ($stmt2->rowCount() == 1) {
			$id_escala = $userRow['id_escala_planta'];

			$stmt = $this->conn->prepare("SELECT grado FROM tipo_escala_empresarial WHERE tipo_empresa = :id_escala AND minimo <= :puntaje 
		AND maximo >= :puntaje AND categoria = 2");
			$stmt->execute(array(":id_escala" => $id_escala, ":puntaje" => $puntaje));
			$editRow = $stmt->fetch(PDO::FETCH_ASSOC);
			return $editRow;
		}
	}

	public function get_empresa()
	{
		try {
			$user = $_SESSION['user'];
			$stmt = $this->conn->prepare("SELECT empresas.*
				FROM empresas WHERE empresas.id = :id_empresa");
			$stmt->bindParam(':id_empresa', $user['id_empresa']);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);

			if ($result) {
				return $result;
			} else {
				return false;
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

	//FUNCION PARA MOSTRAR LISTADO DE DEPARTAMENTOS
	public function dataview_escalas($categoria)
	{
		$user = $_SESSION['user'];
		$id_escala = "";
		$stmt2 = $this->conn->prepare("SELECT * FROM empresas WHERE id=:id_empresa");
		$stmt2->execute(array(':id_empresa' => $user['id_empresa']));
		$userRow = $stmt2->fetch(PDO::FETCH_ASSOC);

		if ($stmt2->rowCount() == 1) {


			if ($categoria == 1) {
				$id_escala = $userRow['id_escala_administrativo'];
			}
			if ($categoria == 2) {
				$id_escala = $userRow['id_escala_planta'];
			}

			$query = "SELECT grado, minimo, maximo FROM tipo_escala_empresarial 
	WHERE categoria = " . $categoria . "
	AND tipo_empresa = " . $id_escala;
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
	}
	//FIN FUNCION PARA MOSTRAR LISTADO DE DEPARTAMENTOS  

	//BUSCAR NOMBRE DE MONEDA POR ID DE PAIS
	public function get_nombre_moneda()
	{
		$user = $_SESSION['user'];
		extract($this->get_datos_empresa($user['id_empresa']));

		$stmt = $this->conn->prepare("SELECT * FROM paises WHERE id=:id_pais");
		$stmt->execute(array(":id_pais" => $id_pais));
		$editRow = $stmt->fetch(PDO::FETCH_ASSOC);
		return $editRow;
	}
	//FIN BUSCAR NOMBRE DE MONEDA POR ID DE PAIS

	//BUSCAR NOMBRE DE MONEDA POR ID DE PAIS
	public function get_datos_empresa($id_empresa)
	{
		$stmt = $this->conn->prepare("SELECT *, nombre as nombre_empresa FROM empresas WHERE id=:id_empresa");
		$stmt->execute(array(":id_empresa" => $id_empresa));
		$editRow = $stmt->fetch(PDO::FETCH_ASSOC);
		return $editRow;
	}
	//FIN BUSCAR NOMBRE DE MONEDA POR ID DE PAIS

	//BUSCAR NOMBRE DE MONEDA POR ID DE PAIS
	public function get_sum_empleados($categoria)
	{
		$user = $_SESSION['user'];
		$stmt = $this->conn->prepare("SELECT COUNT(*) as conteo
	FROM matriz_nomina mn 
	INNER JOIN cargos c ON c.id = mn.id_cargo
	WHERE categoria=:categoria
	AND mn.id_empresa = " . $user['id_empresa']);
		$stmt->execute(array(":categoria" => $categoria));
		$editRow = $stmt->fetch(PDO::FETCH_ASSOC);
		return $editRow;
	}
	//FIN BUSCAR NOMBRE DE MONEDA POR ID DE PAIS

	public function get_nivel_empresarial($nivel_empresarial)
	{
		$stmt = $this->conn->prepare("SELECT nombre as nombre_nivel, minimo as minimo_nivel, maximo as maximo_nivel
	FROM tipo_escala_trabajadores
	WHERE id=:nivel_empresarial");
		$stmt->execute(array(":nivel_empresarial" => $nivel_empresarial));
		$editRow = $stmt->fetch(PDO::FETCH_ASSOC);
		return $editRow;
	}
	//FIN BUSCAR NOMBRE DE MONEDA POR ID DE PAIS



}
