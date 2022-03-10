<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\LearningObject;
use App\Models\Log;
use App\Models\Topic;
use Illuminate\Database\QueryException;

class LearningObjectController extends Controller
{
    public function store()
    {

        $formData = $this->getFormData();
        $previousOrder = LearningObject::where('course_id', '=', $formData['course_id'])->where('topic_id', '=', $formData['topic_id'])->max('order');
        $formData['order'] = $previousOrder + 1;
        try {
            if (isset($formData['object_file'])) {
                $fileName = $formData['object_name'] . '.' . request('object_file')->extension();
                request('object_file')->move('/var/www/html/lor/uploads/objects/', $fileName);
                $formData['object_file'] = $fileName;
            }
            if (LearningObject::create($formData)) {
                Log::create(['user_id' => auth()->id(), 'action' => 'Add', 'page' => 'objects', 'ip' => request()->ip(), 'message' => 'User added a new object (' . $formData['object_name'] . ')']);
                return redirect(route('manage_objects', [app()->getLocale(), 'crsid' => $formData['course_id'], 'tid' => $formData['topic_id']]))->with('success', 'The new object has been added');
            }
            return back()->withInput();
        } catch (QueryException $exception) {
            return back()->withInput()->with('fail', 'There is an existed object for the same name');
        }

    }

    public function findObject()
    {
        $object = LearningObject::all()->where('id', '=', request('oid'));
        if(auth()->user()->role === 'Editor' || auth()->user()->role === 'Admin'){
            $courses = Course::all();
        }
        else
            $courses = Course::all()->where('course_sm_expert', '=', auth()->id());
        return view('manage.objects', [
            'object' => $object,
            'topics' => Topic::all()->where('course_id', '=', $object[0]['course_id']),
            'courses' => $courses
        ]);
    }

    public function updateObject()
    {

        $formData = $this->getFormData();
        try {
            if (isset($formData['object_file'])) {
                $fileName = $formData['object_name'] . '.' . request('object_file')->extension();
                request('object_file')->move('/var/www/html/lor/uploads/objects/', $fileName);
                $formData['object_file'] = $fileName;
            }
            if (LearningObject::where('id', '=', request('object_id'))->update($formData)) {
                Log::create(['user_id' => auth()->id(), 'action' => 'Update', 'page' => 'objects', 'ip' => request()->ip(), 'message' => 'User modified an object (' . $formData['object_name'] . ')']);
                return redirect(route('manage_objects', [app()->getLocale(), 'crsid' => $formData['course_id'], 'tid' => $formData['topic_id']]))->with('success', 'The object has been updated');
            }
            return back()->withInput();
        } catch (QueryException $exception) {
            return redirect(route('manage_objects', [app()->getLocale(), 'crsid' => $formData['course_id'], 'tid' => $formData['topic_id']]))->with('fail', 'The object has not been updated');
        }

    }

    public function deleteObject()
    {
        try {
            $object = LearningObject::all()->where('id', '=', request('oid'));
            if (LearningObject::where('id', '=', request('oid'))->delete()) {
                Log::create(['user_id' => auth()->id(), 'action' => 'Update', 'page' => 'objects', 'ip' => request()->ip(), 'message' => 'User deleted an object (' . $object[0]->object_name . ')']);
                return redirect(route('manage_objects', [app()->getLocale(), 'crsid' => request('crsid'), 'tid' => request('tid')]))->with('success', 'The object has been deleted');
            }
            return back()->with('fail', 'The object is not deleted');
        } catch (QueryException $exception) {
            return back()->with('fail', 'The object is not deleted');
        }
    }

    public function getFormData(): array
    {
        return request()->validate([
            'course_id' => 'required|numeric|min:1',
            'topic_id' => 'required|numeric|min:1',
            'object_name' => 'required|max:255',
            'object_url' => 'nullable|url|max:255',
            'object_type' => 'required|max:50',
            'object_format' => 'required|max:50',
            'object_license' => 'required|max:100',
            'object_file' => 'nullable|mimes:pdf,doc,docx,mp4,mp3,wav,gif,mpeg,mov,xls,xlsx,ppt,pptx|max:5020',
            'object_summery' => 'nullable'
        ]);
    }
}
