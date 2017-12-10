<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Repositories\UserRepository;

class UserController extends Controller
{

    /**
     * @var UserRepository
     */
    private $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    public function update(UserRequest $request, $id)
    {
        $user = $this->user->find($id);

        $user->update($request->validated());

        return response()->json([
            'user' => $user
        ], 201);
    }
}
