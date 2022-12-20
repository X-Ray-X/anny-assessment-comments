<?php

namespace App\JsonApi\V1\Bookings;

use LaravelJsonApi\Laravel\Http\Requests\ResourceQuery;
use LaravelJsonApi\Validation\Rule as JsonApiRule;

class BookingQuery extends ResourceQuery
{

    /**
     * Authorize the request.
     *
     * @return bool|null
     */
    public function authorize(): ?bool
    {
        /*if ($this->is('*-actions*')) {
            return (bool) optional($this->user())->can(
                'comment',
                $this->model()
            );
        }*/

        //return null;
        return true;
    }

    /**
     * Get the validation rules that apply to the request query parameters.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'fields' => [
                'nullable',
                'array',
                JsonApiRule::fieldSets(),
            ],
            'filter' => [
                'nullable',
                'array',
                JsonApiRule::filter()->forget('id'),
            ],
            'include' => [
                'nullable',
                'string',
                JsonApiRule::includePaths(),
            ],
            'page' => JsonApiRule::notSupported(),
            'sort' => JsonApiRule::notSupported(),
            'withCount' => [
                'nullable',
                'string',
                JsonApiRule::countable(),
            ],
        ];
    }
}
