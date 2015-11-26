<?php

namespace App\Repositories;

use App\Models\Usuario_Servicio;
use App\Models\Promocion_Usuario_Servicio;
use App\Models\Catalogo_Dificultad;
use App\Models\Detalle_Itinerario;
use App\Models\Itinerario_Usuario_Servicio;
use App\Models\Eventos_usuario_Servicio;
use App\Models\Image;
use Illuminate\Support\Facades\DB;

class ServiciosOperadorRepository extends BaseRepository {

    /**
     * The Role instance.
     *
     * @var App\Models\Usuario Servicios
     */
    protected $userservicios;

    /**
     * The Promocion_Usuario_Servicio instance.
     *
     * @var App\Models\Role
     */
    protected $promocion;
    protected $catalogo_dificultad;
    protected $image;
    protected $itinerarios_u;
    protected $detalle_itinerarios_u;
    protected $eventos;

    /**
     * Create a new ServiciosOperadorRepository instance.
     *
     * @param  App\Models\UserServicios $userservicios

     * @return void
     */
    public function __construct(Usuario_Servicio $userservicios) {
        $this->model = $userservicios;
        $this->promocion = new Promocion_Usuario_Servicio();
        $this->image = new Image();
        $this->catalogo_dificultad = new Catalogo_Dificultad();
        $this->itinerarios_u = new Itinerario_Usuario_Servicio();
        $this->detalle_itinerarios_u = new Detalle_Itinerario();
        $this->eventos = new Eventos_usuario_Servicio();
    }

    /**
     * Save the User.
     *
     * @param  App\Models\UserServicio $user_servicios

     * @return void
     */
    private function save($user_servicios) {

        $user_servicios->save();
    }

    /**
     * Create a user.
     *
     * @param  array  $inputs
     * @param  int    $confirmation_code
     * @return App\Models\User 
     */
    public function storeNew($inputs) {
        $user_servicios = new $this->model;
        $user_servicios->id_catalogo_servicio = $inputs['id_catalogo_servicio'];
        $user_servicios->id_usuario_operador = $inputs['id_usuario_op'];
        $user_servicios->estado_servicio = '1';
        $this->save($user_servicios);
        return $user_servicios;
    }

    
    //Guarda las promociones por usuario_servicio
    public function storeNewPromocion($inputs) {

        $promocionU = new $this->promocion;
        $promocionU->id_usuario_servicio = $inputs['id_usuario_servicio'];
        $promocionU->id_catalogo_tipo_fotografia = 2;
        $promocionU->descripcion_promocion = $inputs['descripcion'];
        $promocionU->nombre_promocion = $inputs['nombre_promocion'];
        $promocionU->estado_promocion = 1;
        $promocionU->fecha_desde = $inputs['fecha_inicio'];
        $promocionU->fecha_hasta = $inputs['fecha_fin'];
        $promocionU->precio_normal = $inputs['precio_normal'];
        $promocionU->descuento = $inputs['descuento'];
        $promocionU->codigo_promocion = $inputs['codigo'];
        $promocionU->created_at = \Carbon\Carbon::now()->toDateTimeString();
        $promocionU->updated_at = \Carbon\Carbon::now()->toDateTimeString();

        $this->save($promocionU);
        return $promocionU;
    }

    
    
    
    /**/
    
    
    
    public function storeNewItinerario($inputs) {

        $ItinerarioU = new $this->itinerarios_u;
        $ItinerarioU->id_usuario_servicio = $inputs['id_usuario_servicio'];
        $ItinerarioU->id_fotografia = 3;
        $ItinerarioU->descripcion_itinerario = $inputs['descripcion_itinerario'];
        $ItinerarioU->nombre_itinerario = $inputs['nombre_itinerario'];
        $ItinerarioU->id_catalogo_dificultad = $inputs['id_dificultad'];
        $ItinerarioU->estado_itinerario = 1;
        $ItinerarioU->created_at = \Carbon\Carbon::now()->toDateTimeString();
        $ItinerarioU->updated_at = \Carbon\Carbon::now()->toDateTimeString();

        $this->save($ItinerarioU);
        return $ItinerarioU;
    }
    
    
    
    public function storeNewEvento($inputs) {

        $evento = new $this->eventos;
        $evento->id_usuario_servicio = $inputs['id_usuario_servicio'];
        $evento->id_fotografia = 4;
        $evento->descripcion_evento = $inputs['descripcion_evento'];
        $evento->nombre_evento = $inputs['nombre_evento'];
        $evento->estado_evento = 1;
        $evento->created_at = \Carbon\Carbon::now()->toDateTimeString();
        $evento->updated_at = \Carbon\Carbon::now()->toDateTimeString();

        $this->save($evento);
        return $evento;
    }

