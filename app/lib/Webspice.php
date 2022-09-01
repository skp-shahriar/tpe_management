<?php

namespace app\lib;


use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
// use Illuminate\Support\Facades\Redis;

class Webspice
{

	static function log($table, $id, $action)
	{
		$currentTime = Carbon::now("Asia/Dhaka");
		$userId = Auth::user()->id;
		$userName = Auth::user()->name;
		Log::channel('mylog')->info($currentTime . ' | USER ID:' . $userId . ' | USER NAME:' . $userName . ' | TABLE:' . $table . ' | ROW ID:' . $id . ' | ' . $action);
	}

	// static function status($status)
	// {

	// 	/*
	// 	# Status
	// 	1=Pending,2=Approved,3=Resolved,4=Forwarded,5=Deployed,6=New,7=Active,8=Initiated,9=On Progress,10=Delivered,
	// 	11=Locked,12=Returned,13=Sold,14=Paid,20=Settled,21=Replaced,22=Completed,23=Confirmed,24=Honored,-24=Dishonored,25=Accepted
	// 	-1=Deleted,-2=Declined,-3=Canceled,-5=Taking out,-6=Renewed,-7=Inactive;
	// 	*/
	// 	$text = null;
	// 	switch ($status) {
	// 		case 1:
	// 			$text = '<span class="badge bg-info">Pending</span>';
	// 			break;
	// 		case 2:
	// 			$text = '<span class="badge bg-success">Approved</span>';
	// 			break;
	// 		case 3:
	// 			$text = '<span class="badge bg-success">Resolved</span>';
	// 			break;
	// 		case 4:
	// 			$text = '<span class="badge bg-info">Forwarded</span>';
	// 			break;
	// 		case 5:
	// 			$text = '<span class="badge bg-success">Deployed</span>';
	// 			break;
	// 		case 6:
	// 			$text = '<span class="badge bg-info">New</span>';
	// 			break;
	// 		case 7:
	// 			$text = '<span class="badge bg-success">Active</span>';
	// 			break;
	// 		case 8:
	// 			$text = '<span class="badge bg-info">Initiated</span>';
	// 			break;
	// 		case 9:
	// 			$text = '<span class="badge bg-warning">On Progress</span>';
	// 			break;
	// 		case 10:
	// 			$text = '<span class="badge bg-success">Delivered</span>';
	// 			break;
	// 		case 11:
	// 			$text = '<span class="badge bg-info">Locked</span>';
	// 			break;
	// 		case 12:
	// 			$text = '<span class="badge bg-success">Returned</span>';
	// 			break;
	// 		case 13:
	// 			$text = '<span class="badge bg-danger">Sold</span>';
	// 			break;
	// 		case 14:
	// 			$text = '<span class="badge bg-success">Paid</span>';
	// 			break;
	// 		case 15:
	// 			$text = '<span class="badge bg-warning">Testing</span>';
	// 			break;
	// 		case 16:
	// 			$text = '<span class="badge bg-success">Verified</span>';
	// 			break;
	// 		case 20:
	// 			$text = '<span class="badge bg-success">Settled</span>';
	// 			break;
	// 		case 21:
	// 			$text = '<span class="badge bg-warning">Replaced</span>';
	// 			break;
	// 		case 22:
	// 			$text = '<span class="badge bg-success">Completed</span>';
	// 			break;
	// 		case 23:
	// 			$text = '<span class="badge bg-success">Confirmed</span>';
	// 			break;
	// 		case 24:
	// 			$text = '<span class="badge bg-success">Honored</span>';
	// 			break;
	// 		case 25:
	// 			$text = '<span class="badge bg-danger">Defaulter</span>';
	// 			break;
	// 		case 26:
	// 			$text = '<span class="badge bg-success">Not Defaulter</span>';
	// 			break;
	// 		case 28:
	// 			$text = '<span class="badge bg-success">Allowed</span>';
	// 			break;
	// 		case 29:
	// 			$text = '<span class="badge bg-success">Accepted</span>';
	// 			break;
	// 		case 30:
	// 			$text = '<span class="badge bg-success">Taken</span>';
	// 			break;
	// 		case 31:
	// 			$text = '<span class="badge bg-success">Partial Paid</span>';
	// 			break;
	// 		case 32:
	// 			$text = '<span class="badge bg-success">Reviewed</span>';
	// 			break;
	// 		case 33:
	// 			$text = '<span class="badge bg-success">Processed</span>';
	// 			break;
	// 		case 34:
	// 			$text = '<span class="badge bg-success">Acknowledged</span>';
	// 			break;

