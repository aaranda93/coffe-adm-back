<?php

namespace App\Http\Controllers\V1;
use Illuminate\Http\Request;
use App\Http\Requests\Companies\Index as IndexCompany;
use App\Http\Requests\Companies\Show as ShowCompany;
use App\Http\Constants\ApiResponse as Api;
use App\Http\Controllers\Controller;
use App\Models\Company;

class CompanyController extends Controller
{
    /**
     * Retrieve the user for the given ID.
     *
     * @param  int  $id
     * @return Response
     */
    public function index(IndexCompany $request)
    {
        $companies = Company::get();

        return $this->response(Api::OK, $companies);
    }

    public function show(ShowCompany $reques, $company_id)
    {
        $company = Company::find($company_id);

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