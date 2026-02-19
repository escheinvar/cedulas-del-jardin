<?php

namespace App\Livewire\Web;

use App\Models\WebEventosModel;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\WithPagination;

class EventosController extends Component
{
    use WithPagination;
    use WithFileUploads;
    ##################################### Eventos Controller ###################################################################
    ### Modelos:  WebEventosModel (www_eventos),
    ### Variables: auth()->user(), session(rol),
    ### Javascript: --
    ### Otros módulos: WithPagination, WithFileUploads
    ### Boostrap: iconos (bi bi-trash, bi bi-pencil-square, bi bi-plus-circle)
    ###
    ### View-Controller:
    ###   El view muestra las fichas de eventos futuros y fichas de eventos pasados contenidos en el modelo WebEventosModel.
    ###   Para mostrar las fichas, la funcion_render, carga la tabla de eventos futuros (eventosProx) y eventos pasados (eventosPast) y los manda a view.
    ###   El view tiene un botón_"Nuevo Evento" que solo se mustra si session(rol)=webmaster.
    ###   La variable VerNuevoEvento es un flag que cuando =0 view oculta la sección de formulario de nuevo evento y cuando =1 lo muestra.
    ###   La variable TipoFormulario es otro flag que cuando =0 está ingresando nuevo evento y cuando>0 indica el id del evento que se edita.
    ###   Al  picar el botón_"Nuevo Evento" se activa la funcion_"MostrarNuevoEvento", la cual cambia flag_VerNuevoEvento=1 (para mostrar el formulario_"Nuevos Evento")
    ###   y flag_TipoFormulario='0' para indicar que es un nuevo evento.
    ###   Cada ficha de evento en el view, cuenta con un ícono de editar y uno de tirar que solo se muestran cuando se tiene el session(rol)=webmaster.
    ###   Cuando se pica ícono de "editar evento" se activa fun_EditaEvento, que carga los datos preexistentes y cambia flag_VerNuevoEvento=1 (para mostrar el formulario_"Nuevo Evento")
    ###   y el flag_TipoFormulario con el id de la ficha en edición (que siempre será > 0 para indicar que se está editando la ficha existente.
    ###   El formulario_"Nuevo evento" carga un archivo temporal de imágen, lo cual es conflictivo cuando se carga desde base de datos (cuando se edita),
    ###   ya que no cuenta con $imagen->temporaryUrl(), por lo que se generó la variable $imagen2 (para mostrar la imágen desde base de datos) y dejar $imagen para las cargadas desde formulario.
    ###########################################################################################################################
    public $Cantidad;
    public $VerNuevoEvento, $TipoFormulario;
    public $titulo, $lugar, $descripcion, $descripcion2, $tipo, $fechaIni, $horaIni, $fechaFin, $horaFin, $costo, $imagen, $imagen2;

    public function mount(){
        $this->Cantidad='5';                ##### Indica el número de eventos pasados a mostrar (los demás lo mete a tabla)
        $this->lugar='Biblioteca del Jardín Etnobiológico de Oaxaca';  ##### Texto predeterminado del formulario de "nuevo evento"
        $this->costo='Actividad gratuita';  ##### Texto predeterminado del formulario de "nuevo evento"
        $this->VerNuevoEvento='0';          ##### Flag ==0 oculta el formulario de "nuevo evento" ==1 lo muestra
        $this->TipoFormulario='0';          ##### Flag ==0 genera nuevo evento ==1 edita evento existente
    }

    public function MostrarNuevoEvento(){
        $this->CancelarNuevoEvento();
        $this->VerNuevoEvento='1';
        $this->TipoFormulario='0';
    }

    public function CancelarNuevoEvento(){
        ##### Vacía todas las variables del formulario "Nuevo Evento"
        $this->VerNuevoEvento='0';
        $this->titulo='';
        $this->lugar='Biblioteca del Jardín Etnobiológico de Oaxaca';
        $this->descripcion='';
        $this->descripcion2='';
        $this->tipo='';
        $this->fechaIni='';
        $this->horaIni='';
        $this->fechaFin='';
        $this->horaFin='';
        $this->costo='Actividad gratuita';
        $this->imagen='';
        $this->imagen2='';
    }

