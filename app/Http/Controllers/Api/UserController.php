<?php

namespace App\Http\Controllers\Api;

use App\Helper\ResponseBuilder;
use App\Http\Controllers\Controller;
use App\Http\Requests\AssignLibraryCreateRequest;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(public UserService $userService)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $this->userService->all($request->all());
        return ResponseBuilder::apiResponse(data: $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserCreateRequest $request)
    {
        $validatedData = $request->only('name', 'email');
        $user = $this->userService->create($validatedData);
        if ($user)
            return ResponseBuilder::apiResponse(data: $user);
        return ResponseBuilder::apiResponse(status: false, message: 'User hasnt created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = $this->userService->getById($id);
        if ($user)
            return ResponseBuilder::apiResponse(data: $user);
        return ResponseBuilder::apiResponse(status: false, message: 'User Not Found');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $validatedData = $request->only('name', 'email');
        $isUpdated = $this->userService->setUserByUser($user)->update($validatedData);
        if ($isUpdated)
            return ResponseBuilder::apiResponse(data: $user);
        return ResponseBuilder::apiResponse(status: false, message: 'User hasnt updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $isDeleted = $this->userService->delete($id);
        if ($isDeleted)
            return ResponseBuilder::apiResponse(message: 'User has deleted');
        return ResponseBuilder::apiResponse(status: false, message: 'User hasnt deleted');
    }

    public function assignLibraryStore(AssignLibraryCreateRequest $request)
    {
        $validatedData = $request->only('user_id', 'library_id');
        $result = $this->userService->assignLibrary($validatedData);
        return ResponseBuilder::apiResponse(status: $result['status'], message: $result['message']);
    }
}
