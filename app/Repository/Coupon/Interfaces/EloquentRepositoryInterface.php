<?php

namespace App\Repository\Coupon\Interfaces;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;

/**
 * Interface EloquentRepositoryInterface
 * @package App\Repositories
 */
interface EloquentRepositoryInterface
{
    /**
     * @param array $data
     * @param string|null $scope
     * @param array|null $scopeIds
     * @return mixed
     */
    public function create(array $data, string $scope = null, array $scopeIds = null);

    /**
     * @param string $json
     * @return array
     */
    public function jsonDecode(string $json): array;

    /**
     * @param $id
     * @return Model
     */
    public function find($id): Model;

    /**
     * @param $data
     * @param int $statusCode
     * @return JsonResponse
     */
    public function jsonResponse($data, int $statusCode = Response::HTTP_OK): JsonResponse;

    /**
     * @param $message
     * @param int $status
     * @return HttpResponseException
     */
    public function jsonErrorResponse($message, int $status = Response::HTTP_NOT_FOUND): HttpResponseException;

    /**
     * @param Builder $builder
     * @param $attribute
     * @param $value
     * @param $id
     * @return mixed
     */
    public function updateAttribute(Model $model, $attribute, $value);


    /**
     * @param Builder $builder
     * @param $attribute
     * @param $operator
     * @param $value
     * @return Builder
     */
    public function findByAttribute($attribute, $operator, $value): Model;
}
