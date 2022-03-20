<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\Log;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Database\QueryException;

class CourseController extends Controller
{

    public function store()
    {
        $formData = $this->getFormData();
        $formData['course_sm_expert'] = auth()->id();
        if (isset($formData['course_image'])) {
            $fileName = $formData['course_code'] . '.' . request('course_image')->extension();
            request('course_image')->move('/var/www/html/lor/uploads/courses/', $fileName);
            $formData['course_image'] = $fileName;
        }
        try {
            if (Course::create($formData)) {
                Log::create(['user_id' => auth()->id(), 'action' => 'Add', 'page' => 'courses', 'ip' => request()->ip(), 'message' => 'User added a new course (' . $formData['course_code']  . ': ' . $formData['course_name'] . ')']);
                return redirect(route('manage_courses', app()->getLocale()))->with('success', 'The new course has been added');
            }
            return back()->withInput();
        } catch (QueryException $exception) {
            return back()->withInput()->with('fail', 'There is an existed course for the same name');
        }


    }

    public function findCourse()
    {
        $course = Course::all()->where('id', '=', request('crsid'));
        return view('manage.courses', [
            'course' => $course,
            'categories' => CourseCategory::all(),
            'users' => User::all()->whereIn('role', ['Editor', 'SME'])
        ]);
    }

    public function updateCourse()
    {

        $formData = $this->getFormData();

        if (isset($formData['course_image'])) {
            $fileName = $formData['course_code'] . '.' . request('course_image')->extension();
            request('course_image')->storeAs('/var/www/html/lor/uploads/courses/', $fileName);
            $formData['course_image'] = $fileName;
        }
        try {
            if (Course::where('id', request('course_id'))->update($formData)) {
                Log::create(['user_id' => auth()->id(), 'action' => 'Update', 'page' => 'courses', 'ip' => request()->ip(), 'message' => 'User modified a course (' . $formData['course_code']  . ': ' . $formData['course_name'] . ')']);
                return redirect(route('manage_courses', app()->getLocale()))->with('success', 'The course (' . $formData['course_code']  . ': ' . $formData['course_name'] . ') has been updated');
            }
            return back()->withInput();
        } catch (QueryException $exception) {
            return redirect(route('manage_courses', app()->getLocale()))->with('fail', 'There is an existed course for the same code/name');
        }

    }

    public function publishCourse()
    {
        $formData = array('is_publish' => 1);
        $course = Course::all()->where('id', '=', request('crsid'));
        foreach($course as $data){
        $code = $data->course_code;
        $name = $data->course_name;
        }
        try {
            if (Course::where('id', '=', request('crsid'))->update($formData)) {
                Log::create(['user_id' => auth()->id(), 'action' => 'Publish', 'page' => 'courses', 'ip' => request()->ip(), 'message' => 'User published a course (' . $code . ': ' . $name . ')']);
                return redirect(route('courses', app()->getLocale()))->with('success', 'The course (' . $code . ': ' . $name . ') has been published');
            }
            return back();
        } catch (QueryException $exception) {
            return redirect(route('courses', app()->getLocale()))->with('fail', 'Failed to publish the course (' . $code . ': ' . $name . ')');
        }

    }

    public function deleteCourse()
    {
        $course = Course::all()->where('id', '=', request('crsid'));
        //dd($course);
        $topics = Topic::all()->where('course_id', '=', request('crsid'));
        foreach($course as $data){
            $code = $data->course_code;
            $name = $data->course_name;
        }
        try {
            if ($topics->count() <= 0) {
                Course::where('id', '=', request('crsid'))->where('course_sm_expert', '=', auth()->id())->delete();
                Log::create(['user_id' => auth()->id(), 'action' => 'Delete', 'page' => 'courses', 'ip' => request()->ip(), 'message' => 'User deleted a course (' . $code . ': ' . $name . ')']);
                return redirect(route('manage_courses', app()->getLocale()))->with('success', 'The course (' . $code . ': ' . $name . ') has been deleted');
            }
            return back()->with('fail', 'The course (' . $code . ': ' . $name . ') cannot be deleted, because is has topics');
        } catch (QueryException $exception) {
            return back()->with('fail', 'The course has not been deleted');
        }

    }

    public function getFormData(): array
    {
        return request()->validate([
            'category_id' => 'required|numeric|min:1',
            'course_sm_expert' => 'required|numeric|min:1',
            'course_code' => 'required|max:255',
            'course_name' => 'required|max:255',
            'course_summery' => 'nullable|min:3',
            'course_image' => 'nullable|image|max:4096',
        ]);
    }
}
