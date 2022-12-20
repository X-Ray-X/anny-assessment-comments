<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\JsonApi\V1\Resources\ResourceQuery;
use App\JsonApi\V1\Resources\ResourceSchema;
use App\Models\Comment;
use App\Models\Resource;
use Illuminate\Contracts\Support\Responsable;
use LaravelJsonApi\Core\Document\Error;
use LaravelJsonApi\Core\Responses\DataResponse;
use LaravelJsonApi\Core\Responses\ErrorResponse;
use LaravelJsonApi\Laravel\Http\Controllers\Actions;
use Symfony\Component\HttpFoundation\Response;

class ResourceController extends Controller
{

    use Actions\FetchMany;
    use Actions\FetchOne;
    use Actions\Store;
    use Actions\Update;
    use Actions\Destroy;
    use Actions\FetchRelated;
    use Actions\FetchRelationship;
    use Actions\UpdateRelationship;
    use Actions\AttachRelationship;
    use Actions\DetachRelationship;

    public function comment(
        ResourceSchema $schema,
        ResourceQuery $query,
        Resource $resource
    ): Responsable
    {
        $this->authorize('comment', $resource);

        //abort_if($booking->published_at, 403, 'Post is already published.');

        //$booking->update(['published_at' => now()]);

        //PostPublished::dispatch($booking);

        try {
            $data = $query->validate(
                [
                    'comment' => ['required', 'string'],
                ]);
        } catch (\Exception $exception) {
            return (new ErrorResponse(Error::make()->setCode($exception->getCode())->setDetail($exception->getMessage())))
                ->withStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        /** @var Resource $model */
        $model = $schema
            ->repository()
            ->queryOne($resource)
            ->withRequest($query)
            ->first();

        /** @var Comment $comment */
        $comment = $model->comment($data['comment']);
        $comment->approve();

        return new DataResponse($model);
    }
}
