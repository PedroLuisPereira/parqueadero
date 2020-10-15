<?php

defined('BASEPATH') or exit('No direct script access allowed');

class ServicioModelo extends CI_Model
{
    public $id;
    public $hora_entrada;
    public $hora_salida;
    public $minutos;
    public $valor_minuto;
    public $total;
    public $estado;
    public $id_vehiculo;


    public function __construct()
    {
        parent::__construct();
    }

    public function listar()
    {
        $this->db->select('servicios.id, servicios.hora_entrada, 
        servicios.hora_salida, servicios.minutos, 
        servicios.valor_minuto, servicios.total, 
        servicios.estado,servicios.parqueadero,
        vehiculos.placa');
        $this->db->order_by('id', 'DESC');
        $this->db->from('servicios');
        $this->db->join('vehiculos', 'servicios.id_vehiculo = vehiculos.id');
        $query = $this->db->get()->result();
        return $query;
    }



    public function listarParqueadero($parqueadero)
    {
        $this->db->where('parqueadero', $parqueadero);
        $query = $this->db->get('servicios')->result();
        return $query;
    }


    public function obtenerIdActivo($parqueadero)
    {
        $this->db->where('parqueadero', $parqueadero);
        $this->db->where('estado', "Activo");
        $query = $this->db->get('servicios')->result();
        return $query;
    }

    public function nuevoServicio($data)
    {
        $this->db->insert('servicios', array(
            'hora_entrada' => $data['hora_entrada'],
            'valor_minuto' => $data['valor_minuto'],
            'parqueadero' => $data['parqueadero'],
            'estado' => $data['estado'],
            'id_vehiculo' => $data['id_vehiculo'],
        ));
    }



    public function terminarServicio($data)
    {
        $this->db->where('id', $data['id'])->update('servicios', array(
            'hora_salida' => $data['hora_salida'],
            'minutos' => $data['minutos'],
            'valor_minuto' => $data['valor_minuto'],
            'total' => $data['total'],
            'estado' => $data['estado'],
        ));
    }

    public function actualizarServicio($data)
    {
        $this->db->where('id', $data['id'])->update('servicios', array(
            'parqueadero' => $data['parqueadero'],
        ));
    }

    public function parqueaderoMasUsado($fecha_inicial, $fecha_final)
    {
        $query = $this->db->query("SELECT parqueadero, COUNT( parqueadero ) AS total
        FROM  servicios
        where (hora_entrada >= '$fecha_inicial' and hora_entrada <= '$fecha_final')
        GROUP BY parqueadero
        ORDER BY total DESC")->result();

        return $query;
    }

    public function transacciones($fecha_inicial, $fecha_final)
    {
        $query = $this->db->query("SELECT vehiculos.placa, COUNT( id_vehiculo ) AS total
        FROM  servicios
        JOIN vehiculos ON vehiculos.id = servicios.id_vehiculo
        where (hora_entrada >= '$fecha_inicial' and hora_entrada <= '$fecha_final')
        GROUP BY id_vehiculo
        ORDER BY total DESC")->result();

        return $query;
    }

    public function tipos($fecha_inicial, $fecha_final)
    {
        $query = $this->db->query("SELECT vehiculos.tipo, COUNT( vehiculos.tipo ) AS total
        FROM  servicios
        JOIN vehiculos ON vehiculos.id = servicios.id_vehiculo
        where (hora_entrada >= '$fecha_inicial' and hora_entrada <= '$fecha_final')
        GROUP BY vehiculos.tipo
        ORDER BY total DESC")->result();
        return $query;
    }

    public function total($fecha_inicial, $fecha_final)
    {
        $query = $this->db->query("SELECT SUM(total) as total FROM servicios
        where (hora_entrada >= '$fecha_inicial' and hora_entrada <= '$fecha_final')")->result();
        return $query;
    }



}
