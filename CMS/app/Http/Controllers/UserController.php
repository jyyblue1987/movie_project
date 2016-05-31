<?php

namespace App\Http\Controllers;

use Auth;
use Hash;
//use App\User;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Contacts;
use App\Models\AdminInfo;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use \SimpleXMLElement;

use App\Modules\Functions;
//use Illuminate\Pagination;


function convertMobileNumber($number)
{
	return "+" . str_replace("_", " ", $number);
}		
class UserController extends Controller
{
	function login()
	{
		
		 if(empty($_SESSION["login"]) || $_SESSION["login"] !== '1' )
		{
			return view('login');
		}else{	
		//return redirect()->intended('/admin/advertisement'); // 
			return redirect()->intended('/admin/index');
		}
		return view('login');
	}
	
	function logout()
	{
		$_SESSION["login"] = '0';
		$_SESSION["email"] = '';
		unset($_SESSION['login']); 
			
		return redirect()->intended('login');
	}
	
	public function postLogin(Request $request)
	{
		
 		/* $default_email = 'admin@gmail.com';
		
		if (AdminInfo::where('email', '=', $default_email)->exists() === false) {
			$user = new AdminInfo();
			$user->email = $default_email;
			$user->password = Hash::make('everydayadmin');
			$user->save();
		}  
		echo Hash::make('everydayadmin');
		return;*/
		//echo $request->input('email');
		$email = $request->input('email');
		$password = $request->input('password');
		if (Auth::attempt(['email' => $email, 'password' => $password])) {
			$_SESSION["email"] = $email;
			$_SESSION["login"] = '1';
			return redirect()->intended('/admin/index');
        }
		else
		{
			$_SESSION["login"] = '0';
			$_SESSION["email"] = '';
			return redirect()->intended('login');
		}	
	}
	
	function index(Request $request)
	{	
		
		if(empty($_SESSION["login"]) || $_SESSION["login"] !== '1' )
		{
			return redirect()->intended('login');
		}	
		$item = $request->get('pageSize');
		$option = $request->get('select_option');
		echo $option;
		
		if($item == null)
		{
			$item = 10;				
		}
		if($option == null){
			$option = 'Email';	
		}
		
		$users = User::paginate($item);
		
		
		foreach( $users as &$value )	
		{	
			
			$value['phone'] = convertMobileNumber($value['phone']);	
			if( $value['email'] === 'false' )
				$value['email'] = '';
			if( $value['name'] === 'false' )
				$value['name'] = '';
			if( $value['address'] === 'false' )
				$value['address'] = '';
			if( $value['fullname'] === null )
				$value['fullname'] = '';
			if( $value['supportnum'] === null )
				$value['supportnum'] = 0;
			if( $value['pointnum'] === null )
				$value['pointnum'] = 0;
			if( $value['commentnum'] === null )
				$value['commentnum'] = 0;
			if( $value['friendnum'] === null )
				$value['friendnum'] = 0;
		} 
		
									
		return view('users.user')->with('users', $users)->with('item_v',$item)->with('option',$option);
	}
	
