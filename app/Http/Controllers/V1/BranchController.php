<?php

namespace App\Http\Controllers\V1;
use Illuminate\Http\Request;
use App\Http\Requests\Branches\Store as StoreBranch;
use App\Http\Requests\Branches\Update as UpdateBranch;
use App\Http\Requests\Branches\Index as IndexBranch;
use App\Http\Requests\Branches\Show as ShowBranch;
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
    public function index(IndexBranch $request)
    {
        $branches = Branch::get();

        return $this->response(Api::OK, $branches);
    }

    public function show(ShowBranch $reques, $branch_id)
    {
        $branch = Branch::find($branch_id);

        return $this->response(Api::OK, $branch);
    }

    public function store(StoreBranch $request)
    {
        $newbranch = Branch::create($request->all());

        return $this->response(Api::CREATED, $newbranch);
    }

    public function update(UpdateBranch $request, $branch_id)
    {
        $branch = Branch::find($branch_id);
        $branch->update($request->all());

        return $this->response(Api::OK, $branch);
    }

    public function destroy($branch_id)
    {
       
        
    }
}