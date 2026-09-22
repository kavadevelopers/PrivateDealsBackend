<?php

namespace App\Http\Controllers\Web\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\ApiTokenForHeaderAuthModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\RedirectResponse;

class HeaderTokenController extends Controller
{
    function list(): View
    {
        setPageTitle('Tokens');
        $data['list'] = ApiTokenForHeaderAuthModel::where('is_deleted', '0')->orderby('id', 'desc')->get();
        return view('admin.pages.master.header-tokens', $data);
    }

    function create(): RedirectResponse
    {
        $apitoken = new ApiTokenForHeaderAuthModel();
        $token = Str::random(60);
        $apitoken->token =  $token;
        $apitoken->is_deleted = '0';
        $apitoken->save();

        Session::flash('success', 'Token Generated');
        return redirect()->back();
    }

    function delete($id): RedirectResponse
    {
        $apitoken = ApiTokenForHeaderAuthModel::find($id);
        if ($apitoken) {
            $apitoken->is_deleted = '1';
            $apitoken->save();
        }

        Session::flash('success', 'Token Not Found');
        return redirect()->back();
    }
}