    public function storeNewDetalleItinerario($inputs) {

        $ItinerarioU = new $this->detalle_itinerarios_u;


        $ItinerarioU->id_itinerario = $inputs['id_itinerario'];
        $ItinerarioU->lugar_punto = $inputs['lugar_punto'];
        $ItinerarioU->longitud_punto = $inputs['longitud_servicio'];
        $ItinerarioU->latitud_punto = $inputs['latitud_servicio'];
        $ItinerarioU->estado_punto = 1;
        $ItinerarioU->diahora_punto= $inputs['diahora_punto'];
        $ItinerarioU->incluye_punto= $inputs['incluye_punto'];
        $ItinerarioU->tags_punto= $inputs['tag'];
        $ItinerarioU->created_at = \Carbon\Carbon::now()->toDateTimeString();
        $ItinerarioU->updated_at = \Carbon\Carbon::now()->toDateTimeString();

        $this->save($ItinerarioU);
        return $ItinerarioU;
    }

    public function storeUpdateEstado($inputs, $usuario_servicio) {

        //Transformo el arreglo en un solo objeto
        foreach ($usuario_servicio as $servicioBase) {
            $inputs['id_usuario_servicio'] = $servicioBase->id;
            $this->updateServ($inputs, 'estado_servicio_usuario');
        }



        return true;
    }

