<?php

namespace App\Http\Controllers\Movies;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\Common\Department;
use App\Models\Movies\Country;

use Redirect;
use DB;
use Response;
use Datatables;

class CountryController extends Controller
{
    private $request;
	
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
		
    public function index(Request $request)
	{
		// delete action
		$ids = $request->input('ids');
		if( !empty($ids) )
		{
			Country::whereIn('id', $ids)->delete();			
			return back()->withInput();				
		} 
		$_SESSION['maintitle'] = 'Category';
		
		$step = '0';
		
		return view('movies.country', compact('step'));	
    }

	public function getGridData()
    {
		$datalist = DB::table('country')->orderby('id','ASC');
		return Datatables::of($datalist)
				->addColumn('checkbox', function ($data) {
					return '<input type="checkbox" class="checkthis" />';
				})
				->addColumn('edit', function ($data) {
					return '<p data-placement="top" data-toggle="tooltip" title="Edit"><button class="btn btn-primary btn-xs" data-title="Edit" data-toggle="modal" data-target="#addModal"  onClick="onShowEditRow('.$data->id.')">
						<span class="glyphicon glyphicon-pencil"></span>
					</button></p>';
				})
				->addColumn('delete', function ($data) {
					return '<p data-placement="top" data-toggle="tooltip" title="Delete"><button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#deleteModal" onClick="onDeleteRow('.$data->id.')">
						<span class="glyphicon glyphicon-trash"></span>
					</button></p>';
				})				
				->make(true);
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
			$model = Country::create($input);
		} catch(PDOException $e){
		   return Response::json($model);
		}	
		
		return Response::json($model);			
	}

    public function show($id)
    {
		$model = Country::find($id);	
		
		return Response::json($model);
    }

    public function edit($id)
    {
		
    }

	public function updateData(Request $request)
	{
		$id = $request->get('id', '0');
		
		$input = $request->all();
		
		$model = Country::find($id);
			
		if( !empty($model) )
			$model->update($input);
		
		return Response::json($model);			
	}
	
    public function update(Request $request, $id)
    {
		$input = $request->all();
		
		$model = Country::find($id);
			
		if( empty($model) )
			$model->update($input);
		
		return Response::json($model);			
    }

    public function destroy($id)
    {
		$model = Country::find($id);
		$model->delete();
		
		return Response::json($model);				
    }	
}
