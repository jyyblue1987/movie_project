<?php

namespace App\Http\Controllers\Movies;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\Common\Department;
use App\Models\Movies\Device;

use Redirect;
use DB;
use Response;
use Datatables;

class DeviceController extends Controller
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
			Device::whereIn('id', $ids)->delete();			
			return back()->withInput();				
		} 
		$_SESSION['maintitle'] = 'Device';
		
		$step = '0';
		
		return view('movies.device', compact('step'));	
    }

	public function getGridData()
    {
		$datalist = DB::table('devices')->orderby('id','ASC');
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
			$model = Device::create($input);
		} catch(PDOException $e){
		   return Response::json($model);
		}	
		
		return Response::json($model);			
	}

    public function show($id)
    {
		$model = Device::find($id);	
		
		return Response::json($model);
    }

    public function edit($id)
    {
		
    }
    public function importData(Request $request)
    {
		if($request->hasFile('devicelist')){
			
			$file = $request->file('devicelist');
			$folder = $_SERVER['DOCUMENT_ROOT'].'/uploads/imports';
			if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/uploads')){
				mkdir($_SERVER['DOCUMENT_ROOT'].'/uploads');
			}
			if(!file_exists($folder)){
				mkdir($folder);
			}
			$filename = $file->getClientOriginalName();
			$ext = explode('.',$filename);
			if($ext[1] == 'csv'){
				$filePath = $folder.'/'.$filename;
				if ($filename !== "" && file_exists($filePath))
				{
					unlink($filePath);
				}
				$file->move(
					base_path() . '/public/uploads/imports/',$filename
				);
				
				if ( ($file = fopen( $filePath , "r" )) ) {

					$firstline = fgets ($file, 4096 );
					//Gets the number of fields, in CSV-files the names of the fields are mostly given in the first line
					$num = strlen($firstline) - strlen(str_replace(",", "", $firstline));
					//save the different fields of the firstline in an array called fields
					$fields = explode( ",", $firstline, ($num+1) );
					$line = array();
					$i = 0;	
					//CSV: one line is one record and the cells/fields are seperated by ";"
					//so $dsatz is an two dimensional array saving the records like this: $dsatz[number of record][number of cell]
					$kk = 0;
					while ( $line[$i] = fgets ($file, 4096) ) {
	//					$ret .= $i.":";
						$data[$i] = array();

						$data[$i] = explode( ",", $line[$i], ($num+1) );
						$newdata = array();
						$j = 0;
						$macaddress = '';
						$serialno = '';
						foreach ($data[$i] as $k => $content) {
							$newdata[$fields[$k]] = $content;
							if($j == 0){
								$macaddress = $content;
								$macaddress = str_replace(' ', '', $macaddress);
								$macaddress = preg_replace('/\s+/', '', $macaddress);
							}
							if($j == 1){
								$serialno = $content;
								$serialno = str_replace(' ', '', $serialno);
								$serialno = preg_replace('/\s+/', '', $serialno);
							}
							$j++;
						}

						//insert or update agents
						//$macaddress = (isset($newdata["macaddress"]))? $newdata["macaddress"] : "";
						//$serialno = (isset($newdata["serialno"]))? $newdata["serialno"] : "";
					
						$device = DB::table('devices')->where('macaddress', $macaddress)->where('serialno', $serialno)->first();
						if(empty($device)){
							DB::table('devices')->insert(['macaddress'=>$macaddress, 'serialno'=>$serialno]);
						}
						$i++;
					}
				}
				return Redirect::to('/movies/device');
			}else{
				return Redirect::to('/movies/device');
			}
			
		}
    }

	public function updateData(Request $request)
	{
		$id = $request->get('id', '0');
		
		$input = $request->all();
		
		$model = Device::find($id);
			
		if( !empty($model) )
			$model->update($input);
		
		return Response::json($model);			
	}
	
    public function update(Request $request, $id)
    {
		$input = $request->all();
		
		$model = Device::find($id);
			
		if( empty($model) )
			$model->update($input);
		
		return Response::json($model);			
    }

    public function destroy($id)
    {
		$model = Device::find($id);
		$model->delete();
		
		return Response::json($model);				
    }	
}
