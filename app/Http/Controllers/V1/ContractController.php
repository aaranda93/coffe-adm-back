<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Constants\ApiResponse as Api;
use App\Modelsl\Branch;

class ContractController extends Controller
{
    /**
     * Retrieve the user for the given ID.
     *
     * @param  int  $id
     * @return Response
     */

    public function store(Request $request, $branch_id)
    {
       try {

        $branch = Branch::findOrFail($branch_id);
        $branch->contract($request->user_id);

       } catch (\Exception $th) {
           
            return $this->response(Api::OK, $th->getMessage());
       }
        
    }
    public function destroy($product_id)
    {
       
        
    }
}