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
use Auth;
use Session;
use Validator;
use Illuminate\Support\Facades\Input;
use Hash;
class AdminController extends Controller
{
    private $request;
	
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
		
    public function index(Request $request)
	{
		//$_SESSION['maintitle'] = 'Profile';
		$step = '0';
		if(empty(Auth::user()->id)){
			return view('movies.login');
		}else{
			return Redirect::to('/movies/movies');	
		}	
    }
    public function confirm()
	{
		//$_SESSION['maintitle'] = 'Profile';
		$validator = Validator::make(Input::all(), [
            'username' => 'required',
            'password' => 'required'
        ]);
		//$pwd = bcrypt('moviesadmin');
        if ($validator->fails()) {
            return Redirect::back()
                        ->withErrors($validator);
        }

        $username = Input::get('username');
        $password = Input::get('password');
        if (Auth::attempt(array('username' => $username, 'password' => $password),true)) {
            return Redirect::to('/movies/movies');
        }else
        {
            return Redirect::back()
                        ->with('invalid_login','Please fill valid login credentials');
        }
		
    }
	public function logout()
    {
		Auth::logout();
        return Redirect::to('/login-admin');
    }

	public function getData()
    {
		$_SESSION['maintitle'] = 'Setup';
		$profile = Profile::find(1);	
		return view('Movies.profile', compact('profile'));
    }
	public function update(Request $request)
    {
		$username = $request->get('name', '');
		$email = $request->get('email', '');
		$password = $request->get('npassword', '');
		$password = bcrypt($password);
		$model = Profile::find(1);
		//var_dump($username.":".$email.":".$password);return;
		if( !empty($model) ){
			 $model = DB::table('users')
			->where('id', 1)
			->update(array('username'=>$username,'password'=>$password,'email'=>$email));		 
		}else{
			Session::put('invalid_login', 'Please fill valid login credentials');
			return Redirect::back()->with('invalid_login','Please fill valid login credentials');
		}
		Session::put('success', 'Successfully updated');
		return Redirect::back()->with('success','Successfully updated');
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
	

    public function destroy($id)
    {
		$model = Profile::find($id);
		$model->delete();
		
		return Response::json($model);				
    }	
}