	// 		case -24:
	// 			$text = '<span class="badge bg-danger">Dishonored</span>';
	// 			break;

	// 		case -1:
	// 			$text = '<span class="badge bg-danger">Deleted</span>';
	// 			break;
	// 		case -2:
	// 			$text = '<span class="badge bg-danger">Declined</span>';
	// 			break;
	// 		case -3:
	// 			$text = '<span class="badge bg-danger">Canceled</span>';
	// 			break;
	// 		case -5:
	// 			$text = '<span class="badge bg-danger">Taking out</span>';
	// 			break;
	// 		case -6:
	// 			$text = '<span class="badge bg-danger">Renewed</span>';
	// 			break;
	// 		case -7:
	// 			$text = '<span class="badge bg-danger">Inactive</span>';
	// 			break;
	// 		default:
	// 			$text = '<span class="badge bg-default">Unknown</span>';
	// 			break;
	// 	}

	// 	return $text;
	// }

	public function activeInactive(Request $request)
	{
		try {
			$id = Crypt::decryptString($request->id);
			$status = '';
			$text = '';
			if ($request->status == 7) {
				$status = -7;
				$text = 'inactive';
			} elseif ($request->status == -7) {
				$status = 7;
				$text = 'active';
			}
			$res = DB::table($request->table)->where('id', $id)->update([
				'status' => $status,
				'updated_by' => Auth::user()->id,
				'updated_at' => Carbon::now("Asia/Dhaka")
			]);
			$queryStatus = [
				'status' => 'success',
				'changed_value' => $status,
				'message' => "Status $text successfully."
			];
		} catch (Exception $e) {
			$queryStatus = [
				'status' => 'not_success',
				'message' => 'SORRY! Status has not changed.'
			];
		}
		if ($queryStatus['message'] == 'success') {
			// log
			$this->log('options', $id, $queryStatus['message']);

			// Update chace 
			// $cache = Redis::get($request->table);
			// if (!isset($cache)) {
			// 	$cache = DB::table($request->table)->get();
			// 	Redis::set($request->table, json_encode($cache));
			// 	$cache = Redis::get($request->table);
			// }

			// $cacheData = collect(json_decode($cache));
			// $data = $cacheData->where('id', $id)->first();
			// $data->status = $status;
			// $data->updated_by = Auth::user()->id;
			// $data->updated_at = Carbon::now("Asia/Dhaka");
			// $index = $cacheData->search($data);
			// $cacheData[$index] = $data;
			// Redis::set($request->table, json_encode($cacheData));
		}

		return response()->json($queryStatus);
	}

	// function static_exchange_status($status)
	// {
	// 	# 1=Pending, 2=Approved, 3=Resolved, 4=Forwarded, 5=Deployed, 6=New, 7=Active, 8=Initiated, 9=On Progress, 10=Delivered, -2=Declined, -3=Canceled, -5=Taking out, -6=Renewed/Replaced, -7=Inactive
	// 	$text = null;
	// 	switch ($status) {
	// 		case 1:
	// 			$text = '<span class="label label-info">Pending/Active</span>';
	// 			break;
	// 		case 2:
	// 			$text = '<span class="label label-success">Approved</span>';
	// 			break;
	// 		case 3:
	// 			$text = '<span class="label label-success">Resolved</span>';
	// 			break;
	// 		case 4:
	// 			$text = '<span class="label label-purple">Forwarded</span>';
	// 			break;
	// 		case 5:
	// 			$text = '<span class="label label-success">Deployed</span>';
	// 			break;
	// 		case 6:
	// 			$text = '<span class="label label-info">New</span>';
	// 			break;
	// 		case 7:
	// 			$text = '<span class="label label-info">Active</span>';
	// 			break;
	// 		case 8:
	// 			$text = '<span class="label label-danger">Reported</span>';
	// 			break;
	// 		case 9:
	// 			$text = '<span class="label label-info">On Progress</span>';
	// 			break;
	// 		case 10:
	// 			$text = '<span class="label label-success">Delivered</span>';
	// 			break;
	// 		case 11:
	// 			$text = '<span class="label label-warning">On Investigation</span>';
	// 			break;
	// 		case 12:
	// 			$text = '<span class="label label-success">Closed</span>';
	// 			break;
	// 		case 13:
	// 			$text = '<span class="label label-info">Feedback Given</span>';
	// 			break;
	// 		case 14:
	// 			$text = '<span class="label label-primary">Inv Complete</span>';
	// 			break;
	// 		case 15:
	// 			$text = '<span class="label label-success">Verified</span>';
	// 			break;
	// 		case 16:
	// 			$text = '<span class="label label-success">Sent</span>';
	// 			break;
	// 		case 17:
	// 			$text = '<span class="label label-success">Received</span>';
	// 			break;
	// 		case 18:
	// 			$text = '<span class="label label-success">Returned</span>';
	// 			break;
	// 		case 19:
	// 			$text = '<span class="label label-success">Confirmed</span>';
	// 			break;
	// 		case 20:
	// 			$text = '<span class="label label-purple">Forwarded to Maintenance</span>';
	// 			break;

