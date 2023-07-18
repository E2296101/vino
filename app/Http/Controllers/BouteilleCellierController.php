<?php

namespace App\Http\Controllers;

use App\Models\BouteilleCellier;
use App\Models\Cellier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function PHPUnit\Framework\isNull;

class BouteilleCellierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $test = BouteilleCellier::where('cellier_id','=',$request->cellier_id)->where('bouteille_id','=',$request->bouteille_id);
        if($test->count()==0){
            $celliers = BouteilleCellier::create([
                'cellier_id'=>$request->cellier_id,
                'bouteille_id'=>$request->bouteille_id,
                'quantite'=>$request->quantite,
                'note'=>'',
            ]);
        }
        else{
           $celliers = BouteilleCellier::where('cellier_id', $request->cellier_id)
                ->where('bouteille_id', $request->bouteille_id)
                ->update(['quantite' => $test->first()->quantite + $request->quantite]);
        }
        // pour tester si je viens d'index & retourné message succès echec
        if(isset($request->vue_source) &&  $request->vue_source == "index"){
            if($celliers)
             return response()->json(['message' => 'Ajout avec succès']);
            else
             return response()->json(['message' => 'Echec d\'ajout']);
        } 
           
        else
        return redirect()->route('celliers.show',$request->cellier_id)->with('success','success');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cellier_id = Cellier::find(BouteilleCellier::find($id)->first()->cellier_id);
        BouteilleCellier::destroy($id);
        return redirect()->route('celliers.show',$cellier_id)->with('success','delete');

    }

    public function updateQuantite(Request $request)
    {

        $data = $request->all();

        $quantite=$data["quantite"];
        $id=$data["idcb"]["_value"];

        BouteilleCellier::where('id','=',$id) //
            ->update(['quantite' => $quantite]);

        $cellier_id = BouteilleCellier::find($id)->first()->cellier_id;


        return response()->json(['success' => 'update', 'cellier_id' => $cellier_id]);
    }

    
}
