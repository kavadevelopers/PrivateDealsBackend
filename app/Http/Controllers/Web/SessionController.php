<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function restore(Request $request)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Session restored successfully.'
        ]);
    }
}
