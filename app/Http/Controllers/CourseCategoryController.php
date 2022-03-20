<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\Log;
use Illuminate\Database\QueryException;

class CourseCategoryController extends Controller
{

    public function store()
    {

        $formData = $this->getFormData();
        try {
            if (CourseCategory::create($formData)) {
                Log::create(['user_id' => auth()->id(), 'action' => 'Add', 'page' => 'categories', 'ip' => request()->ip(), 'message' => 'User added a new category']);
                return redirect(route('manage_categories', app()->getLocale()))->with('success', 'The new category has been added');
            }
            return back()->withInput();
        } catch (QueryException $exception) {
            return back()->withInput()->with('fail', 'There is an existed category for the same name');
        }

    }

    public function findCategory()
    {
        $category = CourseCategory::all()->where('id', '=', request('catid'));
        return view('manage.categories', [
            'category' => $category,
            'categories' => CourseCategory::all()
        ]);
    }

    public function updateCategory()
    {

        $formData = $this->getFormData();
        try {
            if (CourseCategory::where('id', '=', request('category_id'))->update($formData)) {
                Log::create(['user_id' => auth()->id(), 'action' => 'Update', 'page' => 'categories', 'ip' => request()->ip(), 'message' => 'User modified a category (' . request('category_id') . ') data ']);
                return redirect(route('manage_categories', app()->getLocale()))->with('success', 'The category has been updated');
            }
            return back()->withInput();
        } catch (QueryException $exception) {
            return redirect(route('manage_categories', app()->getLocale()))->with('fail', 'There is an existed category for the same name');
        }

    }

    public function deleteCategory()
    {
        try {
            $courses = Course::all()->where('category_id', '=', request('catid'));
            $cat = CourseCategory::all()->where('id', '=', request('catid'));
            $name = $cat[0]->category_name;
            if ($courses->count() <= 0) {
                CourseCategory::where('id', '=', request('catid'))->delete();
                Log::create(['user_id' => auth()->id(), 'action' => 'Delete', 'page' => 'categories', 'ip' => request()->ip(), 'message' => 'User deleted a category (' . $name . ')']);
                return redirect(route('manage_categories', app()->getLocale()))->with('success', 'The category ['.$name.'] has been deleted');
            }
            return back()->with('fail', 'The category cannot be deleted, because it has courses');
        } catch (QueryException $exception) {
            return back()->with('fail', 'The category is not deleted');
        }

    }

    public function getFormData(): array
    {
        return request()->validate([
            'parent_category' => 'required|numeric',
            'category_name' => 'required|max:255',
            'cat_description' => 'nullable',
        ]);
    }

}
