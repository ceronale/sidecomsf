<?php
include_once "../layouts/session.php"; 
include_once 'class.crud.php';
$crud = new crud();

if(isset($_GET['iddepa'])){
    $id_categoria = (isset($_POST['id_categoria']))?$_POST['id_categoria']:"";
    $departamentos = $crud->dataview_departamentos($id_categoria);
    $html = "<option value='0'>Seleccione Departamento..</option>";
    if ($departamentos != null){
        foreach ($departamentos as $departamento)
        {
            $html = $html . "<option value='". $departamento['id'] . "'>".$departamento['nombre']." </option>";

        }
    }
    echo $html;
}

if(isset($_GET['iddepaedit'])){
    $categoria = (isset($_POST['categoria']))?$_POST['categoria']:"";
    $id_dp = (isset($_POST['id_dp']))?$_POST['id_dp']:"";

    $departamentos = $crud->dataview_departamentos($categoria);

    if ($departamentos != null){
        foreach ($departamentos as $departamento)
        {
            if($departamento['id'] == $id_dp)
            {
                $html = $html . "<option value='". $departamento['id'] . "' selected >".$departamento['nombre']." </option>";
            }
            else
            {
                $html = $html . "<option value='". $departamento['id'] . "'  >".$departamento['nombre']." </option>";
            }
           

        }
    }
    echo $html;
}


if(isset($_GET['idcargo'])){
    $id_departamento = (isset($_POST['id_departamento']))?$_POST['id_departamento']:"";
    $cargos = $crud->dataview_cargos($id_departamento);
    $html = "<option value='0'>Seleccione Cargo..</option>";
    if ($cargos != null){
        foreach ($cargos as $cargo)
        {
            $html = $html . "<option value='". $cargo['id'] . "'>".$cargo['nombre']." </option>";

        }
    }
    echo $html;
}

if(isset($_GET['idcargoedit'])){
    $id_departamento = (isset($_POST['id_departamento']))?$_POST['id_departamento']:"";
    $idcargo = (isset($_POST['idcargo']))?$_POST['idcargo']:"";

    $cargos = $crud->dataview_cargos($id_departamento);

    if ($cargos != null){
        foreach ($cargos as $cargo)
        {
            if($cargo['id']==$idcargo)
            {
                $html = $html . "<option value='". $cargo['id'] . "' selected>".$cargo['nombre']." </option>";
            }
            else
            {
                $html = $html . "<option value='". $cargo['id'] . "'>".$cargo['nombre']." </option>";
            }
            

        }
    }
    echo $html;
}



if(isset($_GET['grado'])){
    $id_cargo = (isset($_POST['id_cargo']))?$_POST['id_cargo']:"";

    extract($crud->get_datos_cargo($id_cargo));

    $dato1 = $grado;
    $dato2 = $descripcion;
    $dato3 = $puntaje;
    header("Content-Type: application/json");
    echo json_encode(array("dato1" => $dato1, "dato2" => $dato2, "dato3" => $dato3));

}

if(isset($_GET['fecin'])){
    $fecha_ingreso = (isset($_POST['fecha_ingreso']))?$_POST['fecha_ingreso']:"";

    $fechaInicio = date("Y-m-d", strtotime($fecha_ingreso));
    $fechaFin = date("Y-m-d", strtotime('now'));
    $fecha1 = new DateTime($fechaInicio);
    $fecha2 = new DateTime($fechaFin);
    $fecha = $fecha1->diff($fecha2);
    $tiempo = "";
    //años
    if($fecha->y > 0)
    {
        $tiempo .= $fecha->y;
             
        if($fecha->y == 1)
            $tiempo .= " año, ";
        else
            $tiempo .= " años, ";
    }  
    //meses
    if($fecha->m > 0)
    {
        $tiempo .= $fecha->m;
             
        if($fecha->m == 1)
            $tiempo .= " mes, ";
        else
            $tiempo .= " meses, ";
    }
    //dias
    if($fecha->d > 0)
    {
        $tiempo .= $fecha->d;
             
        if($fecha->d == 1)
            $tiempo .= " día ";
        else
            $tiempo .= " días ";
    }      


    $dato = $tiempo;

    header("Content-Type: application/json");
    echo json_encode(array("dato" => $dato));

}

if(isset($_GET['doc'])){
    $documento = (isset($_POST['documento']))?$_POST['documento']:"";
   
    
    $validacion = $crud->validar_documento($documento);
    $dato = $validacion;

    header("Content-Type: application/json");
    echo json_encode(array("dato" => $dato));
}

/*
if(isset($_GET['idprod'])){
    $id_alm_dist = (isset($_POST['id_alm_dist']))?$_POST['id_alm_dist']:"";
    $prod_dists = $crud->dataview_prod_dist_almacen($id_alm_dist);
    $html = "<option value='0'>Seleccione Producto..</option>";
    if ($prod_dists != null){
        foreach ($prod_dists as $prod_dist)
        {
            $html = $html . "<option value='". $prod_dist['idproducto'] . "'>".$prod_dist['pproducto']." - ".date("d/m/Y", strtotime($prod_dist['adpfecha_lote']))." </option>";

        }
    }
    echo $html;
}

if(isset($_GET['cant'])){
    $id_prod = (isset($_POST['id_prod']))?$_POST['id_prod']:"";
    $id_alm_dist = (isset($_POST['id_alm_dist']))?$_POST['id_alm_dist']:"";
    extract($crud->get_cant_max($id_prod,$id_alm_dist));

    $dato = $cant_prod;

    header("Content-Type: application/json");
    echo json_encode(array("dato" => $dato));

}


*/



