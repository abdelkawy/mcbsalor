<x-app-layout>
    <x-slot name="header">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a class="text-primary" href="{{ route('manage_courses', app()->getLocale()) }}">{{__('Courses')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('Topics') }}</li>
            </ol>
        </nav>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(Route::currentRouteName() == 'topic_update')
                        @foreach($topic as $topicData)
                            <p class="h3 underline">{{__('Update Topic Data')}}</p>
                            <form method="POST" action="{{ route('topic_update', [app()->getLocale(), 'crsid'=> request('crsid')]) }}">
                                @csrf

                                <input type="hidden" name="topic_id" id="topic_id" value="{{ $topicData->id }}">
                                <div class="m-3">
                                    <label for="course_id" class="form-label">{{__('Course name')}}</label>
                                    <select class="form-select" aria-label="Default course" id="course_id"
                                            name="course_id">
                                        <option value="-1"
                                                @if(!isset($topicData->course_id)) selected @else disabled @endif >{{__('Select course')}}</option>
                                        @foreach($courses as $course)
                                            <option value="{{ $course->id }}"
                                                    @if($topicData->course_id == $course->id) selected @else disabled @endif>{{ $course->course_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="m-3">
                                    <label for="topic_name" class="form-label">{{__('Topic Name')}}</label>
                                    <input type="text" class="form-control" id="topic_name" name="topic_name"
                                           value="{{ $topicData->topic_name }}">
                                    @error('topic_name')
                                    <p class="px-3 text-danger text-xs">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="m-3">
                                    <label for="topic_summery" class="form-label">{{__('Description')}}</label>
                                    <textarea type="text" class="form-control" id="topic_summery"
                                              name="topic_summery">{{ $topicData->topic_summery }}</textarea>
                                    @error('topic_summery')
                                    <p class="px-3 text-danger text-xs">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="d-grid gap-2 col-6 mx-auto">
                                    <button class="btn btn-outline-primary"
                                            type="submit">{{ __('Save the update') }}</button>
                                </div>
                            </form>
                        @endforeach
                    @else
                        <p class="h3 underline">{{__('Add New Topic')}}</p>
                        <form method="POST" action="{{ route('manage_topics', [app()->getLocale(), 'crsid'=> request('crsid')]) }}">
                            @csrf

                            <div class="m-3">
                                <label for="course_id" class="form-label">{{__('Course name')}}</label>
                                <select class="form-select" aria-label="Default course" id="course_id"
                                        name="course_id">
                                    <option value="-1"
                                            @if(!request('crsid')) selected @else disabled @endif>{{__('Select course')}}</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}"
                                                @if(request('crsid') == $course->id) selected @else disabled @endif>{{ $course->course_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="m-3">
                                <label for="topic_name" class="form-label">{{__('Topic name')}}</label>
                                <input type="text" class="form-control" id="topic_name" name="topic_name"
                                       value="{{ old('topic_name') }}">
                                @error('topic_name')
                                <p class="px-3 text-danger text-xs">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="m-3">
                                <label for="topic_summery" class="form-label">{{__('Description')}}</label>
                                <textarea type="text" class="form-control" id="topic_summery"
                                          name="topic_summery">{{ old('topic_summery') }}</textarea>
                                @error('topic_summery')
                                <p class="px-3 text-danger text-xs">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="d-grid gap-2 col-6 mx-auto">
                                <button class="btn btn-outline-primary" type="submit">{{ __('Save and add') }}</button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @if(Route::currentRouteName() != 'topic_update')
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">{{__('Name')}}</th>
                                <th scope="col">{{__('Description')}}</th>
                                <th scope="col">{{__('Course')}}</th>
                                <th width="300px"> ...</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($topics as $topic)
                                <tr>
                                    <th scope="row">{{ $topic->id }}</th>
                                    <td>{{ $topic->topic_name }}</td>
                                    <td>{{ $topic->topic_summery }}</td>
                                    <td>{{ $topic->course->course_name }}</td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                            <a class="btn btn-outline-success"
                                               href="{{ route('manage_objects', app()->getLocale()) }}?crsid={{ $topic->course_id }}&tid={{ $topic->id }}">{{__('Learning Objects')}}</a>
                                            <a class="btn btn-outline-warning"
                                               href="{{ route('topic_update', app()->getLocale()) }}?tid={{ $topic->id }}">{{__('Update')}}</a>
                                            <button class="btn btn-outline-danger"
                                                    onclick="deleteAction('{{ route('topic_delete', app()->getLocale()) }}?crsid={{ $topic->course_id }}&tid={{ $topic->id }}')">{{__('Delete')}}</button>

                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
</x-app-layout>
