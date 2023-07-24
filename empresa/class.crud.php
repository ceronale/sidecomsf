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
	public function get_empresa($id)
	{
		try {
			$stmt = $this->conn->prepare("SELECT empresas.*, paises.moneda AS moneda_pais, paises.codigotelefonico AS codigo_telefonico
				FROM empresas
				INNER JOIN paises ON empresas.id_pais = paises.id
				WHERE empresas.id = :id_empresa");
			$stmt->bindParam(':id_empresa', $id, PDO::PARAM_INT);
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
	public function get_nivel()
	{
		try {
			$stmt = $this->conn->prepare("SELECT * FROM tipo_escala_trabajadores_copy ");
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
		$escala_administrativo,
		$escala_planta,
		$nivel_empresarial,
		$volumen_ventas,
		$valor_activos,
		$moneda,
		$nombrerh,
		$puestorh,
		$emailrh,
		$telefonorh
	) {

		try {
			$user = $_SESSION['user'];
			$id_empresa = $user['id_empresa'];

			// Insertar los dtos en la tabla empresas
			// Actualizar los datos en la tabla empresas
			$stmt = $this->conn->prepare(
				"UPDATE empresas SET
            nombre = :nombre,
            codigo_tributario = :codigo_tributario,
            direccion = :direccion,
            id_pais = :id_pais,
            ciudad = :ciudad,
            estado = :estado,
            telefonos = :telefonos,
            zipcode = :zipcode,
            actividad = :actividad,
            id_tipoempresa = :id_tipoempresa,
            id_sector = :id_sector,
            nivel_empresarial = :nivel_empresarial,
            productos_servicios = :productos_servicios,
            volumen_ventas = :volumen_ventas,
            valor_activos = :valor_activos,
            moneda = :moneda,
            nombrerh = :nombrerh,
            puestorh = :puestorh,
            emailrh = :emailrh,
            telefonorh = :telefonorh
            WHERE id = :id_empresa"
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

			$stmt->bindParam(':nivel_empresarial', $nivel_empresarial);
			$stmt->bindParam(':productos_servicios', $productos_servicios);
			$stmt->bindParam(':volumen_ventas', $volumen_ventas);
			$stmt->bindParam(':valor_activos', $valor_activos);
			$stmt->bindParam(':moneda', $moneda);
			$stmt->bindParam(':nombrerh', $nombrerh);
			$stmt->bindParam(':puestorh', $puestorh);
			$stmt->bindParam(':emailrh', $emailrh);
			$stmt->bindParam(':telefonorh', $telefonorh);
			$stmt->bindParam(':id_empresa', $id_empresa);

			$stmt->execute();


			//Realizar un insert a la tabla tipo_sector_empresa si $actividad en tipo_sector_empresa.nombre 
			//no existe en la tabla tipo_sector_empresa
			$stmt2 = $this->conn->prepare("
				INSERT INTO tipo_sector_empresa (nombre, status, creacion)
				SELECT :actividad, :status, :creacion WHERE NOT EXISTS (SELECT * FROM tipo_sector_empresa WHERE nombre = :actividad)");
			$stmt2->bindParam(':actividad', $actividad);
			$stmt2->bindValue(':status', 1); // Establece un valor para la columna 'status'
			$stmt2->bindValue(':creacion', date("Y-m-d H:i:s", strtotime('now'))); // Establece un valor para la columna 'creacion'
			$stmt2->execute();

			$stmt4 = $this->conn->prepare("
				INSERT INTO productos_servicios (nombre, status, creacion)
				SELECT :productos_servicios, :status, :creacion WHERE NOT EXISTS (SELECT * FROM productos_servicios WHERE nombre = :productos_servicios)");
			$stmt4->bindParam(':productos_servicios', $productos_servicios);
			$stmt4->bindValue(':status', 1); // Establece un valor para la columna 'status'
			$stmt4->bindValue(':creacion', date("Y-m-d H:i:s", strtotime('now'))); // Establece un valor para la columna 'creacion'
			$stmt4->execute();



			return 2; // Registro exitoso

		} catch (PDOException $e) {
			throw new Exception('Error al crear el cargo: ' . $e->getMessage());

			return 0; // Error desconocido
		}
	}
}