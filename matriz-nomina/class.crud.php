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
    public function dataview_nomina($categoria)
    {
		$user = $_SESSION['user'];
		$query = "SELECT mn.id as id_nomina,
		c.grado as grado,
		c.puntaje as mnpuntaje,
		c.nombre as nombrecargo,
		mn.cargocritico as critico,
		mn.cargosupervisor as supervisor,
		mn.modelo_trabajo as modelotrabajo,
		mn.porcentaje_remoto as porcentajeremoto,
		mn.porcentaje_presencial as porcentajepresencial,
		d.nombre as nombredepartamento,
		mn.nombre as nombretrabajador,
		mn.documento as mndocumento,
		mn.genero as mngenero,
		mn.fecha_ingreso as fechaingreso,
		mn.sueldo_base as sueldobase,
		mn.sueldomensual as sueldo_mensual,
		mn.paqueteanual as paquete_anual,
		mn.factor as factormeses,
		mn.montodivisa as monto_divisa,
		d.categoria as categoriadepartamento,
		mn.id_departamento as iddepartamento,
		mn.id_cargo as idcargo,
		c.descripcion as funcioncargo,
		mn.id_tipodivisa as idtipodivisa
		FROM matriz_nomina mn
		INNER JOIN cargos c ON mn.id_cargo = c.id
		INNER JOIN departamentos d ON mn.id_departamento = d.id
		WHERE mn.id_empresa = ". $user['id_empresa'] . "
		AND c.categoria = " .$categoria . "
		ORDER BY c.grado";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
		if($stmt->rowCount()>0)
        {
			$data = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC))
                {
					$data[] = $row;

                } 
				return $data;
        }
    }
    //FIN FUNCION PARA MOSTRAR LISTADO DE DEPARTAMENTOS  


	//FUNCION PARA MOSTRAR LISTADO DE DEPARTAMENTOS
    public function dataview_escalas($categoria)
    {
		$user = $_SESSION['user'];
		$id_escala = "";
		$stmt2 = $this->conn->prepare("SELECT * FROM empresas WHERE id=:id_empresa");
		$stmt2->execute(array(':id_empresa' => $user['id_empresa']));
		$userRow = $stmt2->fetch(PDO::FETCH_ASSOC);

		if ($stmt2->rowCount() == 1) {

		
			if($categoria == 1)
			{
				$id_escala = $userRow['id_escala_administrativo'];
			}
			if($categoria == 2)
			{
				$id_escala = $userRow['id_escala_planta'];
			}

		$query = "SELECT grado, minimo, maximo FROM tipo_escala_empresarial 
		WHERE categoria = ". $categoria. "
		AND tipo_empresa = " . $id_escala;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

		if($stmt->rowCount()>0)
        {
			$data = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC))
                {
					$data[] = $row;

                } 
				return $data;
        }
	}
    }
    //FIN FUNCION PARA MOSTRAR LISTADO DE DEPARTAMENTOS  

	//FUNCION PARA MOSTRAR LISTADO DE DEPARTAMENTOS EN SELECT
    public function dataview_departamentos($id_categoria)
    {
		$user = $_SESSION['user'];
		$query = "SELECT id, nombre FROM departamentos 
		WHERE categoria = ". $id_categoria. "
		AND id_empresa = " . $user['id_empresa'];
		
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        if($stmt->rowCount()>0)
        {
			$data = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC))
                {
					$data[] = $row;

                } 
				return $data;
        }
    }
    //FIN FUNCION PARA MOSTRAR LISTADO DE DEPARTAMENTOS EN SELECT

	//FUNCION PARA MOSTRAR LISTADO DE DEPARTAMENTOS EN SELECT
    public function dataview_cargos($id_departamento)
    {
		$query = "SELECT id, nombre FROM cargos WHERE id_departamento = ". $id_departamento;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        if($stmt->rowCount()>0)
        {
			$data = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC))
                {
					$data[] = $row;

                } 
				return $data;
        }
    }
    //FIN FUNCION PARA MOSTRAR LISTADO DE DEPARTAMENTOS EN SELECT


	//BUSCAR CANTIDAD MAXIMA DE UN PRODUCTO EN UNA DISTRIBUCION
	public function get_datos_cargo($id_cargo)
	{
		$stmt = $this->conn->prepare("SELECT descripcion, 
		grado, 
		puntaje 
		FROM cargos 
		WHERE id =:id_cargo");
		$stmt->bindparam(":id_cargo",$id_cargo);
		$stmt->execute();
		$editRow=$stmt->fetch(PDO::FETCH_ASSOC);
		return $editRow;
	}
	//FIN BUSCAR CANTIDAD MAXIMA DE UN PRODUCTO EN UNA DISTRIBUCION

	//FUNCION PARA CREAR UN DEPARTAMENTO EN LA BD
	public function crear_nomina()
	{
		try
		{
			$user = $_SESSION['user'];
			$id_empresa = $user['id_empresa'];
			$id_departamento = (isset($_POST['id_departamento']))?$_POST['id_departamento']:""; 
			$id_cargo = (isset($_POST['id_cargo']))?$_POST['id_cargo']:""; 

			if ($_POST['cargocritico']!=null)
			{
				$cargocritico = 1;
			}
			else
			{
				$cargocritico = 0;
			}
			if ($_POST['cargosupervisor']!=null)
			{
 				$cargosupervisor = 1;
			}
			else
			{
				$cargosupervisor = 0;
			}
			$modelo_trabajo = (isset($_POST['modelo_trabajo']))?$_POST['modelo_trabajo']:"";
			$porcentaje_remoto = (isset($_POST['porcentaje_remoto']))?$_POST['porcentaje_remoto']:"";
			$porcentaje_presencial = (isset($_POST['porcentaje_presencial']))?$_POST['porcentaje_presencial']:"";
			$nombre = (isset($_POST['nombre']))?$_POST['nombre']:"";  
			$documento = (isset($_POST['documento']))?$_POST['documento']:"";  
			$genero = (isset($_POST['genero']))?$_POST['genero']:"";
			$fecha_ingreso = (isset($_POST['fecha_ingreso']))?$_POST['fecha_ingreso']:"";  
			$sueldo_base = (isset($_POST['sueldo_base_mensual']))?$_POST['sueldo_base_mensual']:"";  
			$sueldomensual = (isset($_POST['total_ingreso_mensual']))?$_POST['total_ingreso_mensual']:""; 
			$paqueteanual =  (isset($_POST['total_paquete_anual']))?$_POST['total_paquete_anual']:""; 
			$factor = (isset($_POST['factor_meses']))?$_POST['factor_meses']:""; 

			if ($_POST['pagoDivisas']!=null)
			{
				$id_tipodivisa = (isset($_POST['id_tipodivisa']))?$_POST['id_tipodivisa']:""; 
				$montodivisa = (isset($_POST['montodivisa']))?$_POST['montodivisa']:""; 
			}
			else
			{
				$id_tipodivisa = 0; 
				$montodivisa = 0; 
			}			
			$status = "1";

            $created_at= date("Y-m-d H:i:s", strtotime('now'));
            $updated_at = date("Y-m-d H:i:s", strtotime('now'));  

			$stmt = $this->conn->prepare("INSERT INTO matriz_nomina(id_empresa,id_departamento,id_cargo,cargocritico,
			cargosupervisor,modelo_trabajo,porcentaje_remoto,porcentaje_presencial,nombre,documento,genero,fecha_ingreso,sueldo_base,sueldomensual,paqueteanual,
			factor,id_tipodivisa,montodivisa,status,creacion,modificado) 
				VALUES(:id_empresa,:id_departamento,:id_cargo,:cargocritico,:cargosupervisor,:modelo_trabajo,
				:porcentaje_remoto,:porcentaje_presencial,:nombre,:documento,:genero,:fecha_ingreso,:sueldo_base,
				:sueldomensual,:paqueteanual,:factor,:id_tipodivisa,:montodivisa,:status,:creacion,:modificado)");
			$stmt->bindparam(":id_empresa",$id_empresa);
			$stmt->bindparam(":id_departamento",$id_departamento);
			$stmt->bindparam(":id_cargo",$id_cargo);
			$stmt->bindparam(":cargocritico",$cargocritico);
			$stmt->bindparam(":cargosupervisor",$cargosupervisor);
			$stmt->bindparam(":modelo_trabajo",$modelo_trabajo);
			$stmt->bindparam(":porcentaje_remoto",$porcentaje_remoto);
			$stmt->bindparam(":porcentaje_presencial",$porcentaje_presencial);
			$stmt->bindparam(":nombre",$nombre);
			$stmt->bindparam(":documento",$documento);
			$stmt->bindparam(":genero",$genero);
			$stmt->bindparam(":fecha_ingreso",$fecha_ingreso);
			$stmt->bindparam(":sueldo_base",$sueldo_base);
			$stmt->bindparam(":sueldomensual",$sueldomensual);
			$stmt->bindparam(":paqueteanual",$paqueteanual);
			$stmt->bindparam(":factor",$factor);
			$stmt->bindparam(":id_tipodivisa",$id_tipodivisa);
			$stmt->bindparam(":montodivisa",$montodivisa);
			$stmt->bindparam(":status",$status);
			$stmt->bindparam(":creacion",$created_at);
			$stmt->bindparam(":modificado",$updated_at);

			$stmt->execute();

			return true;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();	
			return false;
		}
	}
	//FIN FUNCION PARA CREAR UN DEPARTAMENTOS EN LA BD

	//FUNCION PARA EDITAR UN DEPARTAMENTO EN LA BD
    public function editar_nomina()
	{
		try
		{
			$id_nomina = (isset($_POST['id_nomina']))?$_POST['id_nomina']:""; 
			$id_departamento = (isset($_POST['id_departamento']))?$_POST['id_departamento']:""; 
			$id_cargo = (isset($_POST['id_cargo']))?$_POST['id_cargo']:""; 

			
			if ($_POST['cargocritico']!=null)
			{
				$cargocritico = 1;
			}
			else
			{
				$cargocritico = 0;
			}
			if ($_POST['cargosupervisor']!=null)
			{
 				$cargosupervisor = 1;
			}
			else
			{
				$cargosupervisor = 0;
			}

			$modelo_trabajo = (isset($_POST['modelo_trabajo']))?$_POST['modelo_trabajo']:""; 
			$porcentaje_remoto = (isset($_POST['porcentaje_remoto']))?$_POST['porcentaje_remoto']:"";
			$porcentaje_presencial = (isset($_POST['porcentaje_presencial']))?$_POST['porcentaje_presencial']:"";
			$nombre = (isset($_POST['nombre']))?$_POST['nombre']:"";  
			$documento = (isset($_POST['documento']))?$_POST['documento']:""; 
			$genero = (isset($_POST['genero']))?$_POST['genero']:"";   
			$fecha_ingreso = (isset($_POST['fecha_ingreso']))?$_POST['fecha_ingreso']:"";  
			$sueldo_base = (isset($_POST['sueldo_base_mensual']))?$_POST['sueldo_base_mensual']:"";  
			$sueldomensual = (isset($_POST['total_ingreso_mensual']))?$_POST['total_ingreso_mensual']:""; 
			$paqueteanual =  (isset($_POST['total_paquete_anual']))?$_POST['total_paquete_anual']:""; 
			$factor = (isset($_POST['factor_meses']))?$_POST['factor_meses']:""; 

			if ($_POST['pagoDivisas']!=null)
			{
				$id_tipodivisa = (isset($_POST['id_tipodivisa']))?$_POST['id_tipodivisa']:""; 
				$montodivisa = (isset($_POST['montodivisa']))?$_POST['montodivisa']:""; 
			}
			else
			{
				$id_tipodivisa = 0; 
				$montodivisa = 0; 
			}			
		
            $updated_at = date("Y-m-d H:i:s", strtotime('now'));  

			$stmt=$this->conn->prepare("UPDATE matriz_nomina SET 
				id_departamento=:id_departamento,
				id_cargo=:id_cargo, 
				cargocritico=:cargocritico,  
				cargosupervisor=:cargosupervisor, 
				modelo_trabajo=:modelo_trabajo, 
				porcentaje_remoto=:porcentaje_remoto, 
				porcentaje_presencial=:porcentaje_presencial, 
				nombre=:nombre,
				documento=:documento, 
				genero=:genero, 
				fecha_ingreso=:fecha_ingreso, 
				sueldo_base=:sueldo_base,
				sueldomensual=:sueldomensual,
				paqueteanual=:paqueteanual, 
				factor=:factor,  
				id_tipodivisa=:id_tipodivisa, 
				montodivisa=:montodivisa, 
				modificado=:updated_at
				WHERE id=:id_nomina");
			$stmt->bindparam(":id_departamento",$id_departamento);
			$stmt->bindparam(":id_cargo",$id_cargo);
			$stmt->bindparam(":cargocritico",$cargocritico);
			$stmt->bindparam(":cargosupervisor",$cargosupervisor);
			$stmt->bindparam(":modelo_trabajo",$modelo_trabajo);
			$stmt->bindparam(":porcentaje_remoto",$porcentaje_remoto);
			$stmt->bindparam(":porcentaje_presencial",$porcentaje_presencial);
			$stmt->bindparam(":nombre",$nombre);
			$stmt->bindparam(":documento",$documento);
			$stmt->bindparam(":genero",$genero);
			$stmt->bindparam(":fecha_ingreso",$fecha_ingreso);
			$stmt->bindparam(":sueldo_base",$sueldo_base);
			$stmt->bindparam(":sueldomensual",$sueldomensual);
			$stmt->bindparam(":paqueteanual",$paqueteanual);
			$stmt->bindparam(":factor",$factor);
			$stmt->bindparam(":id_tipodivisa",$id_tipodivisa);
			$stmt->bindparam(":montodivisa",$montodivisa);
            $stmt->bindparam(":updated_at",$updated_at);
			$stmt->bindparam(":id_nomina",$id_nomina);
			$stmt->execute();

			return true;	
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();	
			return false;
		}
	}
	//FIN FUNCION PARA EDITAR UN DEPARTAMENTO EN LA BD

	//FUNCION PARA ELIMINAR UN DEPARTAMENTO DE LA BD 
    public function eliminar_nomina($id)
	{  
  	
            $stmt = $this->conn->prepare("DELETE FROM matriz_nomina WHERE id=:id");
			$stmt->bindparam(":id",$id);
			$stmt->execute();

			return true;
	}
	//FIN FUNCION PARA ELIMINAR UN DEPARTAMENTO DE LA BD 


	//FUNCION PARA MOSTRAR LISTADO DE DEPARTAMENTOS EN SELECT
    public function mostrar_grafico($categoria, $asignacion)
    {
		/* $query = "SELECT c.puntaje as puntos, sueldomensual AS sueldo FROM matriz_nomina mn
		INNER JOIN cargos c ON mn.id_cargo = c.id
		WHERE c.categoria=".$categoria." ORDER BY puntaje"; */

		$query = "SELECT c.puntaje as puntos, sueldomensual AS sueldo, 
		(SELECT MIN(c.puntaje) FROM matriz_nomina mn
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE c.categoria=".$categoria." ) as puntajeminimo,
		(SELECT MAX(c.puntaje) FROM matriz_nomina mn
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE c.categoria=".$categoria." ) as puntajemaximo,
		(SELECT MIN(sueldomensual) FROM matriz_nomina mn
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE c.categoria=".$categoria." ) as sueldominimo,
		(SELECT MAX(sueldomensual) FROM matriz_nomina mn
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE c.categoria=".$categoria." ) as sueldomaximo
			FROM matriz_nomina mn
			INNER JOIN cargos c ON mn.id_cargo = c.id
			WHERE c.categoria=".$categoria." ORDER BY puntaje";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        if($stmt->rowCount()>0)
        {
			$data = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC))
                {
					$data[] = $row;

                } 
				return $data;
        }
    }
    //FIN FUNCION PARA MOSTRAR LISTADO DE DEPARTAMENTOS EN SELECT

	//FUNCION PARA MOSTRAR LISTADO DE DEPARTAMENTOS EN SELECT
    public function mostrar_grafico_adm($categoria, $asignacion)
    {

		$user = $_SESSION['user'];

		if($asignacion == 1)
		{
			$campo = "mn.sueldo_base";
		}
		if($asignacion == 2)
		{
			$campo = "mn.sueldomensual";
		}
		if($asignacion == 3)
		{
			$campo = "mn.paqueteanual";
		}

		$stmt2 = $this->conn->prepare("SELECT * FROM empresas WHERE id=:id_empresa");
		$stmt2->execute(array(':id_empresa' => $user['id_empresa']));
		$userRow = $stmt2->fetch(PDO::FETCH_ASSOC);

		if ($stmt2->rowCount() == 1) {
			$id_escala_administrativo = $userRow['id_escala_administrativo'];
		
			$query = "SELECT c.puntaje as puntajenomina, ".$campo." as sueldonomina, mn.nombre as nombres,
				c.nombre as nombrecargo, e.id_escala_administrativo as tipoempresa,
				(SELECT SUM(c.puntaje) FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'I' AND c.categoria = 1) as puntajegradoI,
				
				(SELECT count(*) FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'I' AND c.categoria = 1) as conteogradoI,
				
				(SELECT SUM(".$campo.") FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'I' AND c.categoria = 1) as sueldogradoI";

			if($id_escala_administrativo >= '2')
			{
				$query = $query . ",	
				(SELECT SUM(c.puntaje) FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'II' AND c.categoria = 1) as puntajegradoII,
				
				(SELECT count(*) FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'II' AND c.categoria = 1) as conteogradoII,
				
				(SELECT SUM(".$campo.") FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'II' AND c.categoria = 1) as sueldogradoII";
			}
			
			if($id_escala_administrativo >= '3')
			{

				$query = $query .",
				(SELECT SUM(c.puntaje) FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'III' AND c.categoria = 1) as puntajegradoIII,
				
				(SELECT count(*) FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'III' AND c.categoria = 1) as conteogradoIII,
				
				(SELECT SUM(".$campo.") FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'III' AND c.categoria = 1) as sueldogradoIII";
				
			}
			if($id_escala_administrativo >= '4')
			{

				$query = $query .",
				(SELECT SUM(c.puntaje) FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'IV' AND c.categoria = 1) as puntajegradoIV,
				
				(SELECT count(*) FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'IV' AND c.categoria = 1) as conteogradoIV,
				
				(SELECT SUM(".$campo.") FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'IV' AND c.categoria = 1) as sueldogradoIV";
				
			}
			if($id_escala_administrativo >= '5')
			{
				
				$query = $query .",
				(SELECT SUM(c.puntaje) FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'V' AND c.categoria = 1) as puntajegradoV,
				
				(SELECT count(*) FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'V' AND c.categoria = 1) as conteogradoV,
				
				(SELECT SUM(".$campo.") FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'V' AND c.categoria = 1) as sueldogradoV";

			}
			if($id_escala_administrativo >= '6')
			{

				$query = $query .",
				(SELECT SUM(c.puntaje) FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'VI' AND c.categoria = 1) as puntajegradoVI,
				
				(SELECT count(*) FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'VI' AND c.categoria = 1) as conteogradoVI,
				
				(SELECT SUM(".$campo.") FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'VI' AND c.categoria = 1) as sueldogradoVI";
				
			}
			if($id_escala_administrativo >= '7')
			{
				
				$query = $query .",
				(SELECT SUM(c.puntaje) FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'VII' AND c.categoria = 1) as puntajegradoVII,
				
				(SELECT count(*) FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'VII' AND c.categoria = 1) as conteogradoVII,
				
				(SELECT SUM(".$campo.") FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'VII' AND c.categoria = 1) as sueldogradoVII";

			}
			if($id_escala_administrativo >= '8')
			{
				
				$query = $query .",
				(SELECT SUM(c.puntaje) FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'VIII' AND c.categoria = 1) as puntajegradoVIII,
				
				(SELECT count(*) FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'VIII' AND c.categoria = 1) as conteogradoVIII,
				
				(SELECT SUM(".$campo.") FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'VIII' AND c.categoria = 1) as sueldogradoVIII";


			}
			if($id_escala_administrativo >= '9')
			{
				
				$query = $query .",
				(SELECT SUM(c.puntaje) FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'IX' AND c.categoria = 1) as puntajegradoIX,
				
				(SELECT count(*) FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'IX' AND c.categoria = 1) as conteogradoIX,
				
				(SELECT SUM(".$campo.") FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'IX' AND c.categoria = 1) as sueldogradoIX";

			}
			if($id_escala_administrativo >= '10')
			{
				
				$query = $query . ",
				(SELECT SUM(c.puntaje) FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'X' AND c.categoria = 1) as puntajegradoX,
				
				(SELECT count(*) FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'X' AND c.categoria = 1) as conteogradoX,
				
				(SELECT SUM(".$campo.") FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'X' AND c.categoria = 1) as sueldogradoX";

			}
			if($id_escala_administrativo >= '11')
			{
				
				$query = $query . ",
				(SELECT SUM(c.puntaje) FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'XI' AND c.categoria = 1) as puntajegradoXI,
				
				(SELECT count(*) FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'XI' AND c.categoria = 1) as conteogradoXI,
				
				(SELECT SUM(".$campo.") FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'XI' AND c.categoria = 1) as sueldogradoXI";

			}
			if($id_escala_administrativo >= '12')
			{
				
				$query = $query .",
				(SELECT SUM(c.puntaje) FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'XII' AND c.categoria = 1) as puntajegradoXII,
				
				(SELECT count(*) FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'XII' AND c.categoria = 1) as conteogradoXII,
				
				(SELECT SUM(".$campo.") FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'XII' AND c.categoria = 1) as sueldogradoXII";


			}
			if($id_escala_administrativo >= '13')
			{
				
				$query = $query .",
				(SELECT SUM(c.puntaje) FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'XIII' AND c.categoria = 1) as puntajegradoXIII,
				
				(SELECT count(*) FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'XIII' AND c.categoria = 1) as conteogradoXIII,
				
				(SELECT SUM(".$campo.") FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'XIII' AND c.categoria = 1) as sueldogradoXIII";

			}
			if($id_escala_administrativo >= '14')
			{
				
				$query = $query . ",
				(SELECT SUM(c.puntaje) FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'XIV' AND c.categoria = 1) as puntajegradoXIV,
				
				(SELECT count(*) FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'XIV' AND c.categoria = 1) as conteogradoXIV,
				
				(SELECT SUM(".$campo.") FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'XIV' AND c.categoria = 1) as sueldogradoXIV";


			}
			if($id_escala_administrativo >= '15')
			{
			$query = $query . ",
			(SELECT SUM(c.puntaje) FROM matriz_nomina mn 
			INNER JOIN cargos c ON mn.id_cargo = c.id
			WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'XV' AND c.categoria = 1) as puntajegradoXV,

			(SELECT count(*) FROM matriz_nomina mn 
			INNER JOIN cargos c ON mn.id_cargo = c.id
			WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'XV' AND c.categoria = 1) as conteogradoXV,

			(SELECT SUM(".$campo.") FROM matriz_nomina mn 
			INNER JOIN cargos c ON mn.id_cargo = c.id
			WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'XV' AND c.categoria = 1) as sueldogradoXV";
			}

			$query = $query . ", 
			(SELECT MAX(".$campo.") FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']."
				AND c.categoria = 1) as maximosueldo

			FROM matriz_nomina mn 
			INNER JOIN cargos c ON mn.id_cargo = c.id
			INNER JOIN empresas e ON c.id_empresa = e.id 
			WHERE mn.id_empresa = ".$user['id_empresa']."
			AND c.categoria = 1";

			

			$stmt = $this->conn->prepare($query);
			$stmt->execute();
			
			if($stmt->rowCount()>0)
			{
				$data = array();
				while($row=$stmt->fetch(PDO::FETCH_ASSOC))
					{
						$data[] = $row;
	
					} 
					return $data;
			}

		}

       
    }
    //FIN FUNCION PARA MOSTRAR LISTADO DE DEPARTAMENTOS EN SELECT



	//FUNCION PARA MOSTRAR LISTADO DE DEPARTAMENTOS EN SELECT
    public function mostrar_grafico_taller($categoria, $asignacion)
    {

		$user = $_SESSION['user'];

		if($asignacion == 1)
		{
			$campo = "mn.sueldo_base";
		}
		if($asignacion == 2)
		{
			$campo = "mn.sueldomensual";
		}
		if($asignacion == 3)
		{
			$campo = "mn.paqueteanual";
		}

		$stmt2 = $this->conn->prepare("SELECT * FROM empresas WHERE id=:id_empresa");
		$stmt2->execute(array(':id_empresa' => $user['id_empresa']));
		$userRow = $stmt2->fetch(PDO::FETCH_ASSOC);

		if ($stmt2->rowCount() == 1) {
			$id_escala_planta = $userRow['id_escala_planta'];


			$query = "SELECT c.puntaje as puntajenomina, ".$campo." as sueldonomina, mn.nombre as nombres,
				c.nombre as nombrecargo, e.id_escala_planta as tipoempresa,
				(SELECT SUM(c.puntaje) FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'I' AND c.categoria = 2) as puntajegradoI,
				
				(SELECT count(*) FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'I' AND c.categoria = 2) as conteogradoI,
				
				(SELECT SUM(".$campo.") FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'I' AND c.categoria = 2) as sueldogradoI";
		
			
			if($id_escala_planta >= '2')
			{
				$query = $query .",
				(SELECT SUM(c.puntaje) FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'II' AND c.categoria = 2) as puntajegradoII,
				
				(SELECT count(*) FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'II' AND c.categoria = 2) as conteogradoII,
				
				(SELECT SUM(".$campo.") FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'II' AND c.categoria = 2) as sueldogradoII";
			}
			
			if($id_escala_planta >= '3')
			{

				$query = $query .",
				
				(SELECT SUM(c.puntaje) FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'III' AND c.categoria = 2) as puntajegradoIII,
				
				(SELECT count(*) FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'III' AND c.categoria = 2) as conteogradoIII,
				
				(SELECT SUM(".$campo.") FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'III' AND c.categoria = 2) as sueldogradoIII";
				
			}
			if($id_escala_planta >= '4')
			{

				$query = $query . ",
				(SELECT SUM(c.puntaje) FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'IV' AND c.categoria = 2) as puntajegradoIV,
				
				(SELECT count(*) FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'IV' AND c.categoria = 2) as conteogradoIV,
				
				(SELECT SUM(".$campo.") FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'IV' AND c.categoria = 2) as sueldogradoIV";
				
			}
			if($id_escala_planta >= '5')
			{
				
				$query = $query .",
				(SELECT SUM(c.puntaje) FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'V' AND c.categoria = 2) as puntajegradoV,
				
				(SELECT count(*) FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'V' AND c.categoria = 2) as conteogradoV,
				
				(SELECT SUM(".$campo.") FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'V' AND c.categoria = 2) as sueldogradoV";

			}
			if($id_escala_planta >= '6')
			{

				$query = $query .",
				(SELECT SUM(c.puntaje) FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'VI' AND c.categoria = 2) as puntajegradoVI,
				
				(SELECT count(*) FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'VI' AND c.categoria = 2) as conteogradoVI,
				
				(SELECT SUM(".$campo.") FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'VI' AND c.categoria = 2) as sueldogradoVI";
				
			}
			if($id_escala_planta >= '7')
			{
				
				$query = $query .",
				(SELECT SUM(c.puntaje) FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'VII' AND c.categoria = 2) as puntajegradoVII,
				
				(SELECT count(*) FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'VII' AND c.categoria = 2) as conteogradoVII,
				
				(SELECT SUM(".$campo.") FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']." AND c.grado = 'VII' AND c.categoria = 2) as sueldogradoVII";

			}

			$query = $query . ",
				(SELECT MAX(".$campo.") FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				WHERE mn.id_empresa = ".$user['id_empresa']."
				AND c.categoria = 2) as maximosueldo
							
				FROM matriz_nomina mn 
				INNER JOIN cargos c ON mn.id_cargo = c.id
				INNER JOIN empresas e ON c.id_empresa = e.id 
				WHERE mn.id_empresa = ".$user['id_empresa']."
				AND c.categoria = 2";
			
			}

			$stmt = $this->conn->prepare($query);
			$stmt->execute();
			
			if($stmt->rowCount()>0)
			{
				$data = array();
				while($row=$stmt->fetch(PDO::FETCH_ASSOC))
					{
						$data[] = $row;
	
					} 
					return $data;
			}
			
		}

       
    
    //FIN FUNCION PARA MOSTRAR LISTADO DE DEPARTAMENTOS EN SELECT

	//SELECT DE CATEGORIAS 
	public function getcategorias()
	{
		$query = "SELECT * FROM tipo_categoria";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        if($stmt->rowCount()>0)
        {
			$data = array();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC))
                {
					$data[] = $row;

                } 
				return $data;
        }
		
	}
	//FIN SELECT DE CATEGORIAS

	//BUSCAR NOMBRE DE MONEDA POR ID DE PAIS
    public function get_nombre_moneda()
	{
		$user = $_SESSION['user'];
		extract($this->get_datos_empresa($user['id_empresa']));	

		$stmt = $this->conn->prepare("SELECT * FROM paises WHERE id=:id_pais");
		$stmt->execute(array(":id_pais"=>$id_pais));
		$editRow=$stmt->fetch(PDO::FETCH_ASSOC);
		return $editRow;
	}
	//FIN BUSCAR NOMBRE DE MONEDA POR ID DE PAIS

	//BUSCAR NOMBRE DE MONEDA POR ID DE PAIS
    public function get_datos_empresa($id_empresa)
	{
		$stmt = $this->conn->prepare("SELECT *, nombre as nombre_empresa FROM empresas WHERE id=:id_empresa");
		$stmt->execute(array(":id_empresa"=>$id_empresa));
		$editRow=$stmt->fetch(PDO::FETCH_ASSOC);
		return $editRow;
	}
	//FIN BUSCAR NOMBRE DE MONEDA POR ID DE PAIS

	//BUSCAR NOMBRE DE MONEDA POR ID DE PAIS
    public function get_sum_empleados($categoria)
	{
		$stmt = $this->conn->prepare("SELECT COUNT(*) as conteo
		FROM matriz_nomina mn 
		INNER JOIN cargos c ON c.id = mn.id_cargo
		WHERE categoria=:categoria");
		$stmt->execute(array(":categoria"=>$categoria));
		$editRow=$stmt->fetch(PDO::FETCH_ASSOC);
		return $editRow;
	}
	//FIN BUSCAR NOMBRE DE MONEDA POR ID DE PAIS

	public function get_nivel_empresarial($nivel_empresarial)
	{
		$stmt = $this->conn->prepare("SELECT nombre as nombre_nivel, minimo as minimo_nivel, maximo as maximo_nivel
		FROM tipo_escala_trabajadores
		WHERE id=:nivel_empresarial");
		$stmt->execute(array(":nivel_empresarial"=>$nivel_empresarial));
		$editRow=$stmt->fetch(PDO::FETCH_ASSOC);
		return $editRow;
	}
	//FIN BUSCAR NOMBRE DE MONEDA POR ID DE PAIS
	
}
?>