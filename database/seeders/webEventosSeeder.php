<?php

namespace Database\Seeders;

use App\Models\WebEventosModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class webEventosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hoy = date('Y-m-d');
        $futuro=date('Y-m-d', strtotime('+5 days'));
        $past=date('Y-m-d', strtotime('-10 days'));


        $events=[
            [
                'wwevs_titulo'=>'Estimados visitantes, durante las fuestas  de día de muertos',
                'wwevs_descrip'=>'Les solicitamos llegar con 10 minutos de antelación para evitar largas filas de entrada.',
                // 'wwevs_descrip2'=>'',
                'wwevs_label'=>'Comunicado',
                'wwevs_lugar'=>'Jardín Etnobiológico de Oaxaca',
                'wwevs_dateini'=>'2024-11-1',
                'wwevs_datefin'=>'2024-11-2',
                'wwevs_timeini'=>'10:00',
                // 'wwevs_timefin'=>'',
                'wwevs_costo'=>'Actividad gratuita',
                'wwevs_img'=>'/imagenes/eventos/evento.png'
            ],[
                'wwevs_titulo'=>'Día Nacional de los Jardines Botánicos 2023',
                'wwevs_descrip'=>'El Jardín Etnobotánico de Oaxaca te invita a celebrar el sábado 8 de julio el Día Nacional de los Jardines Botánicos 2023.',
                // 'wwevs_descrip2'=>'',
                'wwevs_label'=>'Conferencia,Recorrido,Taller',
                'wwevs_lugar'=>'Jardín Etnobiológico de Oaxaca',
                'wwevs_dateini'=>'2023-07-08',
                'wwevs_datefin'=>'2023-07-08',
                'wwevs_timeini'=>'10:00',
                // 'wwevs_timefin'=>'',
                'wwevs_costo'=>'Actividad gratuita',
                'wwevs_img'=>'/imagenes/eventos/230708_DiaNalJardinesBots.jpg'
            ],[
                'wwevs_titulo'=>'Gonfoterios, palabras prestadas y cacao: la jícara en Mesoamérica',
                'wwevs_descrip'=>'El Jardín Etnobiológico de Oaxaca Te invita a la conferencia: «Gonfoterios, palabras prestadas y cacao: la jícara en Mesoamérica»',
                'wwevs_descrip2'=>'Impartido por: Dra. Xitlali Aguirre Dugua, investigadora por México.',
                'wwevs_label'=>'Conferencia',
                'wwevs_lugar'=>'Biblioteca del Jardín Etnobiológico de Oaxaca',
                'wwevs_dateini'=>'2024-08-25',
                'wwevs_datefin'=>'2024-08-25',
                'wwevs_timeini'=>'18:00',
                'wwevs_timefin'=>'19:00',
                'wwevs_costo'=>'Actividad gratuita',
                'wwevs_img'=>'/imagenes/eventos/240825_ConfGonfoteriosXitlali.jpg'
            ],[
                'wwevs_titulo'=>'Noche de museos en el Jardín Etnobiológico, recorrido nocturno',
                'wwevs_descrip'=>'Ven a conocer el Jardín, por la noche.',
                // 'wwevs_descrip2'=>'',
                'wwevs_label'=>'Recorrido',
                'wwevs_lugar'=>'Jardín Etnobiológico de Oaxaca',
                'wwevs_dateini'=>'2024-08-25',
                'wwevs_datefin'=>'2024-08-25',
                'wwevs_timeini'=>'19:00',
                'wwevs_timefin'=>'20:30',
                'wwevs_costo'=>'Actividad gratuita',
                'wwevs_img'=>'/imagenes/eventos/240825_NocheDeMuseos.jpg'
            ],
            [
                'wwevs_titulo'=>'Noche de museos en el Jardín Etnobiológico de Oaxaca', ///// INVENTADO
                'wwevs_descrip'=>'Ven a conocer nuestros recorridos nocturnos.',
                'wwevs_descrip2'=>'',
                'wwevs_label'=>'Recorrido',
                'wwevs_lugar'=>'Jardín Etnobiológico de Oaxaca',
                'wwevs_dateini'=>date('Y-m-d', strtotime('+20 days')),
                'wwevs_datefin'=>date('Y-m-d', strtotime('+20 days')),
                'wwevs_timeini'=>'6:00',
                'wwevs_timefin'=>'8:00',
                'wwevs_costo'=>'Actividad gratuita',
                // 'wwevs_img'=>'/imagenes/eventos/240825_NocheDeMuseos.jpg'
            ],[
                'wwevs_titulo'=>'El Barbasco: una planta oaxaqueña que cambió la historia mundial',
                'wwevs_descrip'=>'Ven a escuchar una interesante historia, contada por un especialista en este género.',
                'wwevs_descrip2'=>'Impartida por el Dr. Oswaldo Tellez. FES Iztacala, UNAM.',
                'wwevs_label'=>'Conferencia',
                'wwevs_lugar'=>'Biblioteca del Jardín Etnobiológico de Oaxaca',
                'wwevs_dateini'=>'2024-10-04',
                'wwevs_datefin'=>'2024-10-04',
                'wwevs_timeini'=>'18:00',
                // 'wwevs_timefin'=>'',
                'wwevs_costo'=>'Actividad gratuita',
                'wwevs_img'=>'/imagenes/eventos/241004_BarbascoTellez.png'
            ],[
                'wwevs_titulo'=>'Concierto clásico un sauce de cristal',
                'wwevs_descrip'=>'Ven a escuchar música clásica en piano con Ezequiel Nushpian Caballero.',
                'wwevs_descrip2'=>'',
                'wwevs_label'=>'Cultural',
                'wwevs_lugar'=>'Jardín Etnobiológico de Oaxaca',
                'wwevs_dateini'=>'2024-10-22',
                'wwevs_datefin'=>'2024-10-22',
                'wwevs_timeini'=>'18:00',
                // 'wwevs_timefin'=>'',
                'wwevs_costo'=>'Actividad gratuita',
                'wwevs_img'=>'/imagenes/eventos/241022_ConciertoUnSauceDeCristal.jpg'
            ],[
                'wwevs_titulo'=>'Noche de museos en el Jardín Etnobiológico de Oaxaca.',
                'wwevs_descrip'=>'Ven con nosotros este último vierenes del mes de octubre a nuestros recorridos nocturnos por el Jardín.',
                'wwevs_descrip2'=>'',
                'wwevs_label'=>'Recorrido',
                'wwevs_lugar'=>'Jardín Etnobiológico de Oaxaca',
                'wwevs_dateini'=>'2024-10-25',
                'wwevs_datefin'=>'2024-10-25',
                'wwevs_timeini'=>'19:00',
                'wwevs_timefin'=>'20:00',
                'wwevs_costo'=>'Actividad gratuita',
                'wwevs_img'=>'/imagenes/eventos/241025_NocheDeMuseos.png'
            ],[
                'wwevs_titulo'=>'Semana de los murciélagos',
                'wwevs_descrip'=>'Asiste a nuestro recorrido nocturno de la noche de museos dedicado a los murciélagos que visitan el Jardín',
                'wwevs_descrip2'=>'',
                'wwevs_label'=>'Recorrido',
                'wwevs_lugar'=>'Jardín Etnobiológico de Oaxaca',
                'wwevs_dateini'=>'2024-10-25',
                'wwevs_datefin'=>'2024-10-24',
                'wwevs_timeini'=>'19:00',
                'wwevs_timefin'=>'20:00',
                'wwevs_costo'=>'Actividad gratuita',
                'wwevs_img'=>'/imagenes/eventos/241026_FestejaAlosMurcielagosRecorrido.jpeg'
            ],[
                'wwevs_titulo'=>'Conferencias de la semana de los murciélagos',
                'wwevs_descrip'=>'Ven a conocer aspectos interesantes sobre los murciélagos.',
                'wwevs_descrip2'=>'',
                'wwevs_label'=>'Conferencia',
                'wwevs_lugar'=>'Biblioteca del Jardín Etnobiológico de Oaxaca',
                'wwevs_dateini'=>'2024-10-26',
                'wwevs_datefin'=>'2024-10-26',
                'wwevs_timeini'=>'10:00',
                'wwevs_timefin'=>'13:00',
                'wwevs_costo'=>'Actividad gratuita',
                'wwevs_img'=>'/imagenes/eventos/241026_FestejaAlosMurcielagosConferencia.jpeg'
            ],[
                'wwevs_titulo'=>'Buen Luto Mx. Oaxaca / Izumo Japón 2024',
                'wwevs_descrip'=>'Proyección y performance de dos mundos unidos por nuestros muertos',
                'wwevs_descrip2'=>'Hanae Utamura y Shinya Watanabe (Japón)',
                'wwevs_label'=>'Cultural',
                'wwevs_lugar'=>'Plazuela del Jardín Etnobotánico de Oaxaca',
                'wwevs_dateini'=>'2024-10-31',
                'wwevs_datefin'=>'2024-10-31',
                'wwevs_timeini'=>'19:30',
                'wwevs_timefin'=>'20:30',
                'wwevs_costo'=>'Actividad gratuita',
                'wwevs_img'=>'/imagenes/eventos/241031_BuenLutoJapon.jpeg'
            ],[
                'wwevs_titulo'=>'Salud y desigualdades en el Anntropoceno: herramientas para entender y navegar la crisis',
                'wwevs_descrip'=>'Presentación de la plataforma digital embodiedanthropocene.com',
                'wwevs_descrip2'=>'',
                'wwevs_label'=>'Presentación',
                'wwevs_lugar'=>'Biblioteca del Jardín Etnobiológico de Oaxaca',
                'wwevs_dateini'=>'2024-11-15',
                'wwevs_datefin'=>'2024-11-15',
                'wwevs_timeini'=>'18:00',
                // 'wwevs_timefin'=>'',
                'wwevs_costo'=>'Actividad gratuita',
                'wwevs_img'=>'/imagenes/eventos/241115_PresentaPlataformaSalud.png'
            ]

        ];

        if(WebEventosModel::count()=='0'){
            foreach ($events as $event){
                ##### En producción
                WebEventosModel::create($event);
            }
        }
    }
}
