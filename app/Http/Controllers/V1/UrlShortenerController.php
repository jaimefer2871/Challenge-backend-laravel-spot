<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\UrlShortenerService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/**
 * @OA\Info(title="API UrlShortener", version="1.0")
 */
class UrlShortenerController extends Controller
{
    protected UrlShortenerService $service;

    public function __construct(UrlShortenerService $urlShortenerService)
    {
        $this->service = $urlShortenerService;
    }

    /**
     * @OA\Get(
     *     path="/api/v1/urlshortener/",
     *     summary="List all url's",
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     @OA\JsonContent(
     *             @OA\Examples(example="200",value={"error":false,"code":200,"message":"OK","data":{{"id":3,"original":"https:\/\/www.aaa.com\/watch?v=1","shortened":"2dcd90df","created_at":"2024-11-23T15:56:43.000000Z","updated_at":"2024-11-23T15:56:43.000000Z"}}}, summary="An result object."),
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $output = [
            'error' => false,
            'code'  => 200,
            'message' => 'OK',
            'data' => []
        ];

        try {
            $output['data'] = $this->service->getList();
        } catch (\Exception $e) {
            $output['error'] = true;
            $output['code'] = 500;
            $output['message'] = $e->getMessage();
            $output['errors'] = $e->getTraceAsString();
        }

        return response()->json($output, $output['code']);
    }
    /**
     * @OA\Get(
     *     path="/api/v1/urlshortener/{id}",
     *     summary="show info url by id",
     *     @OA\Parameter(
     *         description="Parameters",
     *         in="path",
     *         name="id",
     *         @OA\Schema(type="int"),
     *         @OA\Examples(example="int", value="6", summary="int value"),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     @OA\JsonContent(
     *             @OA\Examples(example="200",value={"error":false,"code":200,"message":"OK","data":{"id":3,"original":"https:\/\/www.aaa.com\/watch?v=1","shortened":"2dcd90df","created_at":"2024-11-23T15:56:43.000000Z","updated_at":"2024-11-23T15:56:43.000000Z"}}, summary="successful"),
     *         )
     *     )
     * )
     */
    public function show(Request $request, $id)
    {
        $output = [
            'error' => false,
            'code'  => 200,
            'message' => 'OK',
            'data' => []
        ];

        try {
            $output['data'] = $this->service->getById($id);
        } catch (\Exception $e) {
            $output['error'] = true;
            $output['code'] = $e->getCode();
            $output['message'] = $e->getMessage();
            $output['errors'] = $e->getTraceAsString();
        }

        return response()->json($output, $output['code']);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/urlshortener/url/{code}",
     *     summary="get url by code",
     *     @OA\Parameter(
     *         description="Parameters",
     *         in="path",
     *         name="code",
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="string", value="ae123", summary="string value"),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     @OA\JsonContent(
     *             @OA\Examples(example="200",value={"error":false,"code":200,"message":"OK","data":{"original":"https:\/\/www.aaa.com\/watch?v=1"}, summary="successful"),
     *         )
     *     )
     * )
     */
    public function getUrlByCode(Request $request, $code)
    {
        $output = [
            'error' => false,
            'code'  => 200,
            'message' => 'OK',
            'data' => [
                'original' => null
            ]
        ];

        try {
            $result = $this->service->getByCode($code);

            if (!empty($result)) {
                $output['data']['original'] = $result->original;
            }
        } catch (\Exception $e) {
            $output['error'] = true;
            $output['code'] = 500;
            $output['message'] = $e->getMessage();
            $output['errors'] = $e->getTraceAsString();
        }

        return response()->json($output, $output['code']);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/urlshortener/",
     *     summary="Save url shortener",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="original",
     *                     type="string"
     *                 ),
     *                 example={"original": "https://laravel.com/docs/11.x/validation#rule-url"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="OK",
     *     @OA\JsonContent(
     *             @OA\Examples(example="200",value={"error":false,"code":201,"message":"OK","data":{"url":"https:\/\/laravel.com\/docs\/11.x\/validation#rule-url","shortened":"19a80c29"}}, summary="201 succesfull"),
     *         )
     *     )
     * )
     */
    public function create(Request $request)
    {
        $output = [
            'error' => false,
            'code'  => 201,
            'message' => 'OK',
            'data' => []
        ];

        try {
            $validator = Validator::make([
                'original' => $request->input('original'),
            ], [
                'original' => 'required|url:http,https',
            ]);

            $validator->validate();

            $result = $this->service->create($request->only('original'));

            if (!empty($result)) {
                $output['data'] = [
                    'url'       => $result['original'],
                    'shortened' => $result['shortened'],
                ];
            }
        } catch (ValidationException $ve) {
            $output['error'] = true;
            $output['code'] = $ve->status;
            $output['message'] = $ve->getMessage();
            $output['errors'] = $ve->errors();
        } catch (\Exception $e) {
            $output['error'] = true;
            $output['code'] = 500;
            $output['message'] = $e->getMessage();
            $output['errors'] = $e->getTraceAsString();
        }

        return response()->json($output, $output['code']);
    }
    /**
     * @OA\Delete(
     *   path="/api/v1/urlshortener/{id}",
     *   summary="Delete url by id",
     *   @OA\Parameter(
     *     description="Parameters",
     *     in="path",
     *     name="id",
     *     @OA\Schema(type="int"),
     *     @OA\Examples(example="int", value="6", summary="int value"),
     *   ),
     *   @OA\Response(
     *      response=200,
     *      description="OK",
     *      @OA\JsonContent(
     *          @OA\Examples(example="200",value={"error":false,"code":200,"message":"OK","data":{"wasDeleted":1}}, summary="successful"),
     *      )
     *   ),
     * )
     */
    public function delete(Request $request, $id)
    {
        $output = [
            'error' => false,
            'code'  => 200,
            'message' => 'OK',
            'data' => []
        ];

        try {
            $output['data']['wasDeleted'] = $this->service->delete($id);
        } catch (\Exception $e) {
            $output['error'] = true;
            $output['code'] = $e->getCode();
            $output['message'] = $e->getMessage();
            $output['errors'] = $e->getTraceAsString();
        }

        return response()->json($output, $output['code']);
    }
}
