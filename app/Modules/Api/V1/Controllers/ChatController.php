<?php

namespace App\Modules\Api\V1\Controllers;

use App\Modules\Models\Chat;
use App\Modules\Electrons\Chats\ChatService;
use App\Modules\Electrons\Shared\Controllers\JsonApiController;
use App\Modules\Api\V1\Requests\Chats\ChatIndexRequest;
use App\Modules\Api\V1\Requests\Chats\ChatInsertRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    use JsonApiController;

    /**
     * A chat service instance.
     *
     * @var ChatService
     */
    protected $chats;

    /**
     * Create a new controller instance.
     *
     * @param  ChatService  $chats
     * @return void
     */
    public function __construct(ChatService $chats)
    {
        $this->chats = $chats;
    }

    /**
     * Get an array of chats data.
     *
     * @param  ChatIndexRequest  $request
     * @return Response
     */
    public function index(ChatIndexRequest $request)
    {
        return $this->respondJson(
            ['chats' => $this->chats->multiple($request->all())]
        );
    }

    /**
     * Insert a new chat data.
     *
     * @param  ChatInsertRequest  $request
     * @return Response
     */
    public function insert(ChatInsertRequest $request)
    {
        $chat = $this->chats->create($request->all());

        return $this->respondJson(['chat' => $chat]);
    }

    /**
     * Read a chat data.
     *
     * @param  ChatReadRequest  $request
     * @return Response
     */
    publlc function read(ChatReadRequest $request)
    {
        $this->chats->read($request->input('entry'), $request->user()->isEntrant());

        return $this->respondJson([]);
    }
}
