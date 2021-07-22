<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Campaign;
use App\Models\Input;

class CampaignController extends Controller
{
    /**
     * return list of campaigns
     * @param $request
     * @OA\Get(
     *     path="/campaigns",
     *     tags = {"Campaign"},
     *     summary="list of campaigns sort by input type",
     *     description="list of campaigns sort by input type",
     *     @OA\Parameter(
     *         name="sortByType",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="list of campaigns sort by input type",
     *          @OA\JsonContent(ref="#/components/schemas/Campaign")
     *     )
     * )
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $orderByRaw = 'campaigns.created_at desc';
        if($request->input('sortByType'))
        {
            $orderByRaw = "FIELD(inputs.type, '".$request->input('sortByType')."') desc,inputs.value asc";
        }

        $campaigns = Campaign::has('inputs')->with('inputs','user')->select(['campaigns.*'])->leftJoin('inputs', 'campaigns.id', '=', 'inputs.campaign_id')->orderByRaw($orderByRaw)->simplePaginate(50);
        $campaigns = $campaigns->unique('id')->values()->all();
        return response()->json($campaigns, 200);
    }

    /**
     * create a campaign.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @OA\Post(
     *     path="/campaigns",
     *     tags = {"Campaign"},
     *     summary="create a campaign",
     *     description="create a campaign.",
     *     @OA\RequestBody(
     *         description="create a campaign",
     *         required=true,
     *             @OA\JsonContent(
     *                  @OA\Property(
     *                     property="user_id",
     *                     type="integer"   
     *                  ),
     *                  @OA\Property(
     *                     property="inputs",
     *                     type="array",
     *                     @OA\Items(ref="#/components/schemas/Input")   
     *                  )
     *             )
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="create a campaign",
     *          @OA\JsonContent(ref="#/components/schemas/Campaign")
     *     ),
     *     @OA\Response(
     *          response="401",
     *          description="user is required"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'inputs' => 'required',
            'inputs.0.type' => 'required|string|in:channel',
            'inputs.1.type' => 'required|string|in:source',
            'inputs.2.type' => 'required|string|in:campaign_name',
            'inputs.3.type' => 'required|string|in:target_url',
            'inputs.*.value' => 'required|string',
        ]);

        if ($validator->fails()) {
            $msgs = $validator->errors();
            return response()->json(['msg'=>$msgs->first()], 401);
        }

        $campaigns = Campaign::create([
            "user_id" => $request->user_id
        ]);

        foreach ($request->inputs as $input) {
            $inputsData[] = New Input(['campaign_id' => $campaigns->id,'type' => $input['type'],'value' => $input['value']]);
        }

        $campaigns->inputs()->saveMany($inputsData);

        return response()->json($campaigns, 201);
    }
}
