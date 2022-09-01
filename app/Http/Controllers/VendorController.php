<?php

namespace App\Http\Controllers;

use App\lib\Webspice;
use App\Models\Vendor;
use Illuminate\Http\Request;
use App\Exports\VendorExport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class VendorController extends Controller
{
    function __construct()
    {
        $this->table = 'vendors';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $startTime = microtime(true);
        $query = Vendor::orderBy('created_at', 'desc');
        // $export_query=Vendor::select();
        // if ($request->search_type != null) {
        //     $query->where('type', $request->search_type);
        // }
        if ($request->search_status != null) {
            $query->where('status', $request->search_status);
        }
        $searchText = $request->search_text;
        if ($searchText != null) {
            // $query = $query->search($request->search_text); // search by value
            $query->where(function ($query) use ($searchText) {
                $query->where('vendor_name', 'LIKE', '%' . $searchText . '%')
                    ->orWhere('mobile_no', 'LIKE', '%' . $searchText . '%')
                    ->orWhere('email', 'LIKE', '%' . $searchText . '%')
                    ->orWhere('reference_no', 'LIKE', '%' . $searchText . '%');
            });
            // $query->whereLike(['branch_code', 'branch_name', 'branch_type', 'address'], $searchText);
        }
        if ($request->submit_btn == 'export') {
            return Excel::download(new VendorExport($query->get()->makeHidden(['owner_photo','agreement_attachment','status','created_by','updated_by','created_at','updated_at'])), 'vendor_list_' . time() . '.xlsx');
        }

        $vendors = $query->paginate(8);


        $endTime = microtime(true);
        $executionTime = $endTime - $startTime;


        return view('master_data.vendor.index', [
            'vendors' => $vendors,
            'execution_time' => $executionTime
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master_data.vendor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator= Validator::make($request->all(),[
            'vendor_name' => 'required|unique:vendors,vendor_name',
            'owner_name' => 'required',
            'owner_photo' => 'required|mimes:jpg,jpeg,png|max:2048',
            'mobile_no' => 'required|numeric',
            'email' => 'required|email:rfc,dns|unique:vendors,email',
            'address' => 'required',
            'commission_rate' => 'numeric',
            'tin' => 'required',
            'enlisted_date' => 'required|date_format:d/m/Y',
            'contact_person_number' => 'numeric',
            'agreement_attachment' => 'required|mimes:jpg,jpeg,png,pdf|max:10240',
            'material_commission_amount' => 'numeric',
            'agreement_date' => 'required|date_format:d/m/Y',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->getMessageBag()->toArray()
            ]);
        }else {
            // dd($request->commission_rate);
            $agreement_attachment = 'agr' .time() . '.' . $request->agreement_attachment->extension();
            $request->agreement_attachment->move(public_path('img/agreement'), $agreement_attachment);
            $owner_photo = 'owner' .time().'.'.$request->owner_photo->extension();
            $request->owner_photo->move(public_path('img/owner_photo'), $owner_photo);
            $data=[
                'vendor_name'=>$request->vendor_name,
                'owner_name'=>$request->owner_name,
                'owner_photo'=>$owner_photo,
                'mobile_no'=>$request->mobile_no,
                'email'=>$request->email,
                'address'=>$request->address,
                'commission_rate'=>$request->commission_rate,
                'reference_no'=>$request->reference_no,
                'tin'=>$request->tin,
                'enlisted_date'=>$request->enlisted_date,
                'contact_person'=>$request->contact_person,
                'contact_person_number'=>$request->contact_person_number,
                'agreement_attachment'=>$agreement_attachment,
                'material_commission_amount'=>$request->material_commission_amount,
                'agreement_date'=>$request->agreement_date,
                'status'=>7,
                'created_by'=> Auth::user()->id,
            ];
            $vendor_created=Vendor::create($data);
            Webspice::log($this->table, $vendor_created->id, "Data Created successfully!");
            return response()->json([
                    'status'=>200,
                    'message'=> 'Vendor Added Successfully!'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id = Crypt::decryptString($id);
        $vendor=Vendor::find($id);
        return view('master_data.vendor.details',compact('vendor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = Crypt::decryptString($id);
        $vendor=Vendor::find($id);  
        return response()->json($vendor);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $id = Crypt::decryptString($id);
        $validator= Validator::make($request->all(),[
            'vendor_name' => 'required|unique:vendors,vendor_name,'.$id,
            'owner_name' => 'required',
            'owner_photo' => 'mimes:jpg,jpeg,png|max:2048',
            'mobile_no' => 'required|numeric',
            'email' => 'required|email:rfc,dns|unique:vendors,email,'.$id, 
            'address' => 'required',
            'commission_rate' => 'numeric',
            'tin' => 'required',
            'enlisted_date' => 'required|date_format:d/m/Y',
            'contact_person_number' => 'numeric',
            'agreement_attachment' => 'mimes:jpg,jpeg,png,pdf|max:10240',
            'material_commission_amount' => 'numeric',
            'agreement_date' => 'required|date_format:d/m/Y',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->getMessageBag()->toArray()
            ]);
        }else {

            $data=[
                'vendor_name'=>$request->vendor_name,
                'owner_name'=>$request->owner_name,
                'mobile_no'=>$request->mobile_no,
                'email'=>$request->email,
                'address'=>$request->address,
                'commission_rate'=>$request->commission_rate,
                'reference_no'=>$request->reference_no,
                'tin'=>$request->tin,
                'enlisted_date'=>$request->enlisted_date,
                'contact_person'=>$request->contact_person,
                'contact_person_number'=>$request->contact_person_number,
                'material_commission_amount'=>$request->material_commission_amount,
                'agreement_date'=>$request->agreement_date,
                'updated_by'=> Auth::user()->id,
            ];
            if (isset($request->agreement_attachment)) {
                $agreement_attachment = 'agr' .time() . '.' . $request->agreement_attachment->extension();
                $request->agreement_attachment->move(public_path('img/agreement'), $agreement_attachment);
                $data['agreement_attachment']=$agreement_attachment;
                $del = 'img/agreement/' . Vendor::find($id)->agreement_attachment;
                File::delete(public_path($del));
            }
            if (isset($request->owner_photo)) {
                $owner_photo = 'owner' .time() . '.' . $request->owner_photo->extension();
                $request->owner_photo->move(public_path('img/owner_photo'), $owner_photo);
                $data['owner_photo']=$owner_photo;
                $del = 'img/owner_photo/' . Vendor::find($id)->owner_photo;
                File::delete(public_path($del));
            }

            $updateOk = false;
            try {               
                Vendor::find($id)->update($data);
                $updateOk = true;
            } catch (\Illuminate\Database\QueryException $e) {
                // Do whatever you need if the query failed to execute
                $updateOk = false;
                return response()->json(['error' => 'SORRY! Something went wrong!']);
            }
            if ($updateOk) {
                Webspice::log($this->table, $id, "Data updated successfully!");

                return response()->json([
                    'status'=>200,
                    'message'=> 'Vendor Edited Successfully!'
            ]);
            }
        
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = Crypt::decryptString($id);
        $softDelOk = false;
        try {
            Vendor::where('id', $id)->update(['status' => -1]);
            $softDelOk = true;
        } catch (\Illuminate\Database\QueryException $e) {
            $softDelOk = false;
            return response()->json(['error' => 'SORRY! Something went wrong!']);
        }
        if ($softDelOk) {
            // log
            Webspice::log($this->table, $id, "Data soft-deleted successfully!");
            return response()->json([
                'status'=>200,
                'message'=>'The vendor has been removed!',
            ]);
        }
    }
}