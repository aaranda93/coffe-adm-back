<?php

namespace App\Http\Controllers\V1;
use Illuminate\Http\Request;
use App\Http\Requests\Products\Store as StoreProduct;
use App\Http\Requests\Products\Update as UpdateProduct;
use App\Http\Requests\Products\Index as IndexProduct;
use App\Http\Requests\Products\Show as ShowProduct;
use App\Http\Constants\ApiResponse as Api;
use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Retrieve the user for the given ID.
     *
     * @param  int  $id
     * @return Response
     */
    public function index(IndexProduct $request)
    {
        $branches = Product::get();

        return $this->response(Api::OK, $branches);
    }

    public function show(ShowProduct $reques, $branch_id)
    {
        $branch = Product::find($branch_id);

        return $this->response(Api::OK, $branch);
    }

    public function store(StoreProduct $request)
    {
        $newbranch = Product::create($request->all());

        return $this->response(Api::CREATED, $newbranch);
    }

    public function update(UpdateProduct $request, $branch_id)
    {
        $branch = Product::find($branch_id);
        $branch->update($request->all());

        return $this->response(Api::OK, $branch);
    }

    public function destroy($branch_id)
    {
       
        
    }
}