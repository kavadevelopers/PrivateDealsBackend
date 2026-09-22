<?php

namespace App\Http\Controllers\Web\Admin;

use App\Helpers\AdminHelper;
use App\Http\Controllers\Controller;
use App\Models\ApiClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AdminApiClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        setPageTitle('Api Clients');
        $data['list'] = ApiClient::where('is_deleted', '0')->get();
        addVendor('datatables');
        return view('admin.pages.api-clients.list')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        setPageTitle('Create Api Clients');
        addVendor('tinymce');
        return view('admin.pages.api-clients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'nullable',
            'allowed_domains' => 'required',
            'is_ai' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withInput()
                ->with('error', $validator->errors()->first());
        }

        $token = null;
        do {
            $token = Str::random(80);
        } while (ApiClient::where('token', $token)->exists());

        $client = new ApiClient();
        $client->name = $request->name;
        $client->description = $request->description;
        $client->allowed_domains = $request->allowed_domains;
        $client->is_ai = $request->boolean('is_ai');
        $client->token = $token;

        $client->save();

        return redirect()->route('admin.systemConfiguration.apiclient.index')
            ->with('success', 'API Client created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $uuid)
    {
        $item = ApiClient::where('uuid', $uuid)->where('is_deleted', '0')->first();

        if ($item) {
            setPageTitle('Edit API Client');

            $data['item'] = $item;
            $data['list'] = ApiClient::where('is_deleted', '0')->orderBy('id', 'desc')->get();

            addVendor('tinymce');
            return view('admin.pages.api-clients.edit')->with($data);
        }

        return redirect()->route('admin.systemConfiguration.apiclient.index')
            ->with('error', 'API Client not found');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $uuid)
    {
        $client = ApiClient::where('uuid', $uuid)->first();

        if (!$client) {
            return redirect()->route('admin.systemConfiguration.apiclient.index')
                ->with('error', 'API Client not found.');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'nullable',
            'allowed_domains' => 'required',
            'is_ai' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withInput()
                ->with('error', $validator->errors()->first());
        }

        $client->name = $request->name;
        $client->description = $request->description;
        $client->allowed_domains = $request->allowed_domains;
        $client->is_ai = $request->boolean('is_ai');
        $client->save();

        AdminHelper::logPut('Updated API client', ApiClient::class, $client->id);

        return redirect()->route('admin.systemConfiguration.apiclient.index')
            ->with('success', 'API Client updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $uuid)
    {
        $client = ApiClient::where('uuid', $uuid)->first();

        if ($client) {
            $client->is_deleted = '1';
            $client->update();

            AdminHelper::logPut('Deleted API client', ApiClient::class, $client->id);

            return redirect()->route('admin.systemConfiguration.apiclient.index')
                ->with('success', 'API Client deleted successfully.');
        }

        return redirect()->route('admin.systemConfiguration.apiclient.index')
            ->with('error', 'API Client not found.');
    }
}
