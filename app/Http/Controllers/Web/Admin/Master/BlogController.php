<?php

namespace App\Http\Controllers\Web\Admin\Master;

use App\Helpers\AdminHelper;
use App\Helpers\CommonHelper;
use App\Helpers\FileUpDownHelper;
use App\Helpers\UtillsHelper;
use App\Http\Controllers\Controller;
use App\Models\MasterBlogModel;
use App\Traits\FileUploadTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class BlogController extends Controller
{
    use FileUploadTrait;

    public function index(): View
    {
        setPageTitle('Blog');
        $data['list'] = MasterBlogModel::where('is_deleted', '0')->orderby('id', 'desc')->get();
        addVendor('datatables');
        return view('admin.pages.cms.blog.list')->with($data);
    }

    public function create():View
    {
        setPageTitle('Create Blog');
        addVendor('tinymce');
        return view('admin.pages.cms.blog.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $blog = new MasterBlogModel();
        $validation = Validator::make($request->all(), [
            'blog_type' => [
                'required',
                'in:1,2',
            ],
            'title' => [
                'required',
                'string',

                Rule::unique($blog->getTable())->where(function ($query) use ($request) {
                    return $query->where('is_deleted', '0');
                }),
            ], 'banner' => 'required|image|mimes:' . CommonHelper::appSettings('file_image_extensions_allowed') . '|max:' . UtillsHelper::maxFileImageSizeInKB(),
            'short_description' => [
                'required',
            ],
            'long_description' => [
                'required',
            ],
            'display_order' => [
                'nullable',
                'integer',
                'min:1',
            ],
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withInput()
                ->with('error', $validation->errors()->first());
        }

        $blog->type = $request->blog_type;
        if ($request->hasFile('banner')) {
            $blog->banner = FileUpDownHelper::master_pages_blog_banner_upload($request->file('banner'));
        }
        $blog->title = strtolower($request->title);
        $blog->url_slug = AdminHelper::blogSlug(strtolower($request->title));
        $blog->short_description = $request->short_description;
        $blog->long_description = $request->long_description;
        $blog->display_order = $request->display_order;
        $blog->save();

        AdminHelper::logPut('Created cms blog', MasterBlogModel::class, $blog->id);

        return redirect()->route('admin.cms.blog.index')
            ->with('success', 'Blog created successfully.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id): View|RedirectResponse
    {
        $item = MasterBlogModel::where('is_deleted', '0')->find($id);
        if ($item) {
            setPageTitle('Edit Blog');
            $data['item'] = $item;
            $data['list'] = MasterBlogModel::where('is_deleted', '0')->orderby('id', 'desc')->get();
            addVendor('tinymce');
            return view('admin.pages.cms.blog.edit')->with($data);
        }

        return redirect()->route('admin.cms.blog.index')
            ->with('error', 'Item not found');
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $item = MasterBlogModel::where('is_deleted', '0')->find($id);
        if ($item) {
            $validation = Validator::make($request->all(), [
                'title' => [
                    'required',
                    'string',
                    Rule::unique($item->getTable())->where(function ($query) use ($item) {
                        return $query->where('is_deleted', '0')->where('id', '!=', $item->id);
                    }),
                ], 'banner' => 'nullable|image|mimes:' . CommonHelper::appSettings('file_image_extensions_allowed') . '|max:' . UtillsHelper::maxFileImageSizeInKB(),
                'short_description' => [
                    'required',
                ],
                'long_description' => [
                    'required',
                ],
                'display_order' => [
                    'nullable',
                    'integer',
                    'min:1',
                ],
            ]);
            if ($validation->fails()) {
                return redirect()->back()->withInput()
                    ->with('error', $validation->errors()->first());
            }

            $item->title = strtolower($request->title);
            if ($request->hasFile('banner')) {
                $this->deleteFile($item->banner);
                $item->banner = FileUpDownHelper::master_pages_banner_upload($request->file('banner'));
            }
            $item->url_slug = AdminHelper::blogSlug(strtolower($request->title), $item->id);
            $item->short_description = $request->short_description;
            $item->long_description = $request->long_description;
            $item->display_order = $request->display_order;
            $item->update();

            AdminHelper::logPut('Updated cms blog', MasterBlogModel::class, $item->id);

            return redirect()->route('admin.cms.blog.index')
                ->with('success', 'Blog updated successfully.');
        }

        return redirect()->route('admin.cms.blog.index')
            ->with('error', 'Item not found');
    }

    public function destroy(string $id): RedirectResponse
    {
        $item = MasterBlogModel::where('is_deleted', '0')->find($id);

        if ($item) {
            $this->deleteFile($item->banner);
            $item->is_deleted = '1';
            $item->update();

            AdminHelper::logPut('Deleted cms blog', MasterBlogModel::class, $item->id);

            return redirect()->route('admin.cms.blog.index')
                ->with('success', 'Blog deleted successfully.');
        }

        return redirect()->route('admin.cms.blog.index')
            ->with('error', 'Item not found');
    }
}
