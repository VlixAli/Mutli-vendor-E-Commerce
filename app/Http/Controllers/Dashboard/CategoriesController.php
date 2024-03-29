<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if (!Gate::allows('categories.view')){
            abort(403);
        }
        $categories = Category::with('parent')
//        leftJoin('categories as parents', 'parents.id', '=', 'categories.parent_id')
//            ->select([
//                'categories.*',
//                'parents.name as parent_name'
//            ])
//            ->select('categories.*')
//            ->selectRaw('(select count(*) from products where category_id = categories.id) as products_count')
            ->withCount([
                'products as products_count' => function ($query) {
                    $query->where('status' , '=' , 'active');
                }
            ])
            ->filter($request->query())
            ->orderBy('categories.name')
            ->paginate()->withQueryString();
        return view('dashboard.categories.index', [
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Gate::denies('categories.create')){
            abort(403);
        }
        $parents = Category::all();
        $category = new Category();
        return view('dashboard.categories.create', [
            'parents' => $parents,
            'category' => $category
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('categories.create');

        $request->validate(Category::rules(), [
            'name.required' => 'This field (:attribute) is required',
            'name.unique' => 'this name already exists!'
        ]);

        $request->merge([
            'slug' => Str::slug($request->post('name'))
        ]);
        $data = $request->except('image');
        $data['image'] = $this->uploadImage($request);

        $category = Category::create($data);

        return redirect()->route('dashboard.categories.index')
            ->with('success', 'Category created!');

    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        Gate::authorize('categories.view');

        return view('dashboard.categories.show' , [
            'category' => $category,
            'products' => $category->products()->with('store')->latest()->paginate(5)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        Gate::authorize('categories.update');

        try {
            $category = Category::findOrFail($id);
        } catch (Exception $e) {
            return redirect()->route('dashboard.categories.index')
                ->with('info', 'Record not found!');
        }

        $parents = Category::where('id', '<>', $id)
            ->where(fn($query) => $query->whereNull('parent_id')
                ->orWhere('parent_id', '<>', $id)
            )
            ->get();

        return view('dashboard.categories.edit', [
            'category' => $category,
            'parents' => $parents
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {
        $category = Category::findorFail($id);

        $old_image = $category->image;
        $data = $request->except('image');
        $newImage = $this->uploadImage($request);
        if ($newImage) {
            $data['image'] = $newImage;
        }

        $category->update($data);

        if ($old_image && $newImage) {
            Storage::disk('public')->delete($old_image);
        }

        return redirect()->route('dashboard.categories.index')
            ->with('success', 'Category updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        Gate::authorize('categories.delete');

        $category->delete();

        return redirect()->route('dashboard.categories.index')
            ->with('success', 'Category deleted!');
    }

    public function trash()
    {
        $categories = Category::onlyTrashed()->paginate();
        return view('dashboard.categories.trash', [
            'categories' => $categories
        ]);
    }

    public function restore(Request $request, $id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();

        return redirect()->route('dashboard.categories.trash')
            ->with('success', 'Category restored!');
    }

    public function forceDelete($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->forceDelete();

        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        return redirect()->route('dashboard.categories.trash')
            ->with('success', 'Category deleted forever!');
    }

    protected function uploadImage(Request $request)
    {
        if (!$request->hasFile('image')) {
            return null;
        }
        $file = $request->file('image');
        return $file->store('uploads', 'public');
    }
}

