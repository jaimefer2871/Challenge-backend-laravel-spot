<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class UrlShortenerController extends Controller
{

    public function index(Request $request) {
        return response()->json(['data' => 'index']);
    }
    public function show(Request $request, $id) {
        return response()->json(['data' => "show $id"]);
    }
    public function update(Request $request, $id) {
        return response()->json(['data' => "update $id"]);
    }
    public function delete(Request $request, $id) {
        return response()->json(['data' => "delete $id"]);
    }
}
