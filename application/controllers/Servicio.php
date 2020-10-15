<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Servicio extends CI_Controller
{
    private $request;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('ServicioModelo');
        $this->load->model('VehiculoModelo');
        $this->load->model('TarifaModelo');
        $this->load->model('ParqueaderoModelo');
        $this->request = json_decode(file_get_contents('php://input'));
    }

    /**
     * Listar todos los servicios
     *
     */
    public function index()
    {
        $datos["servicios"] = $this->ServicioModelo->listar();
        echo json_encode($datos);
        exit();
    }


    /**
     * Agregar un nuevo servio
     *
     */
    public function nuevoServicio()
    {

        //validar que existe la placa
        $arrayObjeto = $this->VehiculoModelo->listarPlaca($this->request->placa);


        //validar que la placa no este en servicio 
        $registro = $this->ParqueaderoModelo->listarPlaca($this->request->placa);

        if (count($arrayObjeto) > 0 && count($registro) == 0) {
            //hora de entrada
            $hora_entrada = date("Y-m-d H:i:s");

            //buscar id_vehiculo y tipo
            $id_vehiculo = $arrayObjeto[0]->id;
            $tipo = $arrayObjeto[0]->tipo;


            //buscar valor minuto
            $arrayObjeto = $this->TarifaModelo->listar();

            if ($tipo == 'Automovil') {
                $valor_minuto = $arrayObjeto[0]->minuto_autos;
            } else if ($tipo == 'Moto') {
                $valor_minuto = $arrayObjeto[0]->minuto_motos;
            } else {
                $valor_minuto = $arrayObjeto[0]->minuto_bicicletas;
            }


            //ingresar nuevo servicio 
            $this->ServicioModelo->nuevoServicio(array(
                'hora_entrada' => $hora_entrada,
                'valor_minuto' => $valor_minuto,
                'estado' => "Activo",
                'id_vehiculo' => $id_vehiculo,
                'parqueadero' => $this->request->parqueadero,
            ));


            //acutualizar parqueadero
            $this->ParqueaderoModelo->actualizar(array(
                'parqueadero' => $this->request->parqueadero,
                'estado' => "No disponible",
                'placa' => $this->request->placa,
            ));
        } else {
            $this->output->set_status_header(422);
        }
    }

    /**
     * Terminar servicio
     *
     */
    public function terminarServicio()
    {
        //capturar parqueadero 
        $parqueadero = $this->request->parqueadero;

        //buscar id del servicio 
        $registro = $this->ServicioModelo->obtenerIdActivo($parqueadero);
        $id = $registro[0]->id;

        //hora_entrad 
        $hora_entrada = $registro[0]->hora_entrada;
        $entrada = strtotime($hora_entrada);

        //hora de salida 
        $hora_salida = date("Y-m-d H:i:s");
        $salida = strtotime($hora_salida);

        //minutos        
        $minutos = round(($salida - $entrada) / 60);


        //tarifa
        $registro = $this->TarifaModelo->listar();
        if (substr($parqueadero, 0, 1) == "A") {
            $valor_minuto = $registro[0]->minuto_autos;
        }

        if (substr($parqueadero, 0, 1) == "B") {
            $valor_minuto = $registro[0]->minuto_bicicletas;
        }

        if (substr($parqueadero, 0, 1) == "M") {
            $valor_minuto = $registro[0]->minuto_motos;
        }



        //descuento
        $minutos_descuento = $registro[0]->minutos;
        if ($minutos >= $minutos_descuento) {
            $descuento = $registro[0]->descuento;
            $valor_minuto = $valor_minuto * (1 - $descuento / 100);
        }

        $total = $minutos * $valor_minuto;

        //terminar servicio
        $this->ServicioModelo->terminarServicio(array(
            'hora_salida' => $hora_salida,
            'minutos' => $minutos,
            'total' => $total,
            'valor_minuto' => $valor_minuto,
            'estado' => "Terminado",
            'id' => $id,
        ));


        //acutualizar parqueadero
        $this->ParqueaderoModelo->actualizar(array(
            'parqueadero' => $parqueadero,
            'estado' => "Disponible",
            'placa' => null,
        ));
    }

    /**
     * Mover vehiculo
     *
     */
    public function mover()
    {
        //capturar parqueaderos 
        $parqueadero_viejo = $this->request->parqueadero_viejo;
        $parqueadero_nuevo = $this->request->parqueadero_nuevo;


        //buscar id del servicio 
        $registro = $this->ServicioModelo->obtenerIdActivo($parqueadero_viejo);
        $id = $registro[0]->id;

        //actualizar servicio 
        $this->ServicioModelo->actualizarServicio(array(
            'id' => $id,
            'parqueadero' => $parqueadero_nuevo,
        ));

        //registro parqueadero
        $registro_viejo = $this->ParqueaderoModelo->listarParqueadero($parqueadero_viejo);
        $placa_viejo = $registro_viejo[0]->placa;

        //ver si el nuevo parqueadero esta ocupado
        $registro_nuevo = $this->ParqueaderoModelo->listarParqueadero($parqueadero_nuevo);


        //ver si el nuevo parqueadero esta ocupado
        if ($registro_nuevo[0]->estado == 'No disponible') {
            $placa = $registro_nuevo[0]->placa;

            $this->ParqueaderoModelo->actualizar(array(
                'parqueadero' => $parqueadero_nuevo,
                'estado' => "No disponible",
                'placa' => $placa_viejo,
            ));

            $this->ParqueaderoModelo->actualizar(array(
                'parqueadero' => $parqueadero_viejo,
                'estado' => "No disponible",
                'placa' => $placa,
            ));
        } else {
            $this->ParqueaderoModelo->actualizar(array(
                'parqueadero' => $parqueadero_nuevo,
                'estado' => "No disponible",
                'placa' => $placa_viejo,
            ));

            $this->ParqueaderoModelo->actualizar(array(
                'parqueadero' => $parqueadero_viejo,
                'estado' => "Disponible",
                'placa' => null,
            ));
        }
    }

    public function reporte1($fecha_inicial, $fecha_final)
    {
        $datos["reporte"] = $this->ServicioModelo->parqueaderoMasUsado($fecha_inicial, $fecha_final);

        if (count($datos["reporte"]) > 0) {
            $respuesta = $datos["reporte"][0]->parqueadero;
        } else {
            $respuesta = "No existen registros";
        }
        echo json_encode($respuesta);
        exit();
    }

    public function reporte2($fecha_inicial, $fecha_final)
    {
        $datos["reporte"] = $this->ServicioModelo->transacciones($fecha_inicial, $fecha_final);
        echo json_encode($datos);
        exit();
    }

    public function reporte3($fecha_inicial, $fecha_final)
    {
        $datos["reporte"] = $this->ServicioModelo->tipos($fecha_inicial, $fecha_final);
        echo json_encode($datos);
        exit();
    }

    public function reporte4($fecha_inicial, $fecha_final)
    {
        $datos["reporte"] = $this->ServicioModelo->total($fecha_inicial, $fecha_final);
        echo json_encode($datos);
        exit();
    }
    
}
