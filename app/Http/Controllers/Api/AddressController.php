<?php

namespace App\Http\Controllers\Api;

use App\Helper\ResponseBuilder;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddressCreateRequest;
use App\Models\Address;
use App\Services\AddressService;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function __construct(public AddressService $addressService)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $this->addressService->all($request->all());
        return ResponseBuilder::apiResponse(data: $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddressCreateRequest $request)
    {
        $validatedData = $request->only('user_id', 'city', 'address');
        $address = $this->addressService->create($validatedData);
        if ($address)
            return ResponseBuilder::apiResponse(data: $address);
        return ResponseBuilder::apiResponse(status: false, message: 'Address hasnt created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $address = $this->addressService->getById($id);
        if ($address)
            return ResponseBuilder::apiResponse(data: $address);
        return ResponseBuilder::apiResponse(status: false, message: 'Address Not Found');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Address $address)
    {
        $validatedData = $request->only('city', 'address');
        $isUpdated = $this->addressService->setAddressByAdress($address)->update($validatedData);
        if ($isUpdated)
            return ResponseBuilder::apiResponse(data: $address);
        return ResponseBuilder::apiResponse(status: false, message: 'Address hasnt updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $isDeleted = $this->addressService->delete($id);
        if ($isDeleted)
            return ResponseBuilder::apiResponse(message: 'Address has deleted');
        return ResponseBuilder::apiResponse(status: false, message: 'Address hasnt deleted');
    }
}
