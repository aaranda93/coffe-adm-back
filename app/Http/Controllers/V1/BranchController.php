<?php

namespace App\Http\Controllers\V1;
use Illuminate\Http\Request;
use App\Http\Constants\ApiResponse as Api;
use App\Http\Controllers\Controller;
use App\Models\Branch;

class BranchController extends Controller
{
    /**
     * Retrieve the user for the given ID.
     *
     * @param  int  $id
     * @return Response
     */
    public function index(Request $request)
    {
        $companies = Branch::get();

        return $this->response(Api::OK, $companies);
    }

    public function show(Request $reques, $company_id)
    {
        $company = Branch::find($company_id);

        return $this->response(Api::OK, $company);
    }

    public function store(Request $request)
    {
        $newCompany = Branch::create($request->all());

        return $this->response(Api::CREATED, $newCompany);
    }

    public function update(Request $request, $company_id)
    {
        $company = Branch::find($company_id);
        $company->update($request->all());

        return $this->response(Api::OK, $company);
    }

    public function destroy($company_id)
    {
       
        
    }
}