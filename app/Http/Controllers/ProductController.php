<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProductController extends Controller
{
    const NAME_SUBJECT1 = 'Product';
    const NAME_SUBJECT2 = 'Products';

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

        $products = Product::where($arrayFilter)->get();
        return $this->customResponse(true, $products, $products? 200 : 400,
            $this::NAME_SUBJECT2.($products?' Consulta exitosa': ' No hay registros')
        );

    }

    public function store(Request $request)
    {
        if($request->massive) {
            $result = Product::insert($request->input('data', null));
            return response(['status' => $result ? 200 : 400, 'message' => $result?'Inserccion ok':'error'])
                ->header('Content-Type', 'application/json');
        }else {
            $arraySet = $request->input('data',null);
            $product =  Product::create($arraySet);
            $isSaved = $product->save();
            return $this->customResponse(false, $product, $isSaved? 200 : 400,
                $this::NAME_SUBJECT1.($isSaved?' Creado correctamente': ' No fue creado')
            );
        }
    }

    public function show($id,Request $request)
    {
        if(Auth::check())
            return Auth::product();
        else
            return 'logeado';
        $filter = $request->filter;
        if ($filter){
            $keysFilter = explode(',' , $filter);
            $values = explode(',' , $request->valuefilter);
            $arrayFilter = array_combine($keysFilter,$values);
        }else{
            $arrayFilter = ['id' => $id];
        }

        $product = Product::where($arrayFilter)->first();
        return $this->customResponse(true, $product, $product? 200 : 400,
            $this::NAME_SUBJECT1.($product?' Consulta exitosa': ' No hay registros')
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
        $dataReq && isset($dataReq['password']) ? $dataReq['password'] = Hash::make($dataReq['password']): null;
        $affected = Product::where($arrayFilter)->update($dataReq);
        $response = $this->customResponse(false, Product::find($id), $affected? 200 : 400,
            $affected.' '.$this::NAME_SUBJECT1.($affected?' Actualizado correctamente': ' No fue actualizado')
        );

        return $response;
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if ($product){
            $result = $product->delete();
            return $this->customResponse(false, $product, $result? 200 : 400,
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
