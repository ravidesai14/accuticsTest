<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Repositories\UserRepository;

class UserController extends Controller
{
    /**
     * @var UserRepository
     * 
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * return list of users by email
     * @param $request
     * @OA\Info(
     *      version="1.0",
     *      title="Accutics Backend Challenge api documentation"
     * ),
     * @OA\Server(
     *      url="http://localhost/accuticsTest/public/api/",
     *      description="Accutics Backend Challenge api documentation"
     * ),
     * @OA\Get(
     *     path="/users",
     *     tags = {"User"},
     *     summary="Search User by email",
     *     description="Search User by email",
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="search user by email",
     *          @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(
     *          response="401",
     *          description="Email is required"
     *     )
     * )
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required'
        ]);

        if ($validator->fails()) {
            $msgs = $validator->errors();
            return response()->json(['msg'=>$msgs->first()], 401);
        }

        $users = User::where('email','LIKE','%'.$request->input('email').'%')->simplePaginate(5);

        if($users->contains('name',$request->input('username')))
        {
            return response()->json($users, 200);
        }
        
        if($users->isEmpty())
        {
            $users = $this->userRepository->getUser();
        }

        return response()->json($users, 200);
    }
}
