<?php

namespace Controllers;
use Exception;
use Model\Medico;
use MVC\Router;

class MedicoController{
    public static function index(Router $router){


        $medicos = Medico::all();
        
        

        $router->render('medicos/index', [
            'medicos' => $medicos,
        ]); 
    }

    
//!Funcion Guardar
    public static function guardarAPI(){
        try {
            $medico = new Medico($_POST);
            $resultado = $medico->crear();
            if($resultado['resultado'] == 1){
                echo json_encode([
                    'mensaje' => 'Registro guardado correctamente',
                    'codigo' => 1
                ]);
            }else{
                echo json_encode([
                    'mensaje' => 'Ocurrio un error',
                    'codigo' => 0
                ]);
            }
            // echo json_encode($resultado);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje'=> 'Ocurrio un Error',
                'codigo' => 0
        ]);
        }
    }

//!Funcion Modificar
    public static function modificarAPI(){
        try{
            $medico = new Medico($_POST);
            $resultado = $medico->actualizar();

            if($resultado['resultado'] == 1){
                echo json_encode([
                    'mensaje' => 'Registro guardado correctamente',
                    'codigo' => 1
                ]);
            }else{
                echo json_encode([
                    'mensaje' => 'Ocurrio un error',
                    'codigo' => 0
                ]);
            }
        }catch(Exception $e){
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje'=> 'Ocurrio un Error',
                'codigo' => 0
        ]);
        }
    }

//!Funcion Eliminar
    public static function eliminarAPI(){
        try{
            $medico_id = $_POST['medico_id'];
            $medico = Medico::find($medico_id);
            $medico->medico_situacion = 0;
            $resultado = $medico->actualizar();

            if($resultado['resultado'] == 1){
                echo json_encode([
                    'mensaje' => 'Registro guardado correctamente',
                    'codigo' => 1
                ]);
            }else{
                echo json_encode([
                    'mensaje' => 'Ocurrio un error',
                    'codigo' => 0
                ]);
            }
        }catch(Exception $e){
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje'=> 'Ocurrio un Error',
                'codigo' => 0
        ]);
        }
    }


//!Funcion Buscar
    public static function buscarAPI(){
        $medico_nombre = $_GET['medico_nombre'];
        // $medico_espc = $_GET['medico_espc'];
        // $medico_clinica = $_GET['medico_clinica'];

        $sql = "SELECT * FROM medicos WHERE medico_situacion = 1 ";
        if($medico_nombre != ''){
            $sql .= "AND medico_nombre LIKE '%$medico_nombre%' ";
        }

        // if($medico_espec != ''){
        //     $sql .= "AND medico_espec LIKE '%$medico_espec%' ";
        // }

        // if($medico_situacion != ''){
        //     $sql .= "AND medico_situacion$medico_situacion LIKE '%$medico_situacion%' ";
        // }

        try {
            $medicos = Medico::fetchArray($sql);
            echo json_encode($medicos);
            
        } catch (exception $e) {
                echo json_encode([
                    'detalle' => $e->getMessage(),
                    'mensaje'=> 'Ocurrio un Error',
                    'codigo' => 0
            ]);
        }

    }


}
