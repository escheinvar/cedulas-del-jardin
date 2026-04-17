<?php
use App\Mail\CorreoPorAvisoDeBuzon;
use App\Mail\CorreoPorAvisoDeMail;
use App\Models\buzon;
use App\Models\cat_autores;
use App\Models\ced_autores;
use App\Models\User;
use Illuminate\Contracts\Mail\Mailable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;


#### si actualizo helper, usar: composer dump-autoload
##################################################################
########## NOTA: Esta función gneral usa la extensión Mailgun y sus
##########       archs /App/Mail/CorreoPorAvisoDeBuzon.php

if(!function_exists('EnviaMensajeAbuzon')){


    ###### Función que recibe variables y envía mensaje a buzón de sistema.
    ###### to=id usr al que se envía el mensaje, from=Id usr del remitente
    /* ############################ Ejemplo (8 variables)
    EnviaMensajeAbuzon(
      'to',         ### id usr del destinatario
      'from',       ### id usr del remitente o 0 para sistema
      'asunto',     ### texto del asunto
      'mensaje,     ### <html> del mensaje
      'notas',      ### <html> de las notas
      'ifReply'     ### msj_id del mensaje al que se responde (o 0 para mensaje nuevo)
    );
    */ ############################## Fin del ejemplo

    ########################################################################
    ######### EnviaMensajeAbuzon: recibe datos, guarda el mensaje en la tabla
    ######### de buzón del usuario de destino. Luego revisa el correo
    ######### registrado en la tabla de usuario y le envía un correo electrónico.
    function EnviaMensajeAbuzon($to,$from,$asunto,$mensaje,$notas,$ifReply){
        ##### $to= id (tabla users) de usuario al que se le envía el msj
        ##### $from= id (tabla users) de quien envía
        ##### $asunto= texto de asunto
        ##### $mensaje= texto de mensaje
        ##### $notas= Texto de notas
        ##### $ifReply= buz_id del mensaje al que se está respondiendo (tabla buzon) o 0 para nuevo mensaje

        $error='0';
        ##### Verifica variables
        if($to=='' or $from=='' or $asunto=='' or $mensaje==''){
            $error++;
            return $error;
        }
        if(User::where('id',$to)->count() != '1' or User::where('id',$from)->count() != '1'){
            $error++;
            return $error;
        }

        ##### Prepara variables
        if($ifReply==''){$ifReply=null;}
        $fecha=date('Y-m-d');
        $hora=date('H:i:s');
        $para=User::where('id',$to)->first();

        $de=User::where('id',$from)->first();

        ###### Genera registro de BD de buzón
        $datos=[
            'buz_to'=>$to,
            'buz_from'=>$from,
            'buz_asunto'=>$asunto,
            'buz_mensaje'=>$mensaje,
            'buz_notas'=>$notas,
            'buz_replyTo'=>$ifReply,
            'buz_date'=>$fecha,
            'buz_hora'=>$hora,
        ];
        $nvo=buzon::create($datos);
        if(!$nvo){$error++;}

        ##### Verifica si usr tiene envío de correos:
        if($para->mensajes=='1'){
            ###### Prepara datos para el mensaje
            $Data=[
                'datos'=>$datos,
                'de'=>$de,
                'para'=>$para,
            ];
            ##### Envía correo
            $sale=Mail::to($para->email)->send(new CorreoPorAvisoDeBuzon($Data));

            #### Lo indica en la base de datos
            $nvo2=buzon::where('buz_id',$nvo->buz_id)->update([
                'buz_mailed'=>$para->email,
            ]);
            ##### Actualiza datos de sesión:
            $buzon= buzon::where('buz_del','0')
                ->where('buz_act','1')
                ->where('buz_to',Auth::user()->id)
                ->count();
            session([
                'buzon'=>$buzon,
            ]);
        }
        ###### Si todo fue ok, manda mensaje $error='0'
        return $error;
    }
}

if(!function_exists('EnviaMensajeAmail')){
    ########################################################################
    ######### EnviaMensajeAmail: recibe textos y envía mensaje al correo
    ######### del caut_id de la tabla cat_autores
    ######### $CatAutorId = caut_id de catálogo de autores
    ######### $asunto = texto del asunto
    ######### $mensaje = texto del mensaje
    ######### $notas = texto de las notas
    function EnviarMensajeAmail($CatAutorId, $asunto, $mensaje, $notas){
        $error='0';
        $para=cat_autores::where('caut_id', $CatAutorId)->first();

        ##### Verifica variables
        if(is_null($para) or $para->caut_correo=='' or !filter_var($para->caut_correo, FILTER_VALIDATE_EMAIL) or $asunto=='' or $mensaje==''){
            $error++;
            return $error;
        }

        ##### Verifica si usr tiene envío de correos:
        if($para->caut_correo != ''){
            ###### Prepara datos para el mensaje
            $Data=[
                'para'=>$para,
                'asunto'=>$asunto,
                'mensaje'=>$mensaje,
                'notas'=>$notas,
            ];
            ##### Envía correo

            Mail::to($para->caut_correo)->send(new CorreoPorAvisoDeMail($Data));
        }
        ###### Si todo fue ok, manda mensaje $error='0'
        return $error;
    }
}
