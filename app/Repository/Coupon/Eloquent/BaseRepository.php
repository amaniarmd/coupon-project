<?php

namespace App\Repository\Coupon\Eloquent;

use App\Enums\Fields;
use App\Enums\OutputMessages;
use App\Repository\Coupon\Interfaces\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class BaseRepository implements EloquentRepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function create(array $data,string $scope = null,array $scopeIds = null)
    {
        $model = $this->model::create($data);

        if(!is_null($scope)){
            $model->$scope()->attach($scopeIds);
        }

        return $model;
    }

    public function jsonDecode(string $json): array
    {
        return json_decode($json, true, 512, JSON_THROW_ON_ERROR);
    }

    public function updateAttribute(Model $model, $attribute, $value)
    {
        $model->$attribute = $value;
        $model->save();
    }

    public function find($id): Model
    {
        $model = $this->model->find($id);

        if (is_null($model)) {
            $this->jsonErrorResponse("$this->model not found");
        }

        return $model;
    }

    public function jsonErrorResponse($message, int $status = Response::HTTP_NOT_FOUND): HttpResponseException
    {
        throw new HttpResponseException(
            $this->jsonResponse([
                'error' => $message,
            ], $status)
        );
    }

    public function jsonResponse($data, int $statusCode = Response::HTTP_OK): JsonResponse
    {
        return response()->json($data, $statusCode);
    }

    /**
     * @param $attribute
     * @param $value
     * @return Model|null
     */
    public function findByAttribute($attribute, $operator, $value): Model
    {
        $record = $this->model->where($attribute, $operator, $value)->first();

        if (is_null($record)) {
            $this->jsonErrorResponse(OutputMessages::RECORD_NOT_FOUND);
        }

        return $record;
    }
}