	function search(Request $request)
	{	
		if(empty($_SESSION["login"]) || $_SESSION["login"] !== '1' )
		{
			return redirect()->intended('login');
		}
		$item = 10;	
		$input = $request->get('find');
		$option = $request->get('select_option');
		$orderby = $request->get('orderby_option');
		if(empty($input)){
			$user = User::orderBy('pointnum','DESC')->paginate($item);
		}else{
			switch($option){
				case 1:
					$option_id = "Email";
					if($orderby == '0')
						$user = User::where('email', 'like', '%' . $input . '%')->orderBy('modifydate','DESC')->paginate($item);
					if($orderby == '1')
						$user = User::where('email', 'like', '%' . $input . '%')->orderBy('receivenum','DESC')->paginate($item);
					if($orderby == '2')
						$user = User::where('email', 'like', '%' . $input . '%')->orderBy('pointnum','DESC')->paginate($item);
					break;
				case 2:
					$option_id = "name";
					if($orderby == '0')
						$user = User::where('username', 'like', '%' . $input . '%')->orderBy('modifydate','DESC')->paginate($item);
					if($orderby == '1')
						$user = User::where('username', 'like', '%' . $input . '%')->orderBy('receivenum','DESC')->paginate($item);
					if($orderby == '2')
						$user = User::where('username', 'like', '%' . $input . '%')->orderBy('pointnum','DESC')->paginate($item);
						
					break;
			}
		}
						
		
		
		//$user = OfUser::where('%'.$option_id.'%', 'like', '%' . $input . '%')->paginate($item);
		/*foreach( $user as &$value )	
		{
			$value['mobile'] = convertMobileNumber($value['username']);	
			if( $value['email'] === 'false' )
				$value['email'] = '';
			if( $value['name'] === 'false' )
				$value['name'] = '';
		}*/
		
		return view('users.user')->with('users', $user)->with('item_v',$item)->with('input',$input)->with('option',$option)->with('orderby',$orderby);
	}
	function searchcontact(Request $request)
	{	
		if(empty($_SESSION["login"]) || $_SESSION["login"] !== '1' )
		{
			return redirect()->intended('login');
		}
		$item = 10;	
		$uid = $request->get('uid');
		$input = $request->get('find');
		$option = $request->get('select_option');
		$orderby = $request->get('orderby_option');
		$table = new Contacts();
		if(empty($input)){
			$userinfo = $table->join('user','contacts.contactno', '=', 'user.id')
					->select('user.*')->where('contacts.userno', '=', $uid)->paginate($item);
		}else{
			switch($option){
				case 1:
					$option_id = "Email";
					if($orderby == '0')
						$userinfo = $table->join('user','contacts.contactno', '=', 'user.id')
							->select('user.*')->where('contacts.userno', '=', $uid)->where('user.email', 'like', '%' . $input . '%')->orderBy('user.modifydate','DESC')->paginate($item);
					if($orderby == '1')
						$userinfo = $table->join('user','contacts.contactno', '=', 'user.id')
							->select('user.*')->where('contacts.userno', '=', $uid)->where('user.email', 'like', '%' . $input . '%')->orderBy('user.receivenum','DESC')->paginate($item);
					if($orderby == '2')
						$userinfo = $table->join('user','contacts.contactno', '=', 'user.id')
							->select('user.*')->where('contacts.userno', '=', $uid)->where('user.email', 'like', '%' . $input . '%')->orderBy('user.pointnum','DESC')->paginate($item);
					break;
				case 2:
					$option_id = "name";
					if($orderby == '0')
						$userinfo = $table->join('user','contacts.contactno', '=', 'user.id')
							->select('user.*')->where('contacts.userno', '=', $uid)->where('user.username', 'like', '%' . $input . '%')->orderBy('user.modifydate','DESC')->paginate($item);
					if($orderby == '1')
						$userinfo = $table->join('user','contacts.contactno', '=', 'user.id')
							->select('user.*')->where('contacts.userno', '=', $uid)->where('user.username', 'like', '%' . $input . '%')->orderBy('user.receivenum','DESC')->paginate($item);
					if($orderby == '2')
						$userinfo = $table->join('user','contacts.contactno', '=', 'user.id')
							->select('user.*')->where('contacts.userno', '=', $uid)->where('user.username', 'like', '%' . $input . '%')->orderBy('user.pointnum','DESC')->paginate($item);
						
					break;
			}
		}
						
		
		
		//$user = OfUser::where('%'.$option_id.'%', 'like', '%' . $input . '%')->paginate($item);
		/*foreach( $user as &$value )	
		{
			$value['mobile'] = convertMobileNumber($value['username']);	
			if( $value['email'] === 'false' )
				$value['email'] = '';
			if( $value['name'] === 'false' )
				$value['name'] = '';
		}*/
		
		return view('users.contact')->with('users', $userinfo)->with('item_v',$item)->with('uid',$uid)->with('input',$input)->with('option',$option)->with('orderby',$orderby);
	}
	
