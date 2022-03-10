<x-app-layout>
    <x-slot name="header">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a class="text-primary" href="{{ route('dashboard', app()->getLocale()) }}">{{__('Dashboard')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('Courses') }}</li>
            </ol>
        </nav>

    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(Route::currentRouteName() == 'course_update')
                    <p class="h3 underline">{{__('Update Course Data')}}</p>
                    @foreach($course as $courseData)
                    <form method="POST" action="{{ route('course_update', app()->getLocale()) }}" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="course_id" id="course_id" value="{{ $courseData->id }}">
                        <div class="mb-3">
                            <label for="category_id" class="form-label">{{__('Category')}}</label>
                            <select class="form-select" aria-label="Default category" id="category_id" name="category_id">
                                <option value="-1" @if(!isset($courseData->category_id)) selected @endif>{{__('Select category')}}</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" @if($category->id == $courseData->category_id) selected @endif >{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                            <p class="px-3 text-danger text-xs">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="row g-2 mb-3">
                        <div class="col-sm-4">
                            <label for="course_code" class="form-label">{{__('Course code')}}</label>
                            <input type="text" class="form-control" id="course_code" name="course_code" value="{{ $courseData->course_code }}">
                            @error('course_code')
                                <p class="px-3 text-danger text-xs">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-sm">
                            <label for="course_name" class="form-label">{{__('Course name')}}</label>
                            <input type="text" class="form-control" id="course_name" name="course_name" value="{{ $courseData->course_name }}">
                            @error('course_name')
                                <p class="px-3 text-danger text-xs">{{ $message }}</p>
                            @enderror
                        </div>
                        </div>
                        <div class="mb-3">
                            <label for="course_summery" class="form-label">{{__('Summery')}}</label>
                            <textarea type="text" class="form-control" id="course_summery" name="course_summery">{{ $courseData->course_summery }}</textarea>
                            @error('course_summery')
                            <p class="px-3 text-danger text-xs">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-sm">
                                <label for="course_sm_expert" class="form-label">{{__('SME')}}</label>
                                <select class="form-select" aria-label="Default user" id="course_sm_expert" name="course_sm_expert">
                                    <option value="-1" @if(!isset($courseData->course_sm_expert)) selected @endif>{{__('Select user')}}</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" @if($user->id == $courseData->course_sm_expert) selected @endif >{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                @error('course_sm_expert')
                                <p class="px-3 text-danger text-xs">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-sm-2"></div>
                            <div class="col-sm">
                            <label for="course_image" class="form-label">{{__('Course image')}}</label>
                            <input type="file" class="form-control" id="course_image" name="course_image" value="{{ old('course_image') }}">
                            <p>{{__("Choose new image file if you need to change the course image")}}</p>
                            @error('course_image')
                            <p class="px-3 text-danger text-xs">{{ $message }}</p>
                            @enderror
                        </div>
                        </div>
                        <div class="d-grid gap-2 col-6 mx-auto mt-5">
                            <button class="btn btn-outline-primary" type="submit">{{ __('Save the update') }}</button>
                        </div>
                    </form>
                        @endforeach
                    @else
                        <p class="h3 underline">{{__('Add New Course')}}</p>
                        <form method="POST" action="{{ route('manage_courses', app()->getLocale()) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="category_id" class="form-label">{{__('Category')}}</label>
                                <select class="form-select" aria-label="Default category" id="category_id" name="category_id">
                                    <option value="-1" @if(!old('category_id')) selected @endif>{{__('Select category')}}</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" @if($category->id == old('category_id')) selected @endif >{{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                <p class="px-3 text-danger text-xs">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="row g-2 mb-3">
                                <div class="col-sm-4">
                                    <label for="course_code" class="form-label">{{__('Course code')}}</label>
                                    <input type="text" class="form-control" id="course_code" name="course_code" value="{{ old('course_code') }}">
                                    @error('course_code')
                                    <p class="px-3 text-danger text-xs">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="col-sm">
                                    <label for="course_name" class="form-label">{{__('Course name')}}</label>
                                    <input type="text" class="form-control" id="course_name" name="course_name" value="{{ old('course_name') }}">
                                    @error('course_name')
                                    <p class="px-3 text-danger text-xs">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="course_summery" class="form-label">{{__('Summery')}}</label>
                                <textarea type="text" class="form-control" id="course_summery" name="course_summery">{{ old('course_summery') }}</textarea>
                                @error('course_summery')
                                <p class="px-3 text-danger text-xs">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="row g-2 mb-3">
                            <div class="col-sm">
                                <label for="course_sm_expert" class="form-label">{{__('SME')}}</label>
                                <select class="form-select" aria-label="Default user" id="course_sm_expert" name="course_sm_expert">
                                    <option value="-1" @if(!old('course_sm_expert')) selected @endif>{{__('Select user')}}</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" @if($user->id == old('course_sm_expert')) selected @endif >{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                @error('course_sm_expert')
                                <p class="px-3 text-danger text-xs">{{ $message }}</p>
                                @enderror
                            </div>
                                <div class="col-sm-2"></div>
                                <div class="col-sm">
                                    <label for="course_image" class="form-label">{{__('Course image')}}</label>
                                    <input type="file" class="form-control" id="course_image" name="course_image" value="{{ old('course_image') }}">
                                    @error('course_image')
                                    <p class="px-3 text-danger text-xs">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="d-grid gap-2 col-6 mx-auto mt-5">
                                <button class="btn btn-outline-primary" type="submit">{{ __('Save and add') }}</button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @if(Route::currentRouteName() != 'course_update')
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table id="dataTable" class="table table-hover">
                        <thead>
                        <tr>
                            <th scope="col">{{__('Course code')}}</th>
                            <th scope="col">{{__('Name')}}</th>
                            <th scope="col">{{__('Category')}}</th>
                            <th scope="col">{{__('SME')}}</th>
                            <th width="250px"> ... </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($courses as $course)
                            <tr>
                                <td>{{ $course->course_code }}</td>
                                <td>{{ $course->course_name }}</td>
                                <td>@if(isset($course->category_id)) {{ $course->category->category_name }} @endif</td>
                                <td>@if(isset($course->course_sm_expert)) {{ $course->expert->name }} @endif</td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                        <a class="btn btn-outline-success" href="{{ route('manage_topics', app()->getLocale()) }}?crsid={{ $course->id }}">{{__('Topics')}}</a>
                                        <a class="btn btn-outline-warning" href="{{ route('course_update', app()->getLocale()) }}?crsid={{ $course->id }}">{{__('Update')}}</a>
                                        <button class="btn btn-outline-danger" onclick="deleteAction('{{ route('course_delete', app()->getLocale()) }}?crsid={{ $course->id }}')">{{__('Delete')}}</button>

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
