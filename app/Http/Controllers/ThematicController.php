<?php 

namespace App\Http\Controllers;

use App\Thematic;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request; 

class ThematicController extends Controller {

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index(Request $request)
  {
      $thematics = Thematic::orderBy('order', 'ASC')->get();
      return response()->json($thematics);
  }


  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store()
  { 
        $rules = array(
            'name'          => 'required|min:3|unique:thematic',
            'order'         => 'required',
            'slug'          => 'required'
        );

        $messages = [
            'name.required' => "Le nom de la thématique est nécessaire.",
            'name.min' => "Le nom doit être plus grand que 3 caractères.",
            'name.unique' => "Ce nom de thématique existe déjà",
            'order.required' => "Cette thématique n'a aucun ordre ?",
            'slug.required' => "Ca marchera vachement moins bien sans un slug !"
        ];

        $this->validate($request, $rules, $messages);

        $thematic = Thematic::create($request->all());

        

        return response()->json(new TeamResource($team));


  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {
    
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update($id)
  {
    
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id)
  {
    
  }
  
}

?>