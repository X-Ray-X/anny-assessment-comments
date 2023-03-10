<?php

namespace App\JsonApi\V1;

use App\JsonApi\V1\Bookings\BookingSchema;
use App\JsonApi\V1\Comments\CommentSchema;
use App\JsonApi\V1\Comments\CommentScope;
use App\JsonApi\V1\Resources\ResourceSchema;
use App\JsonApi\V1\Users\UserSchema;
use App\Models\Comment;
use LaravelJsonApi\Core\Server\Server as BaseServer;

class Server extends BaseServer
{

    /**
     * The base URI namespace for this server.
     *
     * @var string
     */
    protected string $baseUri = '/api/v1';

    /**
     * Bootstrap the server when it is handling an HTTP request.
     *
     * @return void
     */
    public function serving(): void
    {
        Comment::addGlobalScope(new CommentScope());
    }

    /**
     * Get the server's list of schemas.
     *
     * @return array
     */
    protected function allSchemas(): array
    {
        return [
            ResourceSchema::class,
            BookingSchema::class,
            UserSchema::class,
            CommentSchema::class,
        ];
    }
}
