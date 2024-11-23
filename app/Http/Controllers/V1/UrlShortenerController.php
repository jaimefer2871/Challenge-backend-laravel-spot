<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\UrlShortenerService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UrlShortenerController extends Controller
{
    protected UrlShortenerService $service;

    public function __construct(UrlShortenerService $urlShortenerService)
    {
        $this->service = $urlShortenerService;
    }

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
            $output['code'] = $e->getCode();
            $output['message'] = $e->getMessage();
            $output['errors'] = $e->getTraceAsString();
        }

        return response()->json($output, $output['code']);
    }

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

    public function create(Request $request)
    {
        $output = [
            'error' => false,
            'code'  => 200,
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
