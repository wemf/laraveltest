<?php

namespace App\Http\Controllers\Nutibara\GestionHumana\Empleado;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BusinessLogic\Nutibara\GestionHumana\Empleado\Reporte;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;


class ReporteController extends Controller
{
    public function Index(){
        return view('GestionHumana.Empleado.Reporte.index');
    }

    public function getselectlistEstadoCivil()
    {
        $msn = Reporte::getselectlistEstadoCivil();
        return response()->json($msn);
    }

    public function getselectlistTenenciaVivienda()
    {
        $msn = Reporte::getselectlistTenenciaVivienda();
        return response()->json($msn);
    }

    public function getselectlistTipoVivienda()
    {
        $msn = Reporte::getselectlistTipoVivienda();
        return response()->json($msn);
    }

    public function getselectlistTipoEstudio()
    {
        $msn = Reporte::getselectlistTipoEstudio();
        return response()->json($msn);
    }

    public function getselectlistMotivoRetiro()
    {
        $msn = Reporte::getselectlistMotivoRetiro();
        return response()->json($msn);
    }

    public function getselectlistTipoDocumento()
    {
        $msn = Reporte::getselectlistTipoDocumento();
        return response()->json($msn);
    }

    public function exportExcel(request $request)
    {
        
        $req = [
            'nombre'=>Route::getFacadeRoot()->current()->nombre,  
            'primerApellido'=>Route::getFacadeRoot()->current()->primerApellido,
            'segundoApellido'=>Route::getFacadeRoot()->current()->segundoApellido,
            'tipoCedula'=>Route::getFacadeRoot()->current()->tipoCedula,
            'cedula'=>Route::getFacadeRoot()->current()->cedula,
            'estadoCivil'=>Route::getFacadeRoot()->current()->estadoCivil,
            'personasCargoMin'=>Route::getFacadeRoot()->current()->personasCargoMin,
            'personasCargoMax'=>Route::getFacadeRoot()->current()->personasCargoMax,
            'hijosMin'=>Route::getFacadeRoot()->current()->hijosMin,
            'hijosMax'=>Route::getFacadeRoot()->current()->hijosMax,
            'rangoEdadMin'=>Route::getFacadeRoot()->current()->rangoEdadMin,
            'rangoEdadMax'=>Route::getFacadeRoot()->current()->rangoEdadMax,
            'tipoVivienda'=>Route::getFacadeRoot()->current()->tipoVivienda,
            'tenenciaVivienda'=>Route::getFacadeRoot()->current()->tenenciaVivienda,
            'tipoEstudio'=>Route::getFacadeRoot()->current()->tipoEstudio,
            'fechaEstudioMin'=>Route::getFacadeRoot()->current()->fechaEstudioMin,
            'fechaEstudioMax'=>Route::getFacadeRoot()->current()->fechaEstudioMax,
            'estadoEstudio'=>Route::getFacadeRoot()->current()->estadoEstudio,
            'cargo'=>Route::getFacadeRoot()->current()->cargo,
            'salarioMin'=>Route::getFacadeRoot()->current()->salarioMin,
            'salarioMax'=>Route::getFacadeRoot()->current()->salarioMax,
            'auxilioTransporte'=>Route::getFacadeRoot()->current()->auxilioTransporte,
            'retirado'=>Route::getFacadeRoot()->current()->retirado,
            'fechaRetiroMin'=>Route::getFacadeRoot()->current()->fechaRetiroMin,
            'fechaRetiroMax'=>Route::getFacadeRoot()->current()->fechaRetiroMax,
            'motivoRetiro'=>Route::getFacadeRoot()->current()->motivoRetiro,
            'familiaEmpresa'=>Route::getFacadeRoot()->current()->familiaEmpresa,
            'rangoFamiliaresMin'=>Route::getFacadeRoot()->current()->rangoFamiliaresMin,
            'rangoFamiliaresMax'=>Route::getFacadeRoot()->current()->rangoFamiliaresMax,
            'infoDetalladaHijos'=>Route::getFacadeRoot()->current()->infoDetalladaHijos,
            'infoDetalladaPersonasCargo'=>Route::getFacadeRoot()->current()->infoDetalladaPersonasCargo,
            'infoDetalladaFamiliaEmpresa'=>Route::getFacadeRoot()->current()->infoDetalladaFamiliaEmpresa,
            'nulo'=>Route::getFacadeRoot()->current()->nulo,
        ];       
        return Reporte::exportExcel($req);
    }

    public function get(Request $request)
    {
        $msn=Reporte::get($request);
        $a=array('msn'=>$msn);
        return response()->json($a);
    }
}