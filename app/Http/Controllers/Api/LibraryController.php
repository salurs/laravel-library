<?php

namespace App\Http\Controllers\Api;

use App\Helper\ResponseBuilder;
use App\Http\Controllers\Controller;
use App\Http\Requests\LibraryCreateRequest;
use App\Http\Requests\LibraryUpdateRequest;
use App\Models\Library;
use App\Services\LibraryService;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    public function __construct(public LibraryService $libraryService)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->libraryService->all();
        return ResponseBuilder::apiResponse(data: $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LibraryCreateRequest $request)
    {
        $validatedData = $request->only('user_id', 'name', 'city');
        $library = $this->libraryService->create($validatedData);
        if ($library)
            return ResponseBuilder::apiResponse(data: $library);
        return ResponseBuilder::apiResponse(status: false, message: 'Library hasnt created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $library = $this->libraryService->getById($id);
        if ($library)
            return ResponseBuilder::apiResponse(data: $library);
        return ResponseBuilder::apiResponse(status: false, message: 'Library Not Found');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LibraryUpdateRequest $request, Library $library)
    {
        $validatedData = $request->only('name', 'city');
        $isUpdated = $this->libraryService->setLibraryByLibrary($library)->update($validatedData);
        if ($isUpdated)
            return ResponseBuilder::apiResponse(data: $library);
        return ResponseBuilder::apiResponse(status: false, message: 'Library hasnt updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $isDeleted = $this->libraryService->delete($id);
        if ($isDeleted)
            return ResponseBuilder::apiResponse(message: 'Library has deleted');
        return ResponseBuilder::apiResponse(status: false, message: 'Library hasnt deleted');
    }
}