	function process($id = AUTH)	
	{
		if(empty($_SESSION["login"]) || $_SESSION["login"] !== '1' )
		{
			return redirect()->intended('login');
		}
		//echo $id;
		return view('users.process')->with('action', $id);
	}
	function email(Request $request)
	{
		if(empty($_SESSION["login"]) || $_SESSION["login"] !== '1' )
		{
			return redirect()->intended('login');
		}
		
		$error = '';
		
		if( $request->isMethod('post') )
		{
			$admin = User::where('email', '=', $_SESSION['email'])->first();
			if( empty($admin) )
				return redirect()->intended('login');
			
			if( $request->get('password1') !== $request->get('password2') )
				$error = Functions::GetMessage ('ACCOUNT_PASS_MISMATCH');
			else if( strlen($request->get('password1')) < 6 || strlen($request->get('password1')) > 32 )
				$error = Functions::GetMessage('ACCOUNT_PASS_CHAR_LIMIT', array(6, 32));
			else
			{
				$admin->email = $request->get('email');
				$admin->name = $request->get('username');
				$admin->password = Hash::make($request->get('password1'));
				$admin->save();
				
				$_SESSION['email'] = $admin->email;	
				$error = 'SUCCESS';
			}
		}
		else
		{
			$email = $_SESSION["email"];
			$admin = AdminInfo::where('email', '=', $email)->first();
		}
		return view('users.email')->with('admin', $admin)->with('error',$error);		
	}
	
	function update(Request $request)
	{
		if(empty($_SESSION["login"]) || $_SESSION["login"] !== '1' )
		{
			return redirect()->intended('login');
		}
		if( !isset($_SESSION['email']) ) 
		{
			return redirect()->intended('login');
		}
		
		
		
		return redirect()->intended('/');	
	}
	
	function userprofile(Request $request)
	{
		if(empty($_SESSION["login"]) || $_SESSION["login"] !== '1' )
		{
			return redirect()->intended('login');
		}
		
		$username = $request->get('pname');
		$input = $request->get('input');
		$option = $request->get('option');
		$orderby = $request->get('orderby');
		$userinfo = User::where('id', '=', $username)->first();
		//echo $userinfo;
		if( empty($userinfo) )
		{
			$profile = array();	
			$profile['mobile'] = convertMobileNumber($username);
			return view('users.exceptuserprofile')->with('profile',$profile);
		}
		
	
		return view('users.userprofile')->with('profile',$userinfo)->with('input',$input)->with('option',$option)->with('orderby',$orderby);
	}
	function huserprofile(Request $request)
	{
		if(empty($_SESSION["login"]) || $_SESSION["login"] !== '1' )
		{
			return redirect()->intended('login');
		}
		
		$username = $request->get('pname');
		$input = $request->get('input');
		$orderby = $request->get('orderby');
		$userinfo = User::where('id', '=', $username)->first();
		//echo $userinfo;
		if( empty($userinfo) )
		{
			$profile = array();	
			$profile['mobile'] = convertMobileNumber($username);
			return view('users.exceptuserprofile')->with('profile',$profile);
		}
		
	
		return view('users.huserprofile')->with('profile',$userinfo)->with('input',$input)->with('orderby',$orderby);
	}
	function contactprofile(Request $request)
	{
		if(empty($_SESSION["login"]) || $_SESSION["login"] !== '1' )
		{
			return redirect()->intended('login');
		}
		
		$username = $request->get('pname');
		$uid = $request->get('uid');
		$input = $request->get('input');
		$option = $request->get('option');
		$orderby = $request->get('orderby');
		$userinfo = User::where('id', '=', $username)->first();
		//echo $userinfo;
		if( empty($userinfo) )
		{
			$profile = array();	
			$profile['mobile'] = convertMobileNumber($username);
			return view('users.exceptuserprofile')->with('profile',$profile);
		}
		
		
		/*$xml_parser = xml_parser_create() or die ("XML 파서를 생성하지 못했습니다.");
		xml_parse_into_struct($xml_parser, $userinfo->vcard, $value, $index);  
		xml_parser_free($xml_parser);  
		
		$middle = '';
		$family = '';
		foreach($value as $v){  
			if( $v['tag'] === 'MIDDLE' )
			{
				$middle = $v['value'];
			}
			if( $v['tag'] === 'FAMILY' )
			{
				$family = $v['value'];
			}
		}
	
		$profile = json_decode($middle, true);	
		$profile['mobile'] = convertMobileNumber($username);
		if( $profile['role'] === '0' )
			$profile['role'] = 'Patient';
		else
			$profile['role'] = 'Doctor';*/
	
		return view('users.contactprofile')->with('profile',$userinfo)->with('uid',$uid)->with('input',$input)->with('option',$option)->with('orderby',$orderby);
	}
	
