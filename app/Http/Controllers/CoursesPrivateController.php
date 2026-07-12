<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class CoursesPrivateController extends Controller
{
    public function index()
    {
        $cources = Course::all()->with('teachers')->paginate(8);
        return view('coursesPrivate.index',compact('cources'));
    }

    public function show()
    {
        
    }

    public function create()
    {
        
    }

    public function store()
    {
        
    }
    
    public function edit()
    {
        
    }
    public function update()
    {
        
    }

    public function destroy()
    {
        
    }

}
