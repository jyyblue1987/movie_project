<?php
namespace App\Http\Controllers\Movies;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movies\Category;
use App\Models\Movies\Country;
use App\Models\Movies\Movies;
use Auth;
use Session;
use Validator;
use Redirect;
use DateTime;
use DB;

define("SUCCESS", "200"); 			// successfully

define("MISSING_PARAMETER", "100"); // Parameter missing
define("INVALID_PARAMETER", "101"); // Parameter is invalid

define("USER_EXIST", "201");		// user already exist
define("NO_VERIFIED", "202"); 		// not verified user
define("STATUS_INACTIVE", "203"); 	// status inactive
define("INVALID_FRIEND", "204"); 	// invalid friends
define("AUTH_FAILED", "205"); 		// auth failed

define("NO_USER_EXIST", "301"); 	// user not exist
define("INVALID_PASSWORD", "302");	// user or password is not valid
define("INVALID_VCODE", "303");		// verify code is invalid
define("NO_PERMISSIONS", "304"); 	// no permissions
define("EXPIRED_VCODE", "305");		// verify code is expired
define("CONTACT_EXIST", "306");		// verify code is expired
define("INVALID_TOKEN", "307");		// verify code is expired
define("CONTACT_NO_EXIST", "308");		// verify code is expired
define("SERVER_INTERNAL_ERROR", "401"); // server process error
define("CHAT_SERVER_ERROR", "402"); // chat server down


define("DEVICE_IPHONE", "iphone");	// device type iPhone
define("DEVICE_ANDROID", "android");// device type Android

class ProcessController extends Controller
{
	public function getProcess(Request $request, $proc){
		switch($proc)
		{
			case 'getcountry':
				$this->getCountry($request);	
				break;
			case 'getcategory':
				$this->getCategory($request);	
				break;
			case 'getmovies':
				$this->getMovies($request);	
				break;	
		}
		
	}
	private function getCountry($request)
	{
		$data = DB::table('country')->orderby('id', 'ASC')->get();
		return $this->outputResult(SUCCESS, $data);
	}
	private function getCategory($request)
	{
		$data = DB::table('category')->orderby('id', 'ASC')->get();
		return $this->outputResult(SUCCESS, $data);
	}
	private function getMovies($request)
	{
		if( $request->has('catid') == false  ||
			$request->has('cid') == false  ||
			$request->has('offset') == false  ||
			$request->has('limit') == false)
		{ 
			$this->outputResult(MISSING_PARAMETER);
			return;
		}
		$catid = $request->get('catid', 0);
		$cid = $request->get('cid', 0);
		$offset = $request->get('offset', 0);
		$limit = $request->get('limit', 0);
		$offset1 = $limit * ($offset - 1);
		if($catid == 0 && $cid == 0){
			$data = DB::table('movies')->offset($offset1)->limit($limit)->orderby('created_at', 'DESC')->get();
		}else if($catid == 0){
			$data = DB::table('movies')->where('cid', $cid)->offset($offset1)->limit($limit)->orderby('created_at', 'DESC')->get();
		}else if($cid == 0){
			$data = DB::table('movies')->where('catid', $catid)->offset($offset1)->limit($limit)->orderby('created_at', 'DESC')->get();
		}else{
			$data = DB::table('movies')->where('catid', $catid)->where('cid', $cid)->offset($offset1)->limit($limit)->orderby('created_at', 'DESC')->get();
		}
		
		return $this->outputResult(SUCCESS, $data);
	}
	private function outputResult( $retcode, $content = '', $error_msg = null )
	{
		header('Content-type: application/json');

		if( $error_msg == null )
		{
			switch ($retcode)
			{
			case SUCCESS:
				$error_msg = '';
				break;
			case MISSING_PARAMETER:
				$error_msg = 'Parameter is missing';
				break;
			case INVALID_PARAMETER:
				$error_msg = 'Parameter is invalid';
				break;
			case USER_EXIST:
				$error_msg = 'User is already exist';
				break;
			case NO_USER_EXIST:
				$error_msg = 'User is not exist';
				break;
			case INVALID_PASSWORD:
				$error_msg = 'Your input password is not correct';
				break;
			case INVALID_VCODE:
				$error_msg = 'Verification code is invalid';
				break;
			case INVALID_FRIEND:
				$error_msg = 'Your fb friend list is not available.';
				break;
			case AUTH_FAILED:
				$error_msg = 'Your fb authorization is failed.';
				break;
			case EXPIRED_VCODE:
				$error_msg = 'Verification code is expired';
				break;
			case CONTACT_EXIST:
				$error_msg = 'Contact is already exist';
				break;
			case CONTACT_NO_EXIST:
				$error_msg = 'Contact is not exist';
				break;
			case INVALID_TOKEN:
				$error_msg = 'You didnt authorization.';
				break;
			case STATUS_INACTIVE:
				$error_msg = 'You can not login, you are disabled by administrator';
				break;
			case NO_VERIFIED:
				$error_msg = 'You are not verified yet.';
				break;
			case NO_PERMISSIONS:
				$error_msg = 'You have no permission';
				break;
			case SERVER_INTERNAL_ERROR:
				$error_msg = 'Server internal process error.';
				break;
			case CHAT_SERVER_ERROR:
				$error_msg = 'Chat server is not responding.';
				break;
			default :
				$error_msg = '';
				break;
			}
		}

		$response = array( 'retcode'=>$retcode, 'content'=>$content, 'error_msg'=>$error_msg );

		echo json_encode($response);		
	}	
	
}

?>