<?php

require_once('../layouts/dbconexion_pdo.php');
define('METHOD', 'AES-256-CBC');
define('SECRET_KEY', 'SideComs*');
define('SECRET_IV', '202020');

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

	public static function encryption($string)
	{
		$output = FALSE;
		$key = hash('sha256', SECRET_KEY);
		$iv = substr(hash('sha256', SECRET_IV), 0, 16);
		$output = openssl_encrypt($string, METHOD, $key, 0, $iv);
		$output = base64_encode($output);
		return $output;
	}

	public static function decryption($string)
	{
		$key = hash('sha256', SECRET_KEY);
		$iv = substr(hash('sha256', SECRET_IV), 0, 16);
		$output = openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
		return $output;
	}

	public function get_countries()
	{
		try {
			$stmt = $this->conn->prepare("SELECT * FROM paises ORDER BY nombre ASC");
			$stmt->execute();
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $results;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}
	public function get_nivel()
	{
		try {
			$stmt = $this->conn->prepare("SELECT * FROM tipo_escala_trabajadores ");
			$stmt->execute();
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $results;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}
	public function get_acitvity()
	{
		try {
			$stmt = $this->conn->prepare("SELECT * FROM `tipo_sector_empresa` ORDER BY nombre ASC");
			$stmt->execute();
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $results;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

	public function get_products()
	{
		try {
			$stmt = $this->conn->prepare("SELECT * FROM `productos_servicios` ORDER BY nombre ASC");
			$stmt->execute();
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $results;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}
	public function get_sector()
	{
		try {
			$stmt = $this->conn->prepare("SELECT * FROM `tipo_sector`");
			$stmt->execute();
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $results;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}
	public function get_tipo_empresa()
	{
		try {
			$stmt = $this->conn->prepare("SELECT * FROM `tipo_empresa`");
			$stmt->execute();
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $results;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}
	public function get_tipo_sector_empresa()
	{
		try {
			$stmt = $this->conn->prepare("SELECT * FROM `tipo_sector_empresa`");
			$stmt->execute();
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $results;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}


	public function get_tipo_frecuencia_salarial()
	{
		try {
			$stmt = $this->conn->prepare("SELECT * FROM `tipo_frecuencia_salarial`");
			$stmt->execute();
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $results;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

	public function get_escala_administrativo()
	{
		try {
			$stmt = $this->conn->prepare("SELECT tipo_empresa, GROUP_CONCAT(CONCAT(grado, '  (', minimo, ' - ', maximo,')') SEPARATOR ',') AS descripcion 
					FROM tipo_escala_empresarial 
					WHERE categoria = 1 
					GROUP BY tipo_empresa 
					ORDER BY CAST(tipo_empresa AS UNSIGNED) ASC;
					");
			$stmt->execute();
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $results;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

	public function get_escala_planta()
	{
		try {
			$stmt = $this->conn->prepare("SELECT tipo_empresa, GROUP_CONCAT(CONCAT(grado, '  (', minimo, ' - ', maximo,')') ORDER BY grado ASC SEPARATOR ',') AS descripcion 
FROM tipo_escala_empresarial 
WHERE categoria = 2 
GROUP BY tipo_empresa 
ORDER BY tipo_empresa ASC;");
			$stmt->execute();
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $results;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

	public function doRegisterEmpresa(
		$nombre,
		$codigoTributario,
		$direccion,
		$idPais,
		$ciudad,
		$estado,
		$telefonos,
		$zipcode,
		$idTipoEmpresa,
		$idSector,
		$actividad,
		$productos_servicios,
		//$escala_administrativo,
		//$escala_planta,
		$nivel_empresarial,
		$volumen_ventas,
		$valor_activos,
		$moneda,
		$nombrerh,
		$puestorh,
		$emailrh,
		$telefonorh,
		$mision,
		$vision,
		$valores
	) {
		try {

			// Insertar los dtos en la tabla empresas
			$stmt = $this->conn->prepare(
				"INSERT INTO empresas (
        nombre, codigo_tributario, direccion, id_pais, ciudad, estado, 
        telefonos, zipcode, actividad, id_tipoempresa, id_sector,
         nivel_empresarial, productos_servicios, volumen_ventas, valor_activos, moneda, nombrerh, puestorh, emailrh, telefonorh, mision, vision, valores
    )
    VALUES (
        :nombre, :codigo_tributario, :direccion, :id_pais, :ciudad, :estado, 
        :telefonos, :zipcode, :actividad, :id_tipoempresa, :id_sector, 
        :nivel_empresarial, :productos_servicios, :volumen_ventas, :valor_activos,:moneda, :nombrerh, :puestorh, :emailrh, :telefonorh, :mision, :vision, :valores
    )"
			);

			$stmt->bindParam(':nombre', $nombre);
			$stmt->bindParam(':codigo_tributario', $codigoTributario);
			$stmt->bindParam(':direccion', $direccion);
			$stmt->bindParam(':id_pais', $idPais);
			$stmt->bindParam(':ciudad', $ciudad);
			$stmt->bindParam(':estado', $estado);
			$stmt->bindParam(':telefonos', $telefonos);
			$stmt->bindParam(':zipcode', $zipcode);
			$stmt->bindParam(':actividad', $actividad);
			$stmt->bindParam(':id_tipoempresa', $idTipoEmpresa);
			$stmt->bindParam(':id_sector', $idSector);
			//$stmt->bindParam(':escala_administrativo', $escala_administrativo);
			//$escala_planta_value = ($escala_planta == "") ? NULL : $escala_planta;
			//$stmt->bindParam(':escala_planta', $escala_planta_value);
			$stmt->bindParam(':nivel_empresarial', $nivel_empresarial);
			$stmt->bindParam(':productos_servicios', $productos_servicios);
			$stmt->bindParam(':volumen_ventas', $volumen_ventas);
			$stmt->bindParam(':valor_activos', $valor_activos);
			$stmt->bindParam(':moneda', $moneda);
			$stmt->bindParam(':nombrerh', $nombrerh);
			$stmt->bindParam(':puestorh', $puestorh);
			$stmt->bindParam(':emailrh', $emailrh);
			$stmt->bindParam(':telefonorh', $telefonorh);
			$stmt->bindParam(':mision', $mision);
			$stmt->bindParam(':vision', $vision);
			$stmt->bindParam(':valores', $valores);

			$stmt->execute();

			$idEmpresa = $this->conn->lastInsertId();

			$user = $_SESSION['user'];
			$stmt3 = $this->conn->prepare("UPDATE usuarios SET id_empresa = :id_empresa WHERE id = :id_usuario");
			$stmt3->bindParam(':id_empresa', $idEmpresa);
			$stmt3->bindParam(':id_usuario', $user['id']);
			$stmt3->execute();
			$_SESSION['user']['id_empresa'] = $idEmpresa;

			//Realizar un insert a la tabla tipo_sector_empresa si $actividad en tipo_sector_empresa.nombre 
			//no existe en la tabla tipo_sector_empresa
			$stmt2 = $this->conn->prepare("
				INSERT INTO tipo_sector_empresa (nombre, status, creacion)
				SELECT :actividad, :status, :creacion WHERE NOT EXISTS (SELECT * FROM tipo_sector_empresa WHERE nombre = :actividad)");
			$stmt2->bindParam(':actividad', $actividad);
			$stmt2->bindValue(':status', 1); // Establece un valor para la columna 'status'
			$stmt2->bindValue(':creacion', date("Y-m-d H:i:s", strtotime('now'))); // Establece un valor para la columna 'creacion'
			$stmt2->execute();

				//Realizar un insert a la tabla tipo_sector_empresa si $actividad en tipo_sector_empresa.nombre 
			//no existe en la tabla tipo_sector_empresa
			$stmt2 = $this->conn->prepare("
				INSERT INTO matriz_resultados (id_empresa,categoria,presupuesto_mensual, presupuesto_anual, ventas_mensual,ventas_anual,created_at,updated_at)
				 VALUES(:id_empresa,:categoria,:presupuesto_mensual,:presupuesto_anual,:ventas_mensual,:ventas_anual,:created_at,:updated_at) ");
			$stmt2->bindParam(':id_empresa', $idEmpresa);
			$stmt2->bindValue(':categoria', 1);
			$stmt2->bindValue(':presupuesto_mensual', 0); // Establece un valor para la columna 'status'
			$stmt2->bindValue(':presupuesto_anual', 0);
			$stmt2->bindValue(':ventas_mensual', 0);
			$stmt2->bindValue(':ventas_anual', 0);
			$stmt2->bindValue(':created_at', date("Y-m-d H:i:s", strtotime('now'))); // Establece un valor para la columna 'creacion'
			$stmt2->bindValue(':updated_at', date("Y-m-d H:i:s", strtotime('now')));
			$stmt2->execute();

			$stmt4 = $this->conn->prepare("
				INSERT INTO productos_servicios (nombre, status, creacion)
				SELECT :productos_servicios, :status, :creacion WHERE NOT EXISTS (SELECT * FROM productos_servicios WHERE nombre = :productos_servicios)");
			$stmt4->bindParam(':productos_servicios', $productos_servicios);
			$stmt4->bindValue(':status', 1); // Establece un valor para la columna 'status'
			$stmt4->bindValue(':creacion', date("Y-m-d H:i:s", strtotime('now'))); // Establece un valor para la columna 'creacion'
			$stmt4->execute();

			$stmt5 = $this->conn->prepare("
				INSERT INTO matriz_jerarquizacion (id_empresa, categoria, sueldomin, porcentaje_grados, porcentaje_pasos, asignacion, creacion, modificado)
				VALUES(:id_empresa, :categoria, :sueldomin, :porcentaje_grados, :porcentaje_pasos, :asignacion, :creacion, :modificado)");
			$stmt5->bindParam(':id_empresa', $idEmpresa);
			$stmt5->bindValue(':categoria', 1); // Establece un valor para la columna 'status'
			$stmt5->bindValue(':sueldomin', 0); // Establece un valor para la columna 'status'
			$stmt5->bindValue(':porcentaje_grados', 0); // Establece un valor para la columna 'status'
			$stmt5->bindValue(':porcentaje_pasos', 0); // Establece un valor para la columna 'status'
			$stmt5->bindValue(':asignacion', 2); // Establece un valor para la columna 'status'
			$stmt5->bindValue(':creacion', date("Y-m-d H:i:s", strtotime('now'))); // Establece un valor para la columna 'creacion'
			$stmt5->bindValue(':modificado', date("Y-m-d H:i:s", strtotime('now'))); // Establece un valor para la columna 'creacion'
			$stmt5->execute();


			return 2; // Registro exitoso

		} catch (PDOException $e) {
			throw new Exception('Error al crear el cargo: ' . $e->getMessage());

			return 0; // Error desconocido
		}
	}
}
