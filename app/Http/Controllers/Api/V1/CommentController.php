<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\JsonApi\V1\Comments\CommentQuery;
use App\JsonApi\V1\Comments\CommentSchema;
use App\Models\Comment;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\Auth;
use LaravelJsonApi\Core\Document\Error;
use LaravelJsonApi\Core\Responses\DataResponse;
use LaravelJsonApi\Core\Responses\ErrorResponse;
use LaravelJsonApi\Laravel\Http\Controllers\Actions;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends Controller
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

    public function reply(
        CommentSchema $schema,
        CommentQuery $query,
        Comment $comment
    ): Responsable
    {
        $this->authorize('reply', $comment);

        $validationRules = [
            'comment' => ['required', 'string'],
        ];

        if(Auth::user()) {
            $validationRules['is_internal'] = ['sometimes', 'bool'];
        }

        try {
            $data = $query->validate($validationRules);
        } catch (\Exception $exception) {
            return (new ErrorResponse(Error::make()->setCode($exception->getCode())->setDetail($exception->getMessage())))
                ->withStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        /** @var Comment $model */
        $model = $schema
            ->repository()
            ->queryOne($comment)
            ->withRequest($query)
            ->first();

        if(null !== $model->parent_id) {
            return (new ErrorResponse(Error::make()->setDetail('You can only post a reply to base level comments.')))
                ->withStatus(Response::HTTP_BAD_REQUEST);
        }

        /** @var Comment $reply */
        $reply = $model->comment($data['comment']);
        $reply->approve();

        if ($data['is_internal'] ?? null) {
            $reply->update(['is_internal' => $data['is_internal']]);
        }

        $reply->update(['parent_id' => $model->id]);

        return new DataResponse($model);
    }
}
