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
    public function dataview_resultados($categoria)
    {
		$user = $_SESSION['user'];
		$query = "SELECT c.grado as grado, c.nombre as nombrecargo, mn.nombre as nombretrabajador,
		mn.sueldo_base as sueldobase,  
		ROUND((mn.sueldo_base) - (SELECT MIN(mn.sueldo_base) FROM matriz_nomina mn
							INNER JOIN cargos c 
							ON c.id = mn.id_cargo
							WHERE mn.id_empresa = ".$user['id_empresa'] . " and c.categoria = ".$categoria."),2)  as realvsminimo,
		
		ROUND((mn.sueldo_base) - (SELECT AVG(mn.sueldo_base) FROM matriz_nomina mn
							INNER JOIN cargos c 
							ON c.id = mn.id_cargo
							WHERE mn.id_empresa = ".$user['id_empresa'] . " and c.categoria = ".$categoria."),2) as realvsmedio,
		
		ROUND((mn.sueldo_base) - (SELECT MAX(mn.sueldo_base) FROM matriz_nomina mn
							INNER JOIN cargos c 
							ON c.id = mn.id_cargo
							WHERE mn.id_empresa = ".$user['id_empresa'] . " and c.categoria = ".$categoria."),2) as realvsmaximo,
		
		mn.paqueteanual as paqueteanual, 
		
		ROUND((mn.paqueteanual) - (SELECT MIN(mn.paqueteanual) FROM matriz_nomina mn
							INNER JOIN cargos c 
							ON c.id = mn.id_cargo
							WHERE mn.id_empresa = ".$user['id_empresa'] . " and c.categoria = ".$categoria."),2) as realvsminimoanual,
		
		ROUND((mn.paqueteanual) - (SELECT AVG(mn.paqueteanual) FROM matriz_nomina mn
							INNER JOIN cargos c 
							ON c.id = mn.id_cargo
							WHERE mn.id_empresa = ".$user['id_empresa'] . " and c.categoria = ".$categoria."),2) as realvsmedioanual,
		
		ROUND((mn.paqueteanual) - (SELECT MAX(mn.paqueteanual) FROM matriz_nomina mn
							INNER JOIN cargos c 
							ON c.id = mn.id_cargo
							WHERE mn.id_empresa = ".$user['id_empresa'] . " and c.categoria = ".$categoria."),2) as realvsmaximoanual
		
		
		FROM matriz_nomina mn
		INNER JOIN cargos c 
		ON c.id = mn.id_cargo
		WHERE mn.id_empresa = ".$user['id_empresa'] . " and c.categoria = ".$categoria."
		GROUP BY c.grado ,mn.id, c.categoria
		order by c.grado";
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

			echo $id_tipodivisa;
			echo $id_departamento; 
			echo $id_cargo;
		
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
    public function get_indicadores($categoria)
    {
		
		$user = $_SESSION['user'];

		$query = "SELECT 

		(SELECT SUM(sueldomensual) FROM matriz_nomina mn
		INNER JOIN cargos c 
		ON c.id = mn.id_cargo
		WHERE categoria = " .$categoria. " AND mn.id_empresa = ".$user['id_empresa'] . ") as totalingresomensual,

		(SELECT SUM(paqueteanual) FROM matriz_nomina mn
		INNER JOIN cargos c 
		ON c.id = mn.id_cargo
		WHERE categoria = " .$categoria. " AND mn.id_empresa = ".$user['id_empresa'] . ") as totalpaqueteanual,

		(SELECT ROUND(AVG(sueldomensual),2) FROM matriz_nomina mn
		INNER JOIN cargos c 
		ON c.id = mn.id_cargo
		WHERE categoria = " .$categoria. " AND mn.id_empresa = ".$user['id_empresa'] . ") as promediomensual,

		(SELECT  ROUND(AVG(paqueteanual),2) FROM matriz_nomina mn
		INNER JOIN cargos c 
		ON c.id = mn.id_cargo
		WHERE categoria = " .$categoria. " AND mn.id_empresa = ".$user['id_empresa'] . ") as promedioanual,

		(SELECT count(*) FROM matriz_nomina mn
		INNER JOIN cargos c 
		ON c.id = mn.id_cargo
		WHERE categoria = " .$categoria. " AND mn.id_empresa = ".$user['id_empresa'] . ") as totaltrabajadores,

		(SELECT ROUND(AVG(TIMESTAMPDIFF(YEAR, fecha_ingreso, CURDATE())),2) FROM matriz_nomina mn
		INNER JOIN cargos c 
		ON c.id = mn.id_cargo
		WHERE categoria = " .$categoria. " AND mn.id_empresa = ".$user['id_empresa'] . ") as promedioantiguedad,

		(SELECT SUM(montodivisa) FROM matriz_nomina mn
		INNER JOIN cargos c 
		ON c.id = mn.id_cargo
		WHERE categoria = " .$categoria. " AND mn.id_empresa = ".$user['id_empresa'] . " AND id_tipodivisa = 233) as totaldolares,

		(SELECT SUM(montodivisa) FROM matriz_nomina mn
		INNER JOIN cargos c 
		ON c.id = mn.id_cargo
		WHERE categoria = " .$categoria. " AND mn.id_empresa = ".$user['id_empresa'] . " AND id_tipodivisa = 68) as totaleuros

		FROM matriz_nomina mn
		INNER JOIN cargos c 
		ON c.id = mn.id_cargo
		WHERE categoria = " .$categoria. " AND mn.id_empresa = ".$user['id_empresa'];
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