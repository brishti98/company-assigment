<?php

namespace App\Http\Repositories;

use App\Http\Helpers\ApiResponseHelper;
use App\Models\Company;
use Exception;
use Illuminate\Support\Facades\Log;

class CompanyRepo {

    private $apiResponse, $paginate;

    public function __construct()
    {
        $this->apiResponse = new ApiResponseHelper;
        $this->paginate = config('services.api.pagination_limit');
    }

    public function list($params)
    {
        $limit = $this->paginate;

        $data = Company::with('category:id,title')
                        ->select('id', 'category_id', 'title', 'image', 'description', 'status')
                        ->orderBy('id', 'desc')
                        ->paginate($limit, page: $params['page']);

        return $this->apiResponse->getData($data);
    }

    public function getCompanyDetail($id)
    {
        $data = Company::with('category:id,title')->find($id);
        if (!$data)
            return $this->apiResponse->notFound();

        return $this->apiResponse->getData($data);
    }

    public function create($params)
    {
        try {
            $filePath = null;
            if (isset($params['image']) && $params['image']) {
                $image = $params['image'];
                $name = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('images/company/');
                $image->move($destinationPath, $name);
                $filePath = 'images/company/'.$name;
            }

            $data = [
                'title'       => $params['title'],
                'category_id' => $params['category_id'] ?? null,
                'image'       => $filePath,
                'description' => $params['description'],
                'status'      => 1
            ];

            $res = Company::create($data);
            Log::info('Add company: ', ['params'=>$data, 'result'=>$res]);
            return $this->apiResponse->create($res, 'Company added.');
        } catch (Exception $e) {
            Log::info('Add company error: '.$e->getMessage());
            return $this->apiResponse->errorMessage('Failed to add company details.');
        }

    }

    public function update($params)
    {
        $company = Company::find($params['id']);
        try {
            $data = [
                'title'       => $params['title'],
                'category_id' => $params['category_id'] ?? null,
                'description' => $params['description'] ?? null,
                'status'      => 1
            ];

            if (isset($params['image']) && $params['image']) {
                if ($company->image) {
                    $oldImagePath = public_path($company->image);
                    if (file_exists($oldImagePath))
                        unlink($oldImagePath);
                }
                $image = $params['image'];
                $name = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('images/company/');
                $image->move($destinationPath, $name);
                $data['image'] = 'images/company/'.$name;
            }

            $res = Company::where('id', $params['id'])
                            ->update($data);

            Log::info('Update company: ', ['params'=>$data, 'result'=>$res]);
            return $this->apiResponse->successMessage('Company details updated.');
        } catch (Exception $e) {
            Log::info('Update company error: '.$e->getMessage());
            return $this->apiResponse->updateError('Failed to update company details.');
        }
    }

    public function delete($id)
    {
        $company = Company::find($id);
        if (!$company)
            return $this->apiResponse->notFound();

        try {
            $res = Company::where('id', $id)->delete();

            if ($company->image) {
                $imagePath = public_path($company->image);
                if (file_exists($imagePath))
                    unlink($imagePath);
            }
            Log::info('Delete company:', ['id'=>$id, 'result'=>$res]);
            return $this->apiResponse->successMessage('Company details has been deleted.');
        } catch (Exception $e) {
            Log::info('Delete company error: '.$e->getMessage());
            return $this->apiResponse->updateError('Company cannot be deleted.');
        }
    }

}
