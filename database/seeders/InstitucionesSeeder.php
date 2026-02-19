<?php

namespace Database\Seeders;

use App\Models\InstitucionesModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InstitucionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events =[
            'Ninguna',
            'Jardín Etnobiológico de Oaxaca',
            'Jardín Etnobiológico de la Ciudad de México',
            'Jardín Etnobiológico de Campeche',
            'Jardín Etnobiológico de Tlaxcalla',
            'Jardín Etnobiológico de Guanajuato',
            'Jardín Etnobiológico de San Felipe Bacalar',
            'Jardín Etnobiológico de la Universidad Autónoma de Nuevo León',
            'Jardín Etnobiológico Juyya Ánnia',
            'Jardín Etnobiológico Estatal de Durango',
            'Jardín Etnobiológico de Jalisco',
            'Jardín Botánico Francisco Javier Clavijero',
            'Renatura Sonora Jardín Etnobiológico Comunitario',
            'Jardín Etnobiológico de San Luis Potosí',
            'Jardín Etnobiológico del Semidesierto de Coahuila',
            'Jardín Etnobiológico de Concá',
            'Jardín Etnobiológico de Baja California Sur',
            'Jardín Etnobiológico La Campana',
            'Jardín Etnobiológico y Museo de Medicina Tradicional',
            'Jardín Etnobiológico Regional Roger Orellana',
            'Jardín Etnobiológico de los 7 pueblos originarios del estado de Puebla',
            'Jardín Etnobiológico de las Selvas del Soconusco JESS',
            'Jardín Etnobiológico de la Universidad Autónoma de Guerrero',
            'Jardín Etnobiológico Tachii de Nayarit',
            'Jardín Etnobiológico Totláli',
            'Jardín Botánico de la UNAM',
            'Jardín Botánico de la Universidad Autónoma de Aguascalientes',
            'Jardín Botánico de la Universidad Autónoma de Baja California',
            'Jardín Botánico de la Universidad Autónoma de Campeche',
            'Jardín Botánico Regional Carmen',
            'Jardín Botánico de la Facuñltad de Ciencias Agronomicas UACh',
            'Jardín Botánico de El Soconusco ECOSUR',
            'Jardín Botánico Dr Faustino miranda ',
            'Jardín Botánico del Centro de Información y Comunicación Ambiental de Norteamerica',
            'Jardín Botánico de Plantas Aromáticas y Mediicnales UAM Xochimilco',
            'Jardín Botánico Jerzy Rzedowski Rotter UAAAN ',
            'Jardín Botánico de la Fundción Xochitla',
            'Jardín Botánico de la FES Cuahutitlán, UNAM',
            'Jardín Botánico El Charco del Ingenio',
            'Jardín Botánico del CELE UNAM',
            'Jardín Botánico de la Universidad Autónoma de Guerrero',
            'Jardín Botánico Esther Pliego de Salinas de Acapulco',
            'Jardín Botánico Efraín Hernandez Xolocotzi',
        ];

        if(InstitucionesModel::count()=='0'){
            foreach ($events as $event){
                InstitucionesModel::create(['cins_institucion'=>$event]);
            }
        }
    }
}
