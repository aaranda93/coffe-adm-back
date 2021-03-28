<?php

namespace App\Http\Controllers\V1;
use Illuminate\Http\Request;
use App\Http\Constants\ApiResponse as Api;
use App\Http\Controllers\Controller;
use App\Modelsl\Company;

class CompanyController extends Controller
{
    /**
     * Retrieve the user for the given ID.
     *
     * @param  int  $id
     * @return Response
     */
    public function index(Request $request)
    {
        $companies = Company::filter($request->all())
        ->get();

        return $this->response(Api::OK, $companies);
    }

    public function show($company_id)
    {
        $company = Company::find($company_id)
        ->first();

        return $this->response(Api::OK, $company);
    }

    public function store(StoreUser $request)
    {
        $newCompany = Company::create($request->all());

        return $this->response(Api::CREATED, $newCompany);
    }

    public function update(StoreUpdate $request, $company_id)
    {
        $company = Company::find($company_id);
        $company->update($request->all());

        return $this->response(Api::OK, $company);
    }

    public function destroy($company_id)
    {
       
        
    }
}