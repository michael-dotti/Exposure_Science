<?php

namespace App\Http\Controllers\Admin;

// visto che il controller non si trova nella solita cartella, devo improtare il controller di base
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Course;

class CoursesController extends Controller
{
    public function index()
    {
        $cources = Course::with('teachers')->paginate(8);
        return view('admin.courses.index',compact('cources'));
    }

    public function show()
    {
        dd("TODO");
    }

    public function create()
    {
        dd("TODO");
    }

    public function store()
    {
        dd("TODO");
    }
    
    public function edit()
    {
        dd("TODO");
    }
    public function update()
    {
        dd("TODO");
    }

    public function destroy()
    {
        dd("TODO");
    }

}