	// 		case 21:
	// 			$text = '<span class="label label-success">Placed</span>';
	// 			break;
	// 		case 22:
	// 			$text = '<span class="label label-primary">Served</span>';
	// 			break;
	// 		case 23:
	// 			$text = '<span class="label label-primary">Forwarded</span>';
	// 			break;

	// 		case 24:
	// 			$text = '<span class="label label-success">Started</span>';
	// 			break;
	// 		case 25:
	// 			$text = '<span class="label label-warning">Initiated</span>';
	// 			break;
	// 		case 26:
	// 			$text = '<span class="label label-success">Completed</span>';
	// 			break;
	// 		case 27:
	// 			$text = '<span class="label label-success">Sold</span>';
	// 			break;
	// 		case 28:
	// 			$text = '<span class="label label-success">Assigned</span>';
	// 			break;

	// 			# Security personnel requisition additional steps
	// 		case 29:
	// 			$text = '<span class="label label-warning">Forwarded to Admin</span>';
	// 			break;
	// 		case 30:
	// 			$text = '<span class="label label-success">Re-assigned Vendor</span>';
	// 			break;
	// 		case 31:
	// 			$text = '<span class="label label-success">Proposal submitted by Vendor</span>';
	// 			break;
	// 		case 32:
	// 			$text = '<span class="label label-success">Accepted & Deployed</span>';
	// 			break;

	// 		case 33:
	// 			$text = '<span class="label label-success">Accepted</span>';
	// 			break;

	// 		case 34:
	// 			$text = '<span class="label label-success">Allowed</span>';
	// 			break;

	// 			#Level of Authority(LOA)
	// 		case 101:
	// 			$text = '<span class="label label-success">LOA One</span>';
	// 			break;
	// 		case 102:
	// 			$text = '<span class="label label-success">LOA Two</span>';
	// 			break;
	// 		case 103:
	// 			$text = '<span class="label label-success">LOA Three</span>';
	// 			break;
	// 		case 104:
	// 			$text = '<span class="label label-success">LOA Four</span>';
	// 			break;
	// 		case 105:
	// 			$text = '<span class="label label-success">LOA Five</span>';
	// 			break;
	// 		case -1:
	// 			$text = '<span class="label label-danger">Inactive</span>';
	// 			break;
	// 		case -2:
	// 			$text = '<span class="label label-danger">Declined</span>';
	// 			break;
	// 		case -3:
	// 			$text = '<span class="label label-danger">Canceled</span>';
	// 			break;
	// 		case -5:
	// 			$text = '<span class="label label-warning">Taking out</span>';
	// 			break;
	// 		case -6:
	// 			$text = '<span class="label label-info">Renewed/Replaced</span>';
	// 			break;
	// 		case -7:
	// 			$text = '<span class="label label-danger">Inactive</span>';
	// 			break;
	// 		case -8:
	// 			$text = '<span class="label label-warning">Withdrawn</span>';
	// 			break;
	// 		case -24:
	// 			$text = '<span class="label label-danger">Deleted</span>';
	// 			break;
	// 		default:
	// 			$text = '<span class="label label-default">Unknown</span>';
	// 			break;
	// 	}

	// 	return $text;
	// }
}