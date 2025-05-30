<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Interfaces\CategoryServiceInterface as CategoryService;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    private function config()
    {
        return [
            'js' => [
                '/backends/js/plugins/switchery/switchery.js',
            ],
            'css' => [
                '/backends/css/plugins/switchery/switchery.css'
            ]
        ];
    }

    public function index(Request $request)
    {
        $categories = $this->categoryService->getCategories($request);
        $config = $this->config();
        return view('backend.dashboard.layout', [
            'template' => 'backend.category.index',
            'categories' => $categories,
            'config' => $config
        ]);
    }

    public function create()
    {
        $parentCategories = $this->categoryService->getAllCategories();
        $config = $this->config();
        return view('backend.dashboard.layout', [
            'template' => 'backend.category.create',
            'parentCategories' => $parentCategories,
            'config' => $config
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'status' => 'required|in:active,inactive'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        
        $result = $this->categoryService->create($data);
        
        if($result) {
            return redirect()->route('admin.category.index')->with('success', 'Category created successfully');
        }
        return redirect()->back()->with('error', 'Failed to create category')->withInput();
    }

    public function edit($id)
    {
        $category = $this->categoryService->findById($id);
        if(!$category) {
            return redirect()->route('admin.category.index')->with('error', 'Category not found');
        }
        
        $parentCategories = $this->categoryService->getAllCategories();
        $config = $this->config();
        return view('backend.dashboard.layout', [
            'template' => 'backend.category.edit',
            'category' => $category,
            'parentCategories' => $parentCategories,
            'config' => $config
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'status' => 'required|in:active,inactive'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);

        $result = $this->categoryService->update($id, $data);
        
        if($result) {
            return redirect()->route('admin.category.index')->with('success', 'Category updated successfully');
        }
        return redirect()->back()->with('error', 'Failed to update category')->withInput();
    }

    public function delete($id)
    {
       $this->categoryService->delete($id);
    return redirect()->route('admin.category.index')->with('success', 'Category deleted successfully');
    }

    public function updateStatus(Request $request)
    {
        $id = $request->input('id');
        $status = $request->input('status');
        
        $result = $this->categoryService->update($id, ['status' => $status]);
        
        return response()->json(['success' => $result]);
    }
}