@extends('layouts.app',['title' => 'Vendor Profile'])

@section('content')
<div class="container">
<div class="mt-4 row justify-content-center">
    <div class="col-md-4 text-center">
        <img src="{{ asset('img/owner_photo').'/'.$vendor->owner_photo }}" width="250px" class="img-fluid rounded border border-3" alt="Owner Photo">
        <p>"{{$vendor->vendor_name}}" - Owner</p>
    </div>
    <div class="col-md-6">
    </div>
    <div class="col-md-2">
        <a href="{{route('vendor.index')}}" class="btn btn-success float-end"><i class="fa-solid fa-circle-arrow-left"></i> View All Vendor</a>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-12 px-5">
        <table class="mt-2 table table-bordered">
            <tbody>
                <tr class="">
                    <th class="fw-bold " width="25%">Vendor Name:</th>
                    <td class="">{{$vendor->vendor_name}}</td>
                </tr>
                <tr class="">
                    <th class="fw-bold ">Owner Name:</th>
                    <td class="">{{$vendor->owner_name}}</td>
                </tr>
                <tr class="">
                    <th class="fw-bold ">Owner Phone No:</th>
                    <td class="">{{$vendor->mobile_no}}</td>
                </tr>
                <tr class="">
                    <th class="fw-bold ">Vendor E-mail:</th>
                    <td class="">{{$vendor->email}}</td>
                </tr>
                <tr class="">
                    <th class="fw-bold ">Address:</th>
                    <td class="">{{$vendor->address}}</td>
                </tr>
                <tr class="">
                    <th class="fw-bold ">Contact Person Name:</th>
                    <td class="">{{$vendor->contact_person}}</td>
                </tr>
                <tr class="">
                    <th class="fw-bold ">Contact Person Phone No:</th>
                    <td class="">{{$vendor->contact_person_number}}</td>
                </tr>
                <tr class="">
                    <th class="fw-bold ">Commission Rate:</th>
                    <td class="">{{$vendor->commission_rate}}</td>
                </tr>
                <tr class="">
                    <th class="fw-bold ">Reference No:</th>
                    <td class="">{{$vendor->reference_no}}</td>
                </tr>
                <tr class="">
                    <th class="fw-bold ">TIN No:</th>
                    <td class="">{{$vendor->tin}}</td>
                </tr>
                <tr class="">
                    <th class="fw-bold ">Enlisted Date:</th>
                    <td class="">{{$vendor->enlisted_date}}</td>
                </tr>
                <tr class="">
                    <th class="fw-bold ">Material Commission Amount:</th>
                    <td class="">{{$vendor->material_commission_amount}}</td>
                </tr>
                <tr class="">
                    <th class="fw-bold ">Agreement Date:</th>
                    <td class="">{{$vendor->agreement_date}}</td>
                </tr>
                <tr class="">
                    <th class="fw-bold ">Status:</th>
                    <td class="">{{$vendor->status==7?'Active':'Inactive'}}</td>
                </tr>
                <tr class="">
                    <th class="fw-bold ">Agreement:</th>
                    <td class=""><a href="{{ asset('img/agreement').'/'.$vendor->agreement_attachment }}" class="btn btn-primary btn-sm" target="_blank">View Agreement</a></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

</div>
@endsection