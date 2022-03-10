<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\LearningObject;
use App\Models\Log;
use App\Models\Topic;
use Illuminate\Database\QueryException;

class TopicController extends Controller
{
    public function store()
    {

        $formData = $this->getFormData();
        $previousOrder = Topic::where('course_id', '=', $formData['course_id'])->max('order');
        $formData['order'] = $previousOrder + 1;
        try {
            if (Topic::create($formData)) {
                Log::create(['user_id' => auth()->id(), 'action' => 'Add', 'page' => 'topics', 'ip' => request()->ip(), 'message' => 'User added a new topic (' . $formData['topic_name'] . ')']);
                return redirect(route('manage_topics', [app()->getLocale(), 'crsid' => $formData['course_id']]))->with('success', 'The new topic has been added');
            }
            return back()->withInput();
        } catch (QueryException $exception) {
            return back()->withInput()->with('fail', 'There is an existed topic for the same name');
        }

    }

    public function findTopic()
    {
        $topic = Topic::all()->where('id', '=', request('tid'));
        if(auth()->user()->role === 'Editor' || auth()->user()->role === 'Admin'){
            $courses = Course::all();
        }
        else{
            $courses = Course::all()->where('course_sm_expert', '=', auth()->id());
        }
        return view('manage.topics', [
            'topic' => $topic,
            'courses' => $courses
        ]);
    }

    public function updateTopic()
    {

        $formData = $this->getFormData();
        try {
            if (Topic::where('id', '=', request('topic_id'))->update($formData)) {
                Log::create(['user_id' => auth()->id(), 'action' => 'Update', 'page' => 'topics', 'ip' => request()->ip(), 'message' => 'User modified a topic (' . $formData['topic_name'] . ')']);
                return redirect(route('manage_topics', [app()->getLocale(), 'crsid' => $formData['course_id']]))->with('success', 'The topic has been updated');
            }
            return back()->withInput();
        } catch (QueryException $exception) {
            return redirect(route('manage_topics', [app()->getLocale(), 'crsid' => $formData['course_id']]))->with('fail', 'The topic has not been updated');
        }

    }

    public function deleteTopic()
    {
        try {
            $objects = LearningObject::all()->where('course_id', '=', request('crsid'))->where('topic_id', '=', request('tid'));
            $topic = Topic::all()->where('id', '=', request('tid'));
            if ($objects->count() <= 0) {
                Topic::where('id', '=', request('tid'))->delete();
                Log::create(['user_id' => auth()->id(), 'action' => 'Delete', 'page' => 'topics', 'ip' => request()->ip(), 'message' => 'User deleted a topic (' . $topic[0]->topic_name . ')']);
                return redirect(route('manage_topics', [app()->getLocale(), 'crsid' => request('crsid')]))->with('success', 'The topic has been deleted');
            }
            return back()->with('fail', 'The topic cannot be deleted, because it has learning objects');
        } catch (QueryException $exception) {
            return back()->with('fail', 'The category is not deleted');
        }

    }

    public function getFormData(): array
    {
        return request()->validate([
            'course_id' => 'required|numeric|min:1',
            'topic_name' => 'required|max:255',
            'topic_summery' => 'nullable'
        ]);
    }
}
