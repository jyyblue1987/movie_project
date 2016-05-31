<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class UploadController extends Controller
{
	private $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
	
	public function parseExcelFile($path)
	{
		
	}
	
	public function showExcelInfo()
	{		
		$this->parseExcelFile(public_path().'\uploads\csv\csv_1460808698.xlsx');
	}
	
	function upload(Request $request)
	{
		$output_dir = "uploads/csv/";
		
		$ret = array();

		$filekey = 'myfile';
		
		if($request->hasFile($filekey) === false )
			return "No input file";
		
		if ($request->file($filekey)->isValid() === false )
			return "No valid file";
		
		//You need to handle  both cases
		//If Any browser does not support serializing of multiple files using FormData() 
		if (!is_array($_FILES[$filekey]["name"])) //single file
		{
			$fileName = $_FILES[$filekey]["name"];
			$ext = pathinfo($fileName, PATHINFO_EXTENSION);	
			$filename1 = "csv_".time().".".strtolower($ext);		
			
			$dest_path = $output_dir . $filename1;
			move_uploaded_file($_FILES[$filekey]["tmp_name"], $dest_path);
			return $this->parseExcelFile($dest_path);
		}
		else  //Multiple files, file[]
		{
			$fileCount = count($_FILES[$filekey]["name"]);
			for ($i = 0; $i < $fileCount; $i++)
			{
				$fileName = $_FILES[$filekey]["name"][$i];
				$ext = pathinfo($fileName, PATHINFO_EXTENSION);	
				$filename1 = "csv_".time().".".strtolower($ext);
				
				$dest_path = $output_dir . $filename1;
				move_uploaded_file($_FILES[$filekey]["tmp_name"][$i], $dest_path);
				$this->parseExcelFile($dest_path);
			}
		}
		
		echo $ret[0];//json_encode($ret);
	
	}
	
	function uploadpicture(Request $request)
	{
		$output_dir = "uploads/picture/";
		
		$ret = array();
		
		$filekey = 'myfile';
		
		if($request->hasFile($filekey) === false )
			return "No input file";
		
		if ($request->file($filekey)->isValid() === false )
			return "No valid file";

		//You need to handle  both cases
		//If Any browser does not support serializing of multiple files using FormData() 
		if (!is_array($_FILES[$filekey]["name"])) //single file
		{
			$fileName = $_FILES[$filekey]["name"];
			$ext = pathinfo($fileName, PATHINFO_EXTENSION);	
			$filename1 = "pic_".time().".".strtolower($ext);		

			$dest_path = $output_dir . $filename1;
			
			move_uploaded_file($_FILES[$filekey]["tmp_name"], $dest_path);
			
			echo $filename1;
		}
		else  //Multiple files, file[]
		{
			$fileCount = count($_FILES[$filekey]["name"]);
			for ($i = 0; $i < $fileCount; $i++)
			{
				$fileName = $_FILES[$filekey]["name"][$i];
				$ext = pathinfo($fileName, PATHINFO_EXTENSION);	
				$filename1 = "csv_".time().".".strtolower($ext);
				
				$dest_path = $output_dir . $filename1;
				move_uploaded_file($_FILES[$filekey]["tmp_name"][$i], $dest_path);
				echo $filename1 . ",";
			}
		}
		
	}
	
}
