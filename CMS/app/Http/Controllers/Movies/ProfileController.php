<?php

namespace App\Http\Controllers\Movies;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Movies\Profile;

use Redirect;
use DB;
use Response;
use Datatables;

class ProfileController extends Controller
{
    private $request;
	
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
		
    public function index(Request $request)
	{
		$_SESSION['maintitle'] = 'Profile';
		$step = '0';
		
		return view('Movies.profile', compact('step'));	
    }

	public function getData()
    {
		$_SESSION['maintitle'] = 'Setup';
		$profile = Profile::find(1);	
		return view('Movies.profile', compact('profile'));
    }
	
    public function create()
    {
		
    }
	
    public function store(Request $request)
    {
		
		
		return back()->with('error', $message)->withInput();		
    }
	
	public function createData(Request $request)
	{
		$input = $request->except(['id']);
		
		try {
			$model = Profile::create($input);
		} catch(PDOException $e){
		   return Response::json($model);
		}	
		
		return Response::json($model);			
	}

    public function show($id)
    {
		$model = Profile::find($id);	
		/* $model = DB::table('movies as m')
		->join('category as c', 'c.id', '=', 'm.cid')
		->select('m.*', 'c.name as cname')
		->orderby('created_at','DESC')
		->where('m.id','$id')
		->first(); */
		
		return Response::json($model);
    }

    public function edit($id)
    {
		
    }

	public function updateData(Request $request)
	{
		$id = $request->get('id', '0');
		
		$input = $request->all();
		
		$model = Profile::find($id);
		if( !empty($model) )
			$model->update($input);
		
		return Response::json($model);			
	}
	
    public function update(Request $request, $id)
    {
		$input = $request->all();
		
		$model = Profile::find($id);
			
		if( empty($model) )
			$model->update($input);
		
		return Response::json($model);			
    }

    public function destroy($id)
    {
		$model = Profile::find($id);
		$model->delete();
		
		return Response::json($model);				
    }	
}
