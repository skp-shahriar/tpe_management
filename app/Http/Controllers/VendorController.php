<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('master_data.vendor_list');
    }

    public function fetchVendorTable()
    {
        $vendor=Vendor::get();
        return response()->json($vendor);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master_data.vendor_create');
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
            Vendor::create($data);
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
        $vendor=Vendor::find($id);
        return view('master_data.vendor_details',compact('vendor'));
    }

    public function statusSwitch(Request $request)
    {
        if ($request->status=='active') {
            Vendor::where('id', $request->id)->update(['status' => 7]);

            return response()->json([
                'status'=>'active',
                'message'=>'Vendor status changed to Active',
            ]);
        }else{
            Vendor::where('id', $request->id)->update(['status' => -7]);

            return response()->json([
                'status'=>'inactive',
                'message'=>'Vendor status changed to Inactive',
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
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

            Vendor::find($id)->update($data);
            return response()->json([
                    'status'=>200,
                    'message'=> 'Vendor Edited Successfully!'
            ]);
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
        Vendor::where('id', $id)->update(['status' => -1]);

        return response()->json([
            'status'=>200,
            'message'=>'The vendor has been removed!',
        ]);
    }
}