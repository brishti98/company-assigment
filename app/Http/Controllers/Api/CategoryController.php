<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Repositories\CompanyCategoryRepo;

class CategoryController extends Controller
{
    private $categoryRepo;
    public function __construct()
    {
        $this->categoryRepo = new CompanyCategoryRepo;
    }

    public function list(Request $request)
    {
        $data['page'] = $request->page;
        $data['keyword'] = $request->keyword ?? null;
        $result = $this->categoryRepo->list($data);

        return response()->json($result,$result['statusCode']);
    }

    public function getCategoryDetail($id, Request $request)
    {
        $result = $this->categoryRepo->getCategoryDetail($id);

        return response()->json($result,$result['statusCode']);
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);
        $result = $this->categoryRepo->create($validated);

        return response()->json($result,$result['statusCode']);
    }

    public function update(Request $request, $id)
    {
        $request->merge(['id'=>$id]);
        $validated = $request->validate([
            'id'    => 'required|integer|exists:mysql.company_category,id',
            'title' => 'required|string|max:255',
        ]);

        $result = $this->categoryRepo->update($validated);

        return response()->json($result,$result['statusCode']);
    }

    public function delete($id)
    {
        $result = $this->categoryRepo->delete($id);

        return response()->json($result,$result['statusCode']);
    }

}
