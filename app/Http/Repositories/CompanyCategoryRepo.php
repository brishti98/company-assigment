<?php

namespace App\Http\Repositories;

use App\Models\CompanyCategory;
use App\Http\Helpers\ApiResponseHelper;
use Exception;
use Illuminate\Support\Facades\Log;

class CompanyCategoryRepo {

    private $apiResponse, $paginate;

    public function __construct()
    {
        $this->apiResponse = new ApiResponseHelper;
        $this->paginate = config('services.api.pagination_limit');
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
        try {
            $data['title'] = $params['title'];
            $add = CompanyCategory::create($data);
            Log::info('Add company category: ',['params'=>$data,'id'=>$add->id]);

            return $this->apiResponse->create($add, 'Company category added.');
        } catch (Exception $e) {
            Log::info('Add company category error: '.$e->getMessage());
            return $this->apiResponse->errorMessage('Company category cannot be added.');
        }
    }

    public function update($params)
    {
        try {
            $data['title'] = $params['title'];

            $res = CompanyCategory::where('id', $params['id'])
                                    ->update($data);
            Log::info('Update company category: ',['params'=>$data,'result'=>$res]);

            return $this->apiResponse->successMessage('Company category updated.');
        } catch (Exception $e) {
            Log::info('Update company category error: '.$e->getMessage());
            return $this->apiResponse->updateError('Company category cannot be updated.');
        }
    }

    public function delete($id)
    {
        $category = CompanyCategory::find($id);
        if (!$category)
            return $this->apiResponse->notFound();

        try {
            $res = CompanyCategory::where('id', $id)->delete();
            Log::info('Delete company category: ',['id'=>$id, 'result'=>$res]);
            return $this->apiResponse->successMessage('Company category deleted.');
        } catch (Exception $e) {
            Log::info('Delete company category error: '.$e->getMessage());
            return $this->apiResponse->updateError('Company category cannot be deleted.');
        }
    }

}
