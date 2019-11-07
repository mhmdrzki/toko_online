<?php

namespace App\Http\Controllers;

use App\Category;
use App\Type;
use Illuminate\Http\Request;
use File;
use Alert;

class CategoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Bisnis';
        $categories = Category::paginate(15);
        return view('categories.index', compact('categories','title'));
    }

    public function getType(Request $request)
    {
        $id = $request->id;
        $types = Type::find($id);
        echo json_encode($types);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required',
            'photo' => 'image|mimes:jpeg,png,gif,webp|max:2048',
        ]);

        $category = new Category;
        $category->category = $request->category;
        $category->photo = $this->setImageUpload($request->file('photo'),'img/categories');
        $category->save();

        Alert::success('Category berhasil ditambahkan', 'berhasil');
        return redirect('/categories');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = 'Bisnis';
        $category = Category::find($id);
        $types = Type::where('category_id', $id)->get();
        return view('categories.edit', compact('category','types','title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = Category::find($id);

        $request->validate([
            'category' => 'required',
            'photo' => 'image|mimes:jpeg,png,gif,webp|max:2048'
        ]);

        if ($request->file('photo')) {
            $category->photo = $this->setImageUpload($request->file('photo'), 'img/categories',$category->photo);
        }
        
        $category->category = $request->category;
        $category->save();

        Alert::success('Category berhasil diperbarui', 'berhasil');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        File::delete(public_path('img/categories/' . $category->photo));
        Category::destroy($id);

        Alert::success('Category berhasil dihapus', 'berhasil');
        return redirect('/categories');
    }
}