    /**
     * Create a user.
     *
     * @param  array  $inputs
     * @param  int    $usuario_servicio
     * @return App\Models\User 
     */
    public function storeUpdate($inputs, $usuario_servicio) {

        //Transformo el arreglo en un solo objeto
        foreach ($usuario_servicio as $servicioBase) {
            $inputs['id_usuario_servicio'] = $servicioBase->id;
            $this->updateServ($inputs, 'estado_servicio');
        }

        return true;
    }

    
    //actualiza los eventos
    public function storeUpdateEvento($inputs, $evento) {

        foreach ($evento as $servicioBase) {
            $pro = $this->itinerarios_u->find($servicioBase->id);
            
            //Transformo el arreglo en un solo objeto
            $inputs['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
            $pro->fill($inputs)->save();
        }

        return true;
    }
    
    
    //actualiza los itinerarios
    public function storeUpdateItinerario($inputs, $itiner) {

        foreach ($itiner as $servicioBase) {
            $pro = $this->itinerarios_u->find($servicioBase->id);
            
            //Transformo el arreglo en un solo objeto
            $inputs['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
            $inputs['id_catalogo_dificultad'] = $inputs['id_dificultad'];
            
            $pro->fill($inputs)->save();
        }

        return true;
    }
    
    public function storeUpdatePromocion($inputs, $promo) {

        foreach ($promo as $servicioBase) {
            $pro = $this->promocion->find($servicioBase->id);
            //Transformo el arreglo en un solo objeto
            //$inputs['id'] =  $promo->id;
            $inputs['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
            $pro->fill($inputs)->save();
        }

        return true;
    }

    
    
    public function storeUpdateDetalleItinerario($inputs, $det_iti) {

        foreach ($det_iti as $servicioBase) {
            $pro = $this->detalle_itinerarios_u->find($servicioBase->id);
            //Transformo el arreglo en un solo objeto
            $inputs['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
            
            $inputs['longitud_punto'] = $inputs['longitud_servicio'];
            $inputs['latitud_punto'] = $inputs['latitud_servicio'];
            $inputs['tags_punto'] = $inputs['tag'];
              
  
  
            $pro->fill($inputs)->save();
        }

        return true;
    }

    public function updatePromo($promo) {
        $operador = new $this->promocion;
        $operadorData = $operador::where('id', $promo['id'])
                ->update([$campo => $input[$campo]]);
    }

    //Realiza la logica del update
    public function updateServ($input, $campo) {
        $operador = new $this->model;
        $operadorData = $operador::where('id', $input['id_usuario_servicio'])
                ->update([$campo => $input[$campo]]);
    }

//Entrega el arreglo de Servicios por operador
    public function getServiciosOperador($id_usuario_operador) {
        $user_servicios = new $this->model;
        return $user_servicios::where('id_usuario_operador', $id_usuario_operador)
                        ->where('estado_servicio', '=', 1)->get();
    }

    //Entrega el arreglo de promociones por operador
    public function getPromocionesOperador($id_promocion) {
        $promociones = new $this->promocion;
        return $promociones::where('id', $id_promocion)->get();
    }
    
    
    
        //Entrega el arreglo de promociones por usuario servicio
    public function     getPromocionesUsuarioServicio($id_usuario_servicio) {
        $promociones = new $this->promocion;
        return $promociones::where('id_usuario_servicio','=', $id_usuario_servicio)->get();
        
          
        return $promociones::All();
    }
    
    
    //Entrega el arreglo de itinerarios por usuario_servicio
    public function getItinerariosporUsuario($id_usuario_servicio) {
        $itiner = new $this->itinerarios_u;
        return $itiner::where('id_usuario_servicio', $id_usuario_servicio)->get();
    }

    //Entrega el arreglo de itinerarios por operador
    public function getItinerariosUsuario($id_itinerario) {
        $itiner = new $this->itinerarios_u;
        return $itiner::where('id', $id_itinerario)->get();
    }
    
    //Entrega el arreglo de detalle itinerarios por id tinerario
    public function getItinerariosDetalle($id_itinerario) {
        $itiner = new $this->detalle_itinerarios_u;
        return $itiner::where('id_itinerario', $id_itinerario)->get();
    }

    //Entrega el arreglo de Servicios por operador
    public function getCatalogoDificultad() {
        $dif = new $this->catalogo_dificultad;
        return $dif::All();
    }

    //Entrega el arreglo de Imagenes por promocion por operador
    public function getImagePromocionesOperador($id_promocion) {
        $promociones = new $this->image;
        return $promociones::where('id_auxiliar', $id_promocion)
                        ->where('id_catalogo_fotografia', '=', 2)
                        ->where('estado_fotografia', '=', 1)->get();
    }

    //lista de itinerarios imagenes
    public function getImageItinerarioOperador($id_itinerario) {
        $itiner = new $this->image;
        return $itiner::where('id_auxiliar', $id_itinerario)
                        ->where('id_catalogo_fotografia', '=', 3)
                        ->where('estado_fotografia', '=', 1)->get();
    }

    //Entrega el arreglo de Itinerarios por operador
    public function getItinerario($id_itinerario) {

        return DB::table('itinerarios_usuario_servicios')
                        ->where('id', '=', $id_itinerario)->get();
    }

    
    //Entrega el arreglo de Detalle Itinerarios por operador
    public function getDetalleItinerario($id_detalle_itinerario) {

        return DB::table('detalles_itinerario')
                        ->where('id', '=', $id_detalle_itinerario)->get();
    }

    //Entrega el arreglo de Itinerarios por id

    public function getPromocion($id_promocion) {

        return DB::table('promocion_usuario_servicio')
                        ->where('id', '=', $id_promocion)->get();
    }

    //Entrega el arreglo de Servicios por operador completo incluyendo los nuevos ingresados por la 
    //pantalla de +
    public function getServiciosOperadorUnicos($id_usuario_operador) {
        return DB::table('usuario_servicios')
                        ->join('catalogo_servicios', 'usuario_servicios.id_catalogo_servicio', '=', 'catalogo_servicios.id_catalogo_servicios')
                        ->where('id_usuario_operador', $id_usuario_operador)
                        ->where('estado_servicio', '=', 1)
                        ->groupby('usuario_servicios.id_catalogo_servicio')->distinct()
                        ->select('catalogo_servicios.nombre_servicio', 'catalogo_servicios.id_catalogo_servicios', 'usuario_servicios.id', 'usuario_servicios.observaciones', 'usuario_servicios.estado_servicio_usuario', 'usuario_servicios.id_usuario_operador')
                        ->get();
    }

    public function getServiciosOperadorAll($id_usuario_operador) {
        return DB::table('usuario_servicios')
                        ->join('catalogo_servicios', 'usuario_servicios.id_catalogo_servicio', '=', 'catalogo_servicios.id_catalogo_servicios')
                        ->where('id_usuario_operador', $id_usuario_operador)
                        ->where('estado_servicio', '=', 1)
                        ->select('usuario_servicios.nombre_servicio', 'catalogo_servicios.id_catalogo_servicios', 'usuario_servicios.id', 'usuario_servicios.estado_servicio_usuario', 'usuario_servicios.id_usuario_operador')
                        ->get();
    }

    //entrega el registro que corresponde al usuario
    public function getServiciosOperadorporIdServicio($id_usuario_operador, $id_catalogo) {

        $user_servicio = Usuario_Servicio::where('id_usuario_operador', '=', $id_usuario_operador)
                        ->where('id_catalogo_servicio', '=', $id_catalogo)->get();
        return $user_servicio;
    }

    //entrega el registro que corresponde al id usuario servicio
    public function getServiciosOperadorporIdUsuarioServicio($id_usuario_servicio) {

        $user_servicio = Usuario_Servicio::where('id', '=', $id_usuario_servicio)->get();

        return $user_servicio;
    }

}