    public function EditaEvento($evId){
        $this->CancelarNuevoEvento();
        $this->VerNuevoEvento='1';
        $this->TipoFormulario=$evId;
        $data=WebEventosModel::where('wwevs_id',$evId)->first();

        $this->titulo=$data->wwevs_titulo;
        $this->lugar=$data->wwevs_lugar;
        $this->descripcion=$data->wwevs_descrip;
        $this->descripcion2=$data->wwevs_descrip2;
        $this->tipo=explode(',',$data->wwevs_label);
        $this->fechaIni=$data->wwevs_dateini;
        $this->horaIni=$data->wwevs_timeini;
        $this->fechaFin=$data->wwevs_datefin;
        $this->horaFin=$data->wwevs_timefin;
        $this->costo=$data->wwevs_costo;
        $this->imagen2=$data->wwevs_img;
    }

    public function Guardar(){
        ##### Valida campos
        $this->validate([
            'titulo'=>'required',
            'lugar'=>'required',
            'descripcion'=>'required',
            'tipo'=>'required',
            'fechaIni'=>'required',
            'horaIni'=>'required',
            'fechaFin'=>'after_or_equal:fechaIni',
        ]);
        ##### Prepara variables
        $tipo=implode(',',$this->tipo);
        if($this->fechaIni == $this->fechaFin AND $this->horaFin < $this->horaIni){
            $this->horaFin=$this->horaIni;
        }
        if($this->costo =='' or $this->costo <= '0'){
            $this->costo='Actividad gratuita';
        }
        ##### imagen puede estar vacía porque no se puso, o porque viene de edición (de imagen2)
        ##### Si no está vacía, entonces prepara el nombre del archivo.
        if($this->imagen == null OR $this->imagen ==''){
            if($this->imagen2 != ''){
                $img=$this->imagen2;
            }else{
                $img='/imagenes/eventos/evento.png';
            }
        }else{
            ##### Prepara nombre
            $quitar=array(' ','!','"','$','%','&','/','(',')','=','?','\'','¿','¡','*');
            $nombre=date("ymd", strtotime($this->fechaIni)).'_'.str_replace($quitar,'',$this->titulo).'.'.$this->imagen->getClientOriginalExtension();
            ##### Guarda imagen
            $this->imagen->storeAs(path:'/aPublic/imagenes/eventos/', name:$nombre);
            $img='/imagenes/eventos/'.$nombre;
        }

        ##### Guarda variables en tabla
        WebEventosModel::updateOrCreate(['wwevs_id'=>$this->TipoFormulario],[
            'wwevs_act'=>'1',
            'wwevs_titulo'=>$this->titulo,
            'wwevs_descrip'=>$this->descripcion,
            'wwevs_descrip2'=>$this->descripcion2,
            'wwevs_label'=>$tipo,
            'wwevs_lugar'=>$this->lugar,
            'wwevs_dateini'=>$this->fechaIni,
            'wwevs_datefin'=>$this->fechaFin,
            'wwevs_timeini'=>$this->horaIni,
            'wwevs_timefin'=>$this->horaFin,
            'wwevs_costo'=>$this->costo,
            'wwevs_img'=>$img,
        ]);

        $this->TipoFormulario='0'; ##### Para ocultar el formulario
        $this->CancelarNuevoEvento();  ##### Para limpiar las variables
        $this->VerNuevoEvento='0'; ##### Para regresar a formulario vacío (nuevo)
    }

    public function Borrar($id){
        ##### Inactiva el registro (act=>0)
        WebEventosModel::where('wwevs_id',$id)->update([
            'wwevs_act'=>'0',
        ]);
    }

    public function BorrarImagen(){
        ##### Elimina los valores de variables de imágen
        $this->imagen='';
        $this->imagen2='';
    }

    public function render() {
        $mes=['no','enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre'];
        $prox=WebEventosModel::where('wwevs_act','1')
            ->OrderBy('wwevs_dateini','asc')->where('wwevs_datefin','>=',now())->get();
        $past=WebEventosModel::where('wwevs_act','1')
            ->OrderBy('wwevs_dateini','desc')->where('wwevs_datefin','<',now())->paginate($this->Cantidad);

        return view('livewire.web.eventos-controller',[
            'eventosProx'=>$prox,
            'eventosPast'=>$past,
            'mes'=>$mes,
        ]);
    }
}
