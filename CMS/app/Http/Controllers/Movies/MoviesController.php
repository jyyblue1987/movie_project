<?php

namespace App\Http\Controllers\Movies;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\Common\Department;
use App\Models\Movies\Category;
use App\Models\Movies\Movies;

use Redirect;
use DB;
use Response;
use Datatables;

class MoviesController extends Controller
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
			Movies::whereIn('id', $ids)->delete();			
			return back()->withInput();				
		} 
		$_SESSION['maintitle'] = 'Movies';
		$category = Category::lists('name', 'id');
		$step = '0';
		
		return view('Movies.movies', compact('category', 'step'));	
    }

	public function getGridData()
    {
		$datalist = DB::table('movies as m')
		->leftjoin('category as c', 'c.id', '=', 'm.cid')
		->select(['m.*', 'c.name as cname'])
		->orderby('created_at','DESC');
		return Datatables::of($datalist)
				->addColumn('checkbox', function ($data) {
					return '<input type="checkbox" class="checkthis" />';
				})
				->addColumn('edit', function ($data) {
					return '<p data-placement="top" data-toggle="tooltip" title="Edit"><button class="btn btn-primary btn-xs" data-title="Edit" data-toggle="modal" data-target="#addModal"  onClick="onShowEditRow('.$data->id.')">
						<span class="glyphicon glyphicon-pencil"></span>
					</button></p>';
				})
				->editColumn('path', function ($data) {
					return '<a href="'.$data->path.'" style="text-decoration: none;" target="_blank()">'.$data->path.'</a>';
				})
				->editColumn('thumb', function ($data) {
					return '<a href="'.$data->thumb.'" style="text-decoration: none;" target="_blank()"><img src="/images/uploads/'.$data->thumb.'" width="50px" height="30px"></a>';
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
			$model = Movies::create($input);
		} catch(PDOException $e){
		   return Response::json($model);
		}	
		
		return Response::json($model);			
	}

    public function show($id)
    {
		$model = Movies::find($id);	
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
		
		$model = Movies::find($id);
		if( !empty($model) )
			$model->update($input);
		
		return Response::json($model);			
	}
	
    public function update(Request $request, $id)
    {
		$input = $request->all();
		
		$model = Movies::find($id);
			
		if( empty($model) )
			$model->update($input);
		
		return Response::json($model);			
    }

    public function destroy($id)
    {
		$model = Movies::find($id);
		$model->delete();
		
		return Response::json($model);				
    }	
}
