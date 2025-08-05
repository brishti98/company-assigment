<?php

namespace App\Http\Repositories;

use App\Models\CompanyCategory;
use App\Http\Helpers\ApiResponseHelper;
use Illuminate\Support\Facades\Validator;

class CompanyCategoryRepo {

    private $apiResponse, $paginate;

    public function __construct()
    {
        $this->apiResponse = new ApiResponseHelper;
        $this->paginate = config('services.api.pagination');
    }
    public function list($params)
    {
        $limit = $this->paginate;

        $data = CompanyCategory::select('id', 'title');

        if (!empty($params['keyword']))
            $data->where('title', 'LIKE', '%'.$params['keyword'].'%');

        $data = $data->orderBy('title', 'asc')
                    ->paginate($limit,page: $params['page']);

        return $this->apiResponse->getData($data);
    }

    public function getCategoryDetail($id)
    {
        $data = CompanyCategory::with('companies:id,title,category_id,description')->find($id);
        if (!$data)
            return $this->apiResponse->notFound();

        return $this->apiResponse->getData($data);
    }

    public function create($params)
    {
        $validation = Validator::make($params,[
            'title' => 'required|max:255',
        ]);

        if ($validation->fails()) {
            return $this->apiResponse->validationError($validation->errors()->all());
        }

        $data['title'] = $params['title'];

        $add = CompanyCategory::create($data);
        if (!$add)
            return $this->apiResponse->errorMessage('Company category cannot be added.');

        return $this->apiResponse->create($add, 'Company category added.');
    }

    public function update($params)
    {
        $validation = Validator::make($params,[
            'id' => 'required|exists:mysql.company_category,id',
            'title' => 'required|max:255',
        ]);

        if ($validation->fails()) {
            return $this->apiResponse->validationError($validation->errors()->all());
        }

        $id = $params['id'];
        unset($params['id']);
        $data['title'] = $params['title'];

        $res = CompanyCategory::where('id', $id)
                                ->update($data);
        if (!$res)
            return $this->apiResponse->updateError('Company category cannot be updated.');

        return $this->apiResponse->successMessage('Company category updated.');
    }

    public function delete($id)
    {
        $res = CompanyCategory::where('id', $id)->delete();
        if (!$res)
            return $this->apiResponse->updateError('Company category cannot be deleted.');

        return $this->apiResponse->successMessage('Company category deleted.');
    }

    public function keywordDetails()
    {

    }
}
