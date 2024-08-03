<?php
   
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use App\Http\Model\Transaction;
use App\Http\Model\Client;
// use App\Models\Post;

class ApiController extends Controller {
	
	//api get total quotation dan invoice
	public function getTotal($jr, $date='') {
		//return "get Total $jr";
		$db=$jr;
		$out['Total'.$jr] = [
			'draft'		=> DB::table($db)->where('Status', 0)->sum('Total')?? 0,
			'sent'		=> DB::table($db)->where('Status', 1)->sum('Total')?? 0,
			'viewed'	=> DB::table($db)->where('Status', 2)->sum('Total')?? 0,
			'approved'	=> DB::table($db)->where('Status', 3)->sum('Total')?? 0,
			'rejected'	=> DB::table($db)->where('Status', 4)->sum('Total')?? 0,
			'cancel'	=> DB::table($db)->where('Status', 5)->sum('Total')?? 0,
		];
		return response()->json($out);
	}
	// api tuk get data
	function getdata($jr, $id='', Request $req) {
		$limit = $req->limit ?? 999999;
		$offset = $req->offset ?? 0;
		//return "getdata";
		$db = $jr;
		//master
		// if (in_array($db, ['product','productprice','customer','supplier','profile','bank','coa','company'])) {
		// 	$db = 'master'.$db;
		// 	$resp = DB::table($db);
		// 	if($id!='') {
		// 		$key='id';
		// 		if ($jr=='company') $key='Token';
		// 		$data = $resp->where($key,$id)->first();
		// 	} else {
		// 		$data = $resp->get();
		// 	}
		// }
		//trans
		// if (in_array($jr, ['SO','PO'])) {
		// 	$db = 'orderhead';
		// 	if($id=='') {
		// 		// $data = DB::table($db)->where('Token','ZZXXAA');
		// 		//$data = DB::table($db)->where('Token', session('token'));
		// 		$data = DB::table($db);
		// 		$data = $data->whereRaw("left(TransNo,2)='$jr'");
		// 		if (isset($req->trans_id)) $data=$data->where('trans_id', $req->trans_id);
		// 		if (isset($req->code)) $data=$data->where('code', $req->code);
		// 		$data = $data->get();
		// 	} else {
		// 		$data = DB::table($db)
		// 			->where('Token', session('token'))
		// 			->first();
		// 	}
		// }
		//general
		try {
			$resp = DB::table($db);
			if ($id!='') {
				$key ='id';
				$data = $resp->where($key,$id)->first();
				//$data=$resp->take($limit)->get();
			} else {
				$page = $req->query('page') ?? 0;
				$pageSize = $req->query('pageSize')?? 10;
				$data= $resp->take($limit)->offset($offset)->get();
				
			}
			return response()->json($data);
		}
		catch(Exception $e) {
			$data = [
				'status' =>'error',
				'errorMsg' => $e.getMessage(),
			];
			return response()->json($data);
		}
	}
	function getcommon($id='', Request $req) {
		//return "getcommon";
		try {
			$resp = DB::table('common');
			if ($id!='') {
				$id=ucfirst($id);
				$data = $resp->where('category',$id)->get();
				// return dd($data);
			} else {
				$data = $resp->get();
				return 'data';
			}
			return response()->json($data);
		}
		catch(Exception $e) {
			$data = [
				'status' =>'error',
				'errorMsg' => $e.getMessage(),
			];
			return response()->json($data);
		}
	}
	public function createdata(Request $req ) {
	//return response()->json(['hasil'=>'test']);
		//return response()->json($req);
		$db = $req->jr;
		$m = new Client;
		$save = $req->all();
		$m->fill($save);
		try {
			$m->save();
			return response()->json(['status'=>'ok', 'data'=>$save]);
		}
		catch (Throwable $e) {
			$errmsg = $e->getMessage();
			return response()->json(['status'=>'error', 'ErrorMsg'=>$errmsg]);
		}
	}

	public function updatedata(Request $req ) {
			$db = $req->jr;
			$m = Client::where('id',1);
			$save = $req->all();
			$m->update($save);
			return response()->json(['status'=>'ok', 'data'=>$save]);
		}





	// api ini hanya dipakai tuk ambil data tuk android
	// function trans_list($jr) {
	// 	switch($jr) {
	// 		case 'DO':
	// 		case 'SI':
	// 		case 'IN':
	// 			$dat = DB::table('transhead')->selectRaw("TransNo,TransDate,AccName,Total,'' as Status,CreatedBy,id")->whereRaw("left(TransNo,2)='$jr' ")
	// 					->limit(5)
	// 					->get();
	// 			foreach($dat as $dt) {
	// 				$dt->Status = 'OPEN'; //$this->gettransstatus($link, $jr);   
	// 			}
	// 			$data = [
	// 				'jr'        => $jr,
	// 				'caption'   => $this->makeCaption($jr),
	// 				'data'      => $dat,
	// 			];
	// 			break;
			
	// 		default:
	// 			return "no list from $jr";
	// 			break;
	// 	}
	// 	return $data;
	// }

	// api ini hanya dipakai tuk ambil data tuk android
	// function trans($jr, $id) {
	// 	switch($jr) {
	// 		case 'DO':
	// 		case 'SI':
	// 		case 'IN':
	// 			$dat = DB::table('transhead as th')
	// 					->whereRaw("left(TransNo,2)='$jr' ")
	// 					->where('th.TransNo', $id)
	// 					->get();
	// 			$detail = DB::table('transdetail as td')
	// 					->where('td.TransNo', $id)
	// 					->get();
	// 			$data = [
	// 				'jr'        => $jr,
	// 				'caption'   => $this->makeCaption($jr).' #'.$id,
	// 				'data'      => $dat,
	// 				'detail'    => $detail,
	// 			];
	// 			break;
			
	// 		default:
	// 			return "no list from $jr";
	// 			break;
	// 	}
	// 	return $data;
	// }

}