	function contact(Request $request)
	{
		if(empty($_SESSION["login"]) || $_SESSION["login"] !== '1' )
		{
			return redirect()->intended('login');
		}
		
		$id = $request->get('pname');
		$item = $request->get('pageSize');
		
		if($item == null)
		{
			$item = 10;				
		}
		$table = new Contacts();
		//$userinfo = Contacts::where('userno', '=', $id)->get();
		$userinfo = $table->join('user','contacts.contactno', '=', 'user.id')
					->select('user.*')->where('contacts.userno', '=', $id)->paginate($item);
		if( empty($userinfo) )
		{
			return view('users.contact');
		}
		return view('users.contact')->with('users', $userinfo)->with('uid', $id);
		/* $contactinfo = array();
		foreach( $userinfo as $value){
			$contact = $value['contactno'];
			$contactinfo = User::where('id', '=', $contact)->paginate(10);
			//echo $contactinfo[0];
			
		} */
		
				
	}
	
	function ad_user(Request $request)
	{	
		
		if(empty($_SESSION["login"]) || $_SESSION["login"] !== '1' )
		{
			return redirect()->intended('login');
		}	

		$adver = new OfUser();
		
		return view('users.user_register')->with('adver',$adver)->with('error', '')->with('mode', 'create');
	}
	
	function user_item(Request $request)
	{	
		
		if(empty($_SESSION["login"]) || $_SESSION["login"] !== '1' )
		{
			return redirect()->intended('login');
		}	
		
		$data = $request->get('region_data');
		
		$adver = new OfUser();
		
		$adver->phone = $data['phone'];
		$adver->name = $data['name'];
		$adver->email = $data['email'];
		$adver->adress = $data['adress'];
		//$adver->sequence = $data['sequence'];
		
		$adver->save();
		
		$adver = new OfUser(); 
		return view('users.user_register')->with('adver',$adver)->with('error', 'SUCCESS')->with('mode', 'create');
	}
	
	 function user_edit(Request $request, $phone)
	{	
		
		if(empty($_SESSION["login"]) || $_SESSION["login"] !== '1' )
		{
			return redirect()->intended('login');
		}	

		$page = $request->get('page');
		if( $page === null )
			$page = 1;
		
		$adver = OfUser::where('phone', '=', $phone)->first();
		
		if( $adver == null )
		{
			return redirect()->intended('/admin/index?page='.$page);
		}
									
		return view('users.user_register')->with('adver',$adver)->with('error', '')->with('mode', 'edit');

	}

function updateItem(Request $request, $phone)
    {	
		
		if(empty($_SESSION["login"]) || $_SESSION["login"] !== '1' )
		{
			return redirect()->intended('login');
		}	
		
		$adver = OfUser::where('phone', '=', $phone)->first();
		//echo $adver;
		if( $adver == null )
		{
			return redirect()->intended('/admin/index');
		}
		
		$data = $request->get('region_data');
		$adver = new OfUser();
		$adver->phone = $data['phone'];
		$adver->name = $data['name'];
		$adver->email = $data['email'];
		
		$adver->adress = $data['adress'];
		//$adver->sequence = $data['sequence'];
		
		
		$adver->save();
		
		return view('users.user_register')->with('adver',$adver)->with('error', 'SUCCESS')->with('mode', 'edit');
	}

function user_delete(Request $request, $phone)
	{	
		
		if(empty($_SESSION["login"]) || $_SESSION["login"] !== '1' )
		{
			return redirect()->intended('login');
		}	
		
		$page = $request->get('page');
		if( $page === null )
			$page = 1;

		$my_delete = OfUser::where('phone', '=', $phone)->delete();
		//echo $my_delete;
		/*if( $my_delete != null )
			$my_delete->delete();*/

		
		return redirect()->intended('/admin/index?page='.$page);		
	}

function user_totaldelete(Request $request)
	{	
		
		if(empty($_SESSION["login"]) || $_SESSION["login"] !== '1' )
		{
			return redirect()->intended('login');
		}	
		$data = $request->get('cat_ids');
		$j = $data->length();
		echo $j;
		//echo $data[2];
		for($i = 0; $i <= $data.length-1; $i++ ){
			if($data[i] != null){
				OfUser::where('phone', '=', $data[i])->delete();
			}
			else
				return redirect()->intended('/admin/index');
		}
			
		
		
		//OfUser::where('phone', '=', $data[i])->delete();
			
		
		//$deletions = $_POST['cat_ids'];
		//echo $data[1];
		//OfUser::destroy($data[1]);
		
		return redirect()->intended('/admin/index');		
	}	
}
