<?php

namespace App\Livewire\Web;

use App\Models\jardin_txt;
use App\Models\jardin_url;
use App\Models\lista_nombres;
use App\Models\lista_nombresc;
use App\Models\lista_txt;
use App\Models\lista_img;
use App\Models\lista;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class ListaController extends Component
{

    public $edit;
    public $url;
    public $tipoVer;#### Var para visualizar: 'cuadro','tabla'
    public $lst_orden, $lst_sent, $lst_numero, $lst_numeroFront; ### oreden y sentido sde la tabla y cantidad de paginación
    public $lst_buscar;

    use WithPagination;

    #[Layout('plantillas.baseJardin')]
    public function mount($jardin){
        ##### Recibe parámetros por url y los procesa
        $this->url=jardin_url::whereRaw('LOWER(urlj_cjarsiglas) = ?', strtolower($jardin))
            ->where('urlj_url','inicio')
            ->where('urlj_act','1')->where('urlj_del','0')
            ->with('jardin')
            ->with('lenguas')
            ->first();

        if($this->url == null){
            redirect('/error La url que ingresaste es incorrecta');
            return;
        }

        ##### Si no hay banner, pone uno default
        $default='/imagenes/banners/fondo-directorio.jpg';
        if($this->url->urlj_bannerimg==''){
            $this->url->urlj_bannerimg=$default;
        }

        if( session()->has('tipoVerLista')) {
            $this->tipoVer= session('tipoVerLista');

        }else{
            session()->put('tipoVerLista','cuadro');
            $this->tipoVer='cuadro';
        }
        ###### prepara variables
        $this->lst_orden='lst_id';
        $this->lst_sent='asc';

        // $numero=20;
        $numero=3;
        if( session()->has('paginarLista')) {
            $this->lst_numero= session('paginarLista');

        }else{
            session()->put('paginarLista',$numero);
            $this->lst_numero=$numero;
        }
        $this->lst_buscar='';
    }

    public function CambiarModoVista(){
        if($this->tipoVer=='cuadro'){
            $this->tipoVer='tabla';
            session()->put('tipoVerLista','tabla');
        }else{
            $this->tipoVer='cuadro';
            session()->put('tipoVerLista','cuadro');
        }
    }

    public function AbrirModalDeListaEspecie($id){
        $datos=[
            'jardin'=>$this->url->urlj_cjarsiglas,
            'lstId'=>$id,
        ];

        $this->dispatch('AbrirModalDeListaDeEspecies',$datos);
    }

    public function ActivarInactivar($id){
        $registro=lista::find($id);
        if($registro->lst_act == '1'){$registro->lst_act='0';}else{$registro->lst_act='1';}
        $registro->save();
    }

    public function Eliminar($id){
        lista::where('lst_id',$id)->update(['lst_del'=>'1']);
    }

    public function Renumerar(){
        $ordenes=lista::where('lst_cjarsiglas', $this->url->urlj_cjarsiglas)
            ->where('lst_del','0')
            ->orderBy('lst_orden','asc')
            ->pluck('lst_id')
            ->toArray();

        $n=0;
        foreach($ordenes as $orden){
            $n++;
            lista::where('lst_id',$orden)
                ->update(['lst_orden'=>$n]);
        }
    }

    public function cambiaPaginacion(){
        $this->lst_numero=$this->lst_numeroFront;
        session()->put('paginarLista',$this->lst_numeroFront);
        redirect('/jardin/'.$this->url->urlj_cjarsiglas.'/listado?page=1');
    }


    ##########################################################
    ################## Modal externo Yo tengo algo que aportar
    public function AbrirModalYoTengoAlgoQueAportar($id){
        ##### <livewire:web.modal-cedula-yo-tengo-que-aportar />
        $dato=[
            'urlId'=>$id,
            'tipoGeneral'=>'lista',
        ];
        $this->dispatch('AbreModalYoTengoQueAportar',$dato);
    }

    public function AbreModalEditaParrafo($id, $orden){

        if($this->edit=='1'){
            ###### Si es nuevo, calcula el orden
            if($id=='0'){
                $orden=jardin_txt::where('jar_urljid',$this->url->urlj_id)
                    ->where('jar_act','1')->where('jar_del','0')
                    ->max('jar_orden') + 1;
            }
            ##### Abre modal
            $data=[
                'id'=>$id,
                'orden'=>$orden,
                'modulo'=>'lista',
                'url'=>'lista',
                'jardin'=>$this->url->urlj_cjarsiglas,
                'reload'=>'0',
            ];
            $this->dispatch('AbreModalDeParrafoWebJardin',$data);
        }
    }

    public function LimpiarBusqueda(){
        $this->lst_buscar='';
    }

    public function render(){
        ###### Determina permisos
        $this->edit='0';
        if(session('rol')){
            if(array_intersect(['admin'], session('rol')) ){
                $this->edit='1';
            }
        }

        ##### Genera lista de especies
        $lista=lista::query();
        if($this->edit != '1'){$lista->where('lst_act','1');}

        $lista=$lista->where('lst_cjarsiglas',$this->url->urlj_cjarsiglas)
            ->where('lst_del','0')
            ->orderBy('lst_orden','asc')
            ->with('nombres')
            ->with('nombrescient')
            ->with('imagenes')
            ->orderBy($this->lst_orden,$this->lst_sent);

        ##### Búsqueda de nombres y nombres científicos
        if(strlen($this->lst_buscar) >= 3){
            $lista=$lista->whereHas('nombres', function ($query) {
                return $query
                ->where('lstn_name','ILIKE', "%$this->lst_buscar%");
            })
            ->orWhereHas('nombrescient', function ($query) {
                return $query
                ->where('lstsc_scname','ILIKE', "%$this->lst_buscar%");
            });
            $this->setPage('1');
        }
        $lista=$lista->paginate($this->lst_numero);

        ##### Calcula SumReal ySumCant para detectar si hay que renumerar el listado
        $SumReal=lista::where('lst_cjarsiglas', $this->url->urlj_cjarsiglas)->where('lst_del','0')->sum('lst_orden');
        $SumCant=array_sum(range(  1, lista::where('lst_cjarsiglas', $this->url->urlj_cjarsiglas)->where('lst_del','0')->count() ));


        $TablaDeTexto=lista_txt::where('lstxt_cjarsiglas',$this->url->urlj_cjarsiglas)
            ->where('lstxt_del','0')
            ->get();

        $lenguas=lista_nombres::join('lista','lst_id','=','lstn_lstid')
            ->where('lstn_del','0')->where('lstn_act','1')
            ->where('lst_del','0')->where('lst_act','1')
            ->where('lst_cjarsiglas',$this->url->urlj_cjarsiglas)
            ->select(DB::raw('count(DISTINCT lstn_lstid) as num'),DB::raw('count(lstn_audio) as audio'), 'lstn_lencode')
            ->groupBy(['lstn_lencode'])
            ->get();

        $audios=lista_nombres::join('lista','lst_id','=','lstn_lstid')
            ->where('lstn_del','0')->where('lstn_act','1')
            ->where('lst_del','0')->where('lst_act','1')
            ->where('lst_cjarsiglas',$this->url->urlj_cjarsiglas)
            ->where('lstn_audio','!=','')
            ->select(DB::raw('count(DISTINCT lstn_lstid) as num'), 'lstn_lencode')
            ->groupBy(['lstn_lencode'])
            ->get();

        $nombrescient=lista_nombresc::join('lista','lst_id','=','lstsc_lstid')
            ->where('lstsc_del','0')->where('lstsc_act','1')
            ->where('lst_del','0')->where('lst_act','1')
            ->where('lst_cjarsiglas',$this->url->urlj_cjarsiglas)
            ->select(DB::raw('count(lstsc_lstid) as numsp'),'lstsc_lstid')
            ->groupBy('lstsc_lstid')
            ->get();

        ##### Cuenta # de imags por cada elemento (para luego contar los que tienen 1 o más imágenes)
        $imags=lista_img::join('lista','lst_id','=','lstimg_lstid')
            ->where('lstimg_del','0')->where('lstimg_act','1')
            ->where('lst_del','0')->where('lst_act','1')
            ->where('lst_cjarsiglas',$this->url->urlj_cjarsiglas)
            ->select(DB::raw('count(lstimg_lstid) as numimg'),'lstimg_lstid')
            ->groupBy('lstimg_lstid')
            ->get();

        return view('livewire.web.lista-controller',[
            'lista'=>$lista,
            'SumReal'=> $SumReal,
            'SumCant'=> $SumCant,
            'txt'=>$TablaDeTexto,
            'estadisticas'=>[
                'lenguas'=>$lenguas,
                'audios'=>$audios,
                'nomcient'=>$nombrescient->where('numsp','>=','1')->count(),
                'img'=>$imags->where('numimg','>=','1')->count(),
            ],
        ]);
    }


}
