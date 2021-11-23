<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StoreController extends Controller
{
    const NAME_SUBJECT1 = 'Store';
    const NAME_SUBJECT2 = 'Stores';

    /*
    public function __construct()
    {
        $this->middleware('auth');
    }
    */


    public function index(Request $request)
    {
        $filter = $request->filter;
        if ($filter){
            $keysFilter = explode(',' , $filter);
            $values = explode(',' , $request->valuefilter);
            $arrayFilter = array_combine($keysFilter,$values);
        }else{
            $arrayFilter = [];
        }

        $stores = Store::where($arrayFilter)->get();
        return $this->customResponse(true, $stores, $stores? 200 : 400,
            $this::NAME_SUBJECT2.($stores?' Consulta exitosa': ' No hay registros')
        );

    }

    public function store(Request $request)
    {
        if($request->massive) {
            $result = Store::insert($request->input('data', null));
            return response(['status' => $result ? 200 : 400, 'message' => $result?'Inserccion ok':'error'])
                ->header('Content-Type', 'application/json');
        }else {
            $arraySet = $request->input('data',null);
            $store =  Store::create($arraySet);
            $isSaved = $store->save();
            return $this->customResponse(false, $store, $isSaved? 200 : 400,
                $this::NAME_SUBJECT1.($isSaved?' Creado correctamente': ' No fue creado')
            );
        }
    }

    public function show($id,Request $request)
    {
        $filter = $request->filter;
        if ($filter){
            $keysFilter = explode(',' , $filter);
            $values = explode(',' , $request->valuefilter);
            $arrayFilter = array_combine($keysFilter,$values);
        }else{
            $arrayFilter = ['id' => $id];
        }

        $store = Store::where($arrayFilter)->first();
        return $this->customResponse(true, $store, $store? 200 : 400,
            $this::NAME_SUBJECT1.($store?' Consulta exitosa': ' No hay registros')
        );
    }

    public function update($id,Request $request)
    {
        $filter = $request->filter;
        if ($filter && $request->massive){
            $keysFilter = explode(',' , $filter);
            $values = explode(',' , $request->valuefilter);
            $arrayFilter = array_combine($keysFilter,$values);
        }else{
            $arrayFilter = ['id' => $id];
        }
        $dataReq = $request->input('data',null);
        $affected = Store::where($arrayFilter)->update($dataReq);
        $response = $this->customResponse(false, Store::find($id), $affected? 200 : 400,
            $affected.' '.$this::NAME_SUBJECT1.($affected?' Actualizado correctamente': ' No fue actualizado')
        );

        return $response;
    }

    public function destroy($id)
    {
        $store = Store::find($id);
        if ($store){
            $result = $store->delete();
            return $this->customResponse(false, $store, $result? 200 : 400,
                $result.' '.$this::NAME_SUBJECT1.($result?' Eliminado correctamente': ' No fue Eliminado')
            );
        }else{
            return response(['status' => 400, 'message' => 'No existe registro'], 400)
                ->header('Content-Type', 'application/json');
        }
    }

    protected function customResponse($showData,$resultSet,$codeStatus,$msg)
    {
        $dataResult = $resultSet? $resultSet->toArray(): 'No existen datos con ese id';
        $dataResponse = [
            'status' => $codeStatus==200? 'success':'error',
            'code' => $codeStatus,
            'message' => $msg,
            'records' => $showData? $dataResult :
                ['id' => $resultSet->id]
        ];
        return response($dataResponse, $codeStatus==200? 200 : 400)
            ->header('Content-Type', 'application/json');
    }

}
