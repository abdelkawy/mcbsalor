<x-app-layout>
    <x-slot name="header">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a class="text-primary"
                                               href="{{ route('manage_courses', app()->getLocale()) }}">{{__('Courses')}}</a>
                </li>
                <li class="breadcrumb-item"><a class="text-primary"
                                               href="{{ route('manage_topics', app()->getLocale()) }}?crsid={{ request('crsid') }}">{{__('Topics')}}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('Learning Objects') }}</li>
            </ol>
        </nav>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(Route::currentRouteName() == 'object_update')
                        @foreach($object as $objectData)
                            <p class="h3 underline">{{__('Update Learning Object Data')}}</p>
                            <form method="POST"
                                  action="{{ route('object_update', app()->getLocale()) }}"
                                  enctype="multipart/form-data">
                                @csrf

                                <input type="hidden" name="object_id" id="object_id" value="{{ $objectData->id }}">
                                <div class="row g-lg-2 m-3">
                                    <div class="col">
                                        <label for="course_id" class="form-label">{{__('Course name')}}</label>
                                        <select class="form-select" aria-label="Default course" id="course_id"
                                                name="course_id">
                                            <option value="-1"
                                                    @if(!isset($objectData->course_id)) selected
                                                    @else disabled @endif>{{__('Select course')}}</option>
                                            @foreach($courses as $course)
                                                <option value="{{ $course->id }}"
                                                        @if($objectData->course_id == $course->id) selected
                                                        @else disabled @endif>{{ $course->course_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label for="topic_id" class="form-label">{{__('Topic name')}}</label>
                                        <select class="form-select" aria-label="Default topic" id="topic_id"
                                                name="topic_id">
                                            <option value="-1"
                                                    @if(!isset($objectData->topic_id)) selected
                                                    @else disabled @endif>{{__('Select topic')}}</option>
                                            @foreach($topics as $topic)
                                                <option value="{{ $topic->id }}"
                                                        @if($objectData->topic_id == $topic->id) selected
                                                        @else disabled @endif>{{ $topic->topic_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="m-3">
                                    <label for="object_name" class="form-label">{{__('Object name')}}</label>
                                    <input type="text" class="form-control" id="object_name" name="object_name"
                                           value="{{ $objectData->object_name }}">
                                    @error('object_name')
                                    <p class="px-3 text-danger text-xs">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="m-3">
                                    <label for="object_summery" class="form-label">{{__('Summery')}}</label>
                                    <textarea type="text" class="form-control" id="object_summery"
                                              name="object_summery">{{ $objectData->object_summery }}</textarea>
                                    @error('object_summery')
                                    <p class="px-3 text-danger text-xs">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="row g-lg-2 m-3">
                                    <div class="col">
                                        <label for="object_url" class="form-label">{{__('Object URL')}}</label>
                                        <input type="text" class="form-control" id="object_url" name="object_url"
                                               value="{{ $objectData->object_url }}">
                                        @error('object_url')
                                        <p class="px-3 text-danger text-xs">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col">
                                        <label for="object_file" class="form-label">{{__('Upload file')}}</label>
                                        <input type="file" class="form-control" id="object_file" name="object_file"
                                               value="{{ old('object_file') }}">
                                        @error('object_file')
                                        <p class="px-3 text-danger text-xs">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row g-lg-3 m-3">
                                    <div class="col">
                                        <label for="object_type" class="form-label">{{__('Object type')}}</label>
                                        <select class="form-select" aria-label="Default type" id="object_type"
                                                name="object_type">
                                            <option value="File"
                                                    @if($objectData->object_type == 'File') selected @endif>{{__('File')}}</option>
                                            <option value="Book"
                                                    @if($objectData->object_type == 'Book') selected @endif>{{__('Book')}}</option>
                                            <option value="Link"
                                                    @if($objectData->object_type == 'Link') selected @endif>{{__('Link')}}</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label for="object_format" class="form-label">{{__('Object format')}}</label>
                                        <select class="form-select" aria-label="Default format" id="object_format"
                                                name="object_format">
                                            <option value="pdf"
                                                    @if($objectData->object_format == 'pdf') selected @endif>{{__('PDF')}}</option>
                                            <option value="word"
                                                    @if($objectData->object_format == 'word') selected @endif>{{__('Word')}}</option>
                                            <option value="powerpoint"
                                                    @if($objectData->object_format == 'powerpoint') selected @endif>{{__('Powerpoint')}}</option>
                                            <option value="excel"
                                                    @if($objectData->object_format == 'excel') selected @endif>{{__('Excel')}}</option>
                                            <option value="video"
                                                    @if($objectData->object_format == 'video') selected @endif>{{__('Video')}}</option>
                                            <option value="audio"
                                                    @if($objectData->object_format == 'audio') selected @endif>{{__('Audio')}}</option>
                                            <option value="text"
                                                    @if($objectData->object_format == 'text') selected @endif>{{__('Text')}}</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label for="object_license" class="form-label">{{__('Usage license')}}</label>
                                        <select class="form-select" aria-label="Default license" id="object_license"
                                                name="object_license">
                                            <option value="Creative Commons"
                                                    @if($objectData->object_license == 'Creative Commons') selected @endif>{{__('Creative Commons')}}</option>
                                            <option value="Commercial"
                                                    @if($objectData->object_license == 'Creative Commons') selected @endif>{{__('Commercial')}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="d-grid gap-2 col-6 mx-auto">
                                    <button class="btn btn-outline-primary"
                                            type="submit">{{ __('Save the update') }}</button>
                                </div>
                            </form>
                        @endforeach
                    @else
                        <p class="h3 underline">{{__('Add New Learning Object')}}</p>
                        <form method="POST"
                              action="{{ route('manage_objects', app()->getLocale()) }}"
                              enctype="multipart/form-data">
                            @csrf

                            <div class="row g-lg-2 m-3">
                                <div class="col">
                                    <label for="course_id" class="form-label">{{__('Course name')}}</label>
                                    <select class="form-select" aria-label="Default course" id="course_id"
                                            name="course_id">
                                        <option value="-1"
                                                @if(!request('crsid')) selected
                                                @else disabled @endif>{{__('Select course')}}</option>
                                        @foreach($courses as $course)
                                            <option value="{{ $course->id }}"
                                                    @if(request('crsid') == $course->id) selected
                                                    @else disabled @endif>{{ $course->course_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="topic_id" class="form-label">{{__('Topic name')}}</label>
                                    <select class="form-select" aria-label="Default topic" id="topic_id"
                                            name="topic_id">
                                        <option value="-1"
                                                @if(!request('tid')) selected
                                                @else disabled @endif>{{__('Select topic')}}</option>
                                        @foreach($topics as $topic)
                                            <option value="{{ $topic->id }}"
                                                    @if(request('tid') == $topic->id) selected
                                                    @else disabled @endif>{{ $topic->topic_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="m-3">
                                <label for="object_name" class="form-label">{{__('Object name')}}</label>
                                <input type="text" class="form-control" id="object_name" name="object_name"
                                       value="{{ old('object_name') }}">
                                @error('object_name')
                                <p class="px-3 text-danger text-xs">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="m-3">
                                <label for="object_summery" class="form-label">{{__('Summery')}}</label>
                                <textarea type="text" class="form-control" id="object_summery"
                                          name="object_summery">{{ old('object_summery') }}</textarea>
                                @error('object_summery')
                                <p class="px-3 text-danger text-xs">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="row g-lg-2 m-3">
                                <div class="col">
                                    <label for="object_url" class="form-label">{{__('Object URL')}}</label>
                                    <input type="text" class="form-control" id="object_url" name="object_url"
                                           value="{{ old('object_url') }}">
                                    @error('object_url')
                                    <p class="px-3 text-danger text-xs">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col">
                                    <label for="object_file" class="form-label">{{__('Upload file')}}</label>
                                    <input type="file" class="form-control" id="object_file" name="object_file"
                                           value="{{ old('object_file') }}">
                                    @error('object_file')
                                    <p class="px-3 text-danger text-xs">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="row g-lg-3 m-3">
                                <div class="col">
                                    <label for="object_type" class="form-label">{{__('Object type')}}</label>
                                    <select class="form-select" aria-label="Default type" id="object_type"
                                            name="object_type">
                                        <option value="File"
                                                @if(old('object_type') == 'File') selected @endif>{{__('File')}}</option>
                                        <option value="Book"
                                                @if(old('object_type') == 'Book') selected @endif>{{__('Book')}}</option>
                                        <option value="Link"
                                                @if(old('object_type') == 'Link') selected @endif>{{__('Link')}}</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="object_format" class="form-label">{{__('Object format')}}</label>
                                    <select class="form-select" aria-label="Default format" id="object_format"
                                            name="object_format">
                                        <option value="pdf"
                                                @if(old('object_format') == 'pdf') selected @endif>{{__('PDF')}}</option>
                                        <option value="word"
                                                @if(old('object_format') == 'word') selected @endif>{{__('Word')}}</option>
                                        <option value="powerpoint"
                                                @if(old('object_format') == 'powerpoint') selected @endif>{{__('Powerpoint')}}</option>
                                        <option value="excel"
                                                @if(old('object_format') == 'excel') selected @endif>{{__('Excel')}}</option>
                                        <option value="video"
                                                @if(old('object_format') == 'video') selected @endif>{{__('Video')}}</option>
                                        <option value="audio"
                                                @if(old('object_format') == 'audio') selected @endif>{{__('Audio')}}</option>
                                        <option value="text"
                                                @if(old('object_format') == 'text') selected @endif>{{__('Text')}}</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="object_license" class="form-label">{{__('Usage license')}}</label>
                                    <select class="form-select" aria-label="Default license" id="object_license"
                                            name="object_license">
                                        <option value="Creative Commons"
                                                @if(old('object_license') == 'Creative Commons') selected @endif>{{__('Creative Commons')}}</option>
                                        <option value="Commercial"
                                                @if(old('object_license') == 'Creative Commons') selected @endif>{{__('Commercial')}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="d-grid gap-2 col-6 mx-auto m-5">
                                <button class="btn btn-outline-primary" type="submit">{{ __('Save and add') }}</button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @if(Route::currentRouteName() != 'object_update')
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <table id="dataTable" class="table table-hover">
                            <thead>
                            <tr>
                                <th scope="col">{{__('Name')}}</th>
                                <th scope="col">{{__('Type')}}</th>
                                <th scope="col">{{__('Format')}}</th>
                                <th scope="col">{{__('License')}}</th>
                                <th scope="col">{{__('File link')}}</th>
                                <th width="200px"> ...</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($objects as $object)
                                <tr>
                                    <td>{{ $object->object_name }}</td>
                                    <td>{{__($object->object_type)}}</td>
                                    <td>{{__(ucfirst(trans($object->object_format)))}} <i
                                            class="fa-solid fa-file-{{ $object->object_format }}"></i></td>
                                    <td>{{__($object->object_license)}}</td>
                                    <td>
                                        @if(isset($object->object_file))
                                            <a href="{{ asset('uploads/objects/'.$object->object_file) }}">{{ $object->object_file }}</a>
                                        @elseif(isset($object->object_url))
                                            <a href="{{ $object->object_url }}">{{ $object->object_url }}</a>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                            <a class="btn btn-outline-warning"
                                               href="{{ route('object_update', app()->getLocale()) }}?crsid={{ $object->course_id }}&oid={{ $object->id }}">{{__('Update')}}</a>
                                            <button class="btn btn-outline-danger"
                                                    onclick="deleteAction('{{ route('object_delete', app()->getLocale()) }}?crsid={{ $object->course_id }}&tid={{ $object->topic_id }}&oid={{ $object->id }}')">{{__('Delete')}}</button>

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
