<?php

require_once('../layouts/dbconexion_pdo.php');
define('METHOD', 'AES-256-CBC');
define('SECRET_KEY', 'SideComs*');
define('SECRET_IV', '202020');

class crud
{

	public $conn;

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
	public function dataview_usuarios()
	{
		$user = $_SESSION['user'];
		$query = "SELECT * FROM usuarios
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
	//FIN FUNCION PARA MOSTRAR LISTADO DE USUARIOS  

	//FUNCION PARA CREAR UN USUARIO EN LA BD
	public function crear_usuario()
	{
		try {
			$email = isset($_POST['email']) ? $_POST['email'] : "";

			// Verificar si el nombre de usuario ya existe
			$stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE email=:email");
			$stmt->execute(array(':email' => $email));
			$userRow = $stmt->fetch(PDO::FETCH_ASSOC);

			if ($stmt->rowCount() == 1) {
				// Nombre de usuario ya existe
				return 1;
			} else {
				$user = $_SESSION['user'];
				$id = isset($_POST['id']) ? $_POST['id'] : "";
				$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : "";
				$apellido = isset($_POST['apellido']) ? $_POST['apellido'] : "";
				$cargo = isset($_POST['cargo']) ? $_POST['cargo'] : "";
				$status = isset($_POST['status']) ? $_POST['status'] : "";

				$password = isset($_POST['password']) ? $_POST['password'] : "";
				$password = self::encryption($password);
				$created_at = date("Y-m-d H:i:s", strtotime('now'));
				$updated_at = date("Y-m-d H:i:s", strtotime('now'));
				$id_parent = 2;
				
				$stmt = $this->conn->prepare("INSERT INTO usuarios 
				(id_empresa,nombre, apellido, idcargo, email, status, creacion, modificado, password, id_parent)
				VALUES
				(:id_empresa,:nombre, :apellido, :idcargo, :email, :status, :created_at, :updated_at, :password, :id_parent)");
				$stmt->bindParam(":id_empresa", $user['id_empresa']);
				$stmt->bindParam(":nombre", $nombre);
				$stmt->bindParam(":apellido", $apellido);
				$stmt->bindParam(":idcargo", $cargo);
				$stmt->bindParam(":email", $email);
				$stmt->bindParam(":status", $status);
				$stmt->bindParam(":created_at", $created_at);
				$stmt->bindParam(":updated_at", $updated_at);
				$stmt->bindParam(":password", $password);
				$stmt->bindParam(":id_parent", $id_parent);
				$stmt->execute();

				$id_usuario = $this->conn->lastInsertId();

				$stmt = $this->conn->prepare("INSERT INTO permisos 
				(id_usuario,created_at, updated_at)
				VALUES
				(:id_usuario,:created_at,:updated_at)");
				$stmt->bindParam(":created_at", $created_at);
				$stmt->bindParam(":updated_at", $updated_at);
				$stmt->bindParam(":id_usuario", $id_usuario);
				$stmt->execute();

				return $id_usuario;
			}
		} catch (PDOException $e) {
			throw new Exception('Error al crear el usuario: ' . $e->getMessage());
			return 0;
		}
	}

	//FIN FUNCION PARA CREAR UN USUARIOS EN LA BD

	//FUNCION PARA EDITAR UN USUARIO EN LA BD
	public function editar_usuario()
	{
		try {

			$lastemail = isset($_POST['lastemail']) ? $_POST['lastemail'] : "";
			$email = isset($_POST['email']) ? $_POST['email'] : "";

			if ($lastemail != $email) {
				// Verificar si el nombre de usuario ya existe
				$stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE email=:email");
				$stmt->execute(array(':email' => $email));
				if ($stmt->rowCount() == 1) {
					// Nombre de usuario ya existe
					return 1;
				}
			}

			$id = isset($_POST['id']) ? $_POST['id'] : "";
			$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : "";
			$apellido = isset($_POST['apellido']) ? $_POST['apellido'] : "";
			$cargo = isset($_POST['cargo']) ? $_POST['cargo'] : "";
			$status = isset($_POST['status']) ? $_POST['status'] : "";
			$password = isset($_POST['password']) ? $_POST['password'] : "";
			$pass2 = $this->encryption($password);
			$updated_at = date("Y-m-d H:i:s", strtotime('now'));

			$stmt = $this->conn->prepare("UPDATE usuarios SET 
				nombre=:nombre,
				apellido=:apellido,
				idcargo=:idcargo,
				email=:email,
				status=:status,
				password=:password,
				modificado=:updated_at
				WHERE id=:id");


			$stmt->bindParam(":nombre", $nombre);
			$stmt->bindParam(":apellido", $apellido);
			$stmt->bindParam(":idcargo", $cargo);
			$stmt->bindParam(":email", $email);
			$stmt->bindParam(":status", $status);
			$stmt->bindParam(":password", $pass2);
			$stmt->bindParam(":updated_at", $updated_at);
			$stmt->bindParam(":id", $id);
			$stmt->execute();

			return 2;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return 0;
		}
	}

	//FIN FUNCION PARA EDITAR UN USUARIO EN LA BD

	//FUNCION PARA ELIMINAR UN USUARIO DE LA BD 
	public function eliminar_usuario($id)
	{

		$stmt = $this->conn->prepare("DELETE FROM usuarios WHERE id=:id");
		$stmt->bindparam(":id", $id);
		$stmt->execute();

		return true;
	}
	//FIN FUNCION PARA ELIMINAR UN USUARIO DE LA BD 
	public function get_cargos()
	{
		try {
			$user = $_SESSION['user'];
			$stmt = $this->conn->prepare("SELECT * FROM cargos WHERE id_empresa = ". $user['id_empresa']);
			$stmt->execute();
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $results;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}



	public function permisos()
		{
		$value2 = "";
		$query = "SELECT DISTINCT COLUMN_NAME as columna
		FROM INFORMATION_SCHEMA.COLUMNS
		WHERE TABLE_NAME = 'permisos' and COLUMN_NAME not in ('id_seccion_permiso', 'usuario_permiso', 'id_permisos', 'id_usuario', 'created_at', 'updated_at',
		'permisos',
		'seccion_usuarios',
		'crear_cliente',
		'crear_empleado',
		'seccion_inventario',
		'inventario_global',
		'es_global',
		'productos_global',
		'almacenes',
		'manejar_cliente',
		'mensajeria_global',
		'vehiculos',
		'conductores',
		'gps',
		'envios',
		'es_cliente',
		'inventario_cliente',
		'productos_cliente',
		'mensajeria_cliente',
		'presupuestos',
		'clientes',
		'productos',
		'usuarios',
		'id_permiso',
		'p_setup',
		'notas_entregas',
		'seccion_productos',
		'tipos',
		'marcas')";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		if($stmt->rowCount()>0)
		{
			?>
			<div class="row">
				<?php
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{
				foreach($row as $value){							
									
	?>
		<div class="col-md-6" style="text-align: left !important;">
				<div class="form-group">
				<input class="form-check-input" type="hidden" id="<?php echo $value ?>" name="<?php echo $value ?>" value= "0" >
					<input class="form-check-input" type="checkbox" id="<?php echo $value ?>" name="<?php echo $value ?>">
					<label class="form-check-label" for="<?php $value ?>">
					<?php if($value2 !==""){
					echo $value2;
					$value2 ="";
					}
					else
					{ ?>
					<?php $texto = ucwords(strtolower(str_replace("_", " ", $value))); 
						print ltrim($texto, 'P');
					} ?>
					</label>
				</div>  
		</div>  
	
				<?php
				} ?>
	
				<?php
			}?>
	</div>
	<br>
		<?php
			}
}


//FIN FUNCION PARA GUARDAR PERMISOS
public function guardar_permisos($id_usuario, $filtro) 
		{
			$updated_at = date("Y-m-d H:i:s", strtotime('now'));
			$stmt=$this->conn->prepare("UPDATE permisos SET 
				$filtro, 
				updated_at=:updated_at
				WHERE id_usuario=:id_usuario");
            $stmt->bindparam(":updated_at",$updated_at);
			$stmt->bindparam(":id_usuario",$id_usuario);
			$stmt->execute();
			return true;		
			
		}
//FIN FUNCION PARA GUARDAR PERMISOS	
	


}
