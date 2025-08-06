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
        $request->validate([
            'title'       => 'required|string|max:255',
            'image'       => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'integer|exists:mysql.company_category,id',
            'description' => 'string'
        ]);

        $data = $request->all();
        $result = $this->companyRepo->create($data);

        return response()->json($result,$result['statusCode']);
    }

    public function update(Request $request, $id)
    {
        $request->merge(['id'=>$id]);
        $request->validate([
            'id'          => 'required|integer|exists:mysql.company,id',
            'title'       => 'required|string|max:255',
            'image'       => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'integer|exists:mysql.company_category,id',
            'description' => 'string'
        ]);

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
