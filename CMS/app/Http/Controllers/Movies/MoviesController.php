<?php

namespace App\Http\Controllers\Movies;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\Common\Department;
use App\Models\Movies\Category;
use App\Models\Movies\Country;
use App\Models\Movies\Movies;

use Redirect;
use DB;
use Auth;
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
		$country = Country::lists('name', 'id');
		$step = '0';
		
		return view('movies.movies', compact('category', 'country', 'step'));	
    }

	public function getGridData()
    {
		$datalist = DB::table('movies as m')
		->leftjoin('category as cat', 'cat.id', '=', 'm.catid')
		->leftjoin('country as c', 'c.id', '=', 'm.cid')
		->select(['m.*', 'c.name as cname', 'cat.name as catname'])
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
				->editColumn('background', function ($data) {
					return '<a href="'.$data->background.'" style="text-decoration: none;" target="_blank()"><img src="'.$data->background.'" width="50px" height="30px"></a>';
				})
				->editColumn('thumb', function ($data) {
					return '<a href="'.$data->thumb.'" style="text-decoration: none;" target="_blank()"><img src="'.$data->thumb.'" width="50px" height="30px"></a>';
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
		$id = $request->get('id', 0);
		$cid = $request->get('cid', 0);
		$catid = $request->get('catid', 0);
		$name = $request->get('name', '');
		$desc = $request->get('desc', '');
		$path = $request->get('path', '');
		$model = new Movies();
		$model->cid = $cid;
		$model->catid = $catid;
		$model->name = $name;
		$model->desc = $desc;
		$model->path = $path;		
		$model->save();
		if($request->hasFile('thumb')){
			
			$file = $request->file('thumb');
			$filename = $file->getClientOriginalName();
			$file_url = $this->postAttached($file);
			$model->thumb = $file_url;
			$model->save();
		}
		if($request->hasFile('background')){
			
			$file = $request->file('background');
			$filename = $file->getClientOriginalName();
			$file_url = $this->postAttached($file);
			$model->background = $file_url;
			$model->save();
		}
		if($path == ''){
			if($request->hasFile('videofile')){			
				$file = $request->file('videofile');
				$filename = $file->getClientOriginalName();
				$file_url = $this->postAttached($file);
				$file_url = $_SERVER['DOCUMENT_ROOT'].$file_url;
				$model->path = $file_url;
				$model->save();
			}
		}
		$_SESSION['maintitle'] = 'Movies';
		$category = Category::lists('name', 'id');
		$country = Country::lists('name', 'id');
		$step = '0';
		
		return Redirect::to('/movies/movies');		
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
		$id = $request->get('id', 0);
		$cid = $request->get('cid', 0);
		$catid = $request->get('catid', 0);
		$name = $request->get('name', '');
		$desc = $request->get('desc', '');
		$path = $request->get('path', '');
		$model = DB::table('movies')->where('id', $id)->update(['cid'=>$cid,'catid'=>$catid,'name'=>$name,'desc'=>$desc,'path'=>$path]);
			
		if($request->hasFile('thumb')){
			
			$file = $request->file('thumb');
			$filename = $file->getClientOriginalName();
			$file_url = $this->postAttached($file);
			DB::table('movies')->where('id', $id)->update(['thumb'=>$file_url]);
		}
		if($request->hasFile('background')){
			
			$file = $request->file('background');
			$filename = $file->getClientOriginalName();
			$file_url = $this->postAttached($file);
			DB::table('movies')->where('id', $id)->update(['background'=>$file_url]);
		}
		if($path == ''){
			if($request->hasFile('videofile')){			
				$file = $request->file('videofile');
				$filename = $file->getClientOriginalName();
				$file_url = $this->postAttached($file);
				$file_url = 'http://'.$_SERVER['HTTP_HOST'].$file_url;
				DB::table('movies')->where('id', $id)->update(['path'=>$file_url]);
			}
		}
		$_SESSION['maintitle'] = 'Movies';
		$category = Category::lists('name', 'id');
		$country = Country::lists('name', 'id');
		$step = '0';
		
		return Redirect::to('/movies/movies');			
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
	public function postAttached($file){
		$folder = $_SERVER['DOCUMENT_ROOT'].'/uploads';
		if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/uploads')){
			mkdir($_SERVER['DOCUMENT_ROOT'].'/uploads');
		}
		$filename = $file->getClientOriginalName();
		$ext = explode('.',$filename);
		$filename = time().".".$ext[1];
		$file->move(
			base_path() . '/public/uploads/',$filename
		);
		$file_url = '/uploads/'.$filename;
		return $file_url;
	}
}
