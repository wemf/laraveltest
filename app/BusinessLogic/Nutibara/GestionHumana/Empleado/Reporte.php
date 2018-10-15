<?php

namespace App\BusinessLogic\Nutibara\GestionHumana\Empleado;
use App\AccessObject\Nutibara\GestionHumana\Empleado\Reporte AS ReporteAccess;
use config\messages;
use App\BusinessLogic\Nutibara\Excel\PlantillaEmpleado;


class Reporte 
{

    public static function getselectlistEstadoCivil()
    {
        return ReporteAccess::getselectlistEstadoCivil();
    }

    public static function getselectlistTenenciaVivienda()
    {
        return ReporteAccess::getselectlistTenenciaVivienda();
    }

    public static function getselectlistTipoVivienda()
    {
        return ReporteAccess::getselectlistTipoVivienda();
    }

    public static function getselectlistTipoEstudio()
    {
        return ReporteAccess::getselectlistTipoEstudio();
    }

    public static function getselectlistMotivoRetiro()
    {
        return ReporteAccess::getselectlistMotivoRetiro();
    }

    public static function getselectlistTipoDocumento()
    {
        return ReporteAccess::getselectlistTipoDocumento();
    }

    public static function exportExcel($dataGet)
    {
        $plantillaEmpleado=new PlantillaEmpleado();
        return $plantillaEmpleado->ExportExcel($dataGet);
    }


    public static function get($request)
    {
        $dataQuery = [
            'nombre'=>$request->nombre,
            'primerApellido'=>$request->primerApellido,
            'segundoApellido'=>$request->segundoApellido,
            'tipoCedula'=>$request->tipoCedula,
            'cedula'=>$request->cedula,
            'estadoCivil'=>$request->estadoCivil,
            'personasCargoMin'=>$request->personasCargoMin,
            'personasCargoMax'=>$request->personasCargoMax,
            'hijosMin'=>$request->hijosMin,
            'hijosMax'=>$request->hijosMax,
            'rangoEdadMin'=>$request->rangoEdadMin,
            'rangoEdadMax'=>$request->rangoEdadMax,
            'tipoVivienda'=>$request->tipoVivienda,
            'tenenciaVivienda'=>$request->tenenciaVivienda,
            'tipoEstudio'=>$request->tipoEstudio,
            'fechaEstudioMin'=>$request->fechaEstudioMin,
            'fechaEstudioMax'=>$request->fechaEstudioMax,
            'estadoEstudio'=>$request->estadoEstudio,
            'cargo'=>$request->cargo,
            'salarioMin'=>$request->salarioMin,
            'salarioMax'=>$request->salarioMax,
            'auxilioTransporte'=>$request->auxilioTransporte,
            'retirado'=>$request->retirado,
            'fechaRetiroMin'=>$request->fechaRetiroMin,
            'fechaRetiroMax'=>$request->fechaRetiroMax,
            'motivoRetiro'=>$request->motivoRetiro,
            'familiaEmpresa'=>$request->familiaEmpresa,
            'rangoFamiliaresMin'=>$request->rangoFamiliaresMin,
            'rangoFamiliaresMax'=>$request->rangoFamiliaresMax,
            'infoDetalladaHijos'=>$request->infoDetalladaHijos,
            'infoDetalladaPersonasCargo'=>$request->infoDetalladaPersonasCargo,
            'infoDetalladaFamiliaEmpresa'=>$request->infoDetalladaFamiliaEmpresa,
            'nulo'=>$request->nulo,
        ];
        $retorno = [];
        //Comparar fechas contra las edades, auxilio de transporte
        if($dataQuery['nulo'] == 2){
            $retorno['info'] = ReporteAccess::getAll();
            $retorno['children'] = '';
            $retorno['dependents'] = '';
            $retorno['nutyFamily'] = '';
            return $retorno;
        }else{
            $info = ReporteAccess::getAllFull($dataQuery);
            $retorno['info']=$info;
            $contLL=0;
            $contV=0;
            for ($i=0;$i<count($info);$i++){
                $id_tienda=$info[$i]->id_tienda;
                $id_cliente=$info[$i]->id_cliente;
                $name_employee=$info[$i]->nombres;
                $last_name_employee=$info[$i]->apellidos;
                if ($dataQuery['infoDetalladaHijos'] == 'Si'){
                    $retorno['children']=  ReporteAccess::getInfoChildren($id_tienda,$id_cliente,$name_employee,$last_name_employee);
                }else{
                    $retorno['children']='';
                }
                if ($dataQuery['infoDetalladaPersonasCargo'] == 'Si'){                         
                    $retorno['dependents']= ReporteAccess::getInfoDependents($id_tienda,$id_cliente,$name_employee,$last_name_employee);
                }else{
                    $retorno['dependents']='';
                }
                if ($dataQuery['infoDetalladaFamiliaEmpresa'] == 'Si'){
                    $retorno['nutyFamily']= ReporteAccess::getInfoNutiFamily($id_tienda,$id_cliente,$name_employee,$last_name_employee);
                }else{
                    $retorno['nutyFamily']='';
                }
            }
            return $retorno;
        }
    }
}