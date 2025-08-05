<?php

namespace App\Http\Controllers\Api;

use App\Http\Repositories\CompanyRepo;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    private $companyRepo;
    public function __construct()
    {
        $this->companyRepo = new CompanyRepo;
    }

    public function list(Request $request)
    {
        $data = $request->all();
        $result = $this->companyRepo->list($data);

        return response()->json($result,$result['statusCode']);
    }

    public function getCompanyDetail($id)
    {
        $result = $this->companyRepo->getCompanyDetail($id);

        return response()->json($result,$result['statusCode']);
    }

    public function create(Request $request)
    {
        $data = $request->all();
        $result = $this->companyRepo->create($data);

        return response()->json($result,$result['statusCode']);
    }

    public function update($id, Request $request)
    {
        $data = $request->all();
        $data['id'] = $id;
        $result = $this->companyRepo->update($data);

        return response()->json($result,$result['statusCode']);
    }

    public function delete($id)
    {
        $result = $this->companyRepo->delete($id);

        return response()->json($result,$result['statusCode']);
    }


}
