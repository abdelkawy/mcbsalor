<x-app-layout>
    <x-slot name="header">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a class="text-primary" href="{{ route('home', app()->getLocale()) }}">{{__('Home')}}</a></li>
                <li class="breadcrumb-item"><a class="text-primary" href="{{ route('courses', app()->getLocale()) }}">{{__('Courses')}}</a></li>
                <li class="breadcrumb-item"><a class="text-primary" href="{{ route('topics', app()->getLocale()) }}?crsid={{ $course_id }}">{{ $course_code }}</a></li>
                <li class="breadcrumb-item" aria-current="page">{{ $topic_name }}</li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('Learning Objects') }}</li>
            </ol>
        </nav>
    </x-slot>
    <div class="album py-5 bg-light">
        <div class="container">

            <a href="#">
                <p class="h5">{{ $topic_name }}</p>
            </a>
            <p class="card-text">{{ $topic_summery }}</p>
            <div class="h3 text-center mt-3 p-2 border-bottom"> {{__('Learning Objects')}}</div>
            @if($objects->count() != 0)
                <div class="container overflow-hidden">
                    <div class="row gy-5">
                @foreach($objects as $object)

                                <div class="col-6">
                                    <div class="p-3 border bg-light">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">{{__('Object name')}}: <strong>{{ $object->object_name }}</strong></li>
                                            <li class="list-group-item">{{__('Summery')}}: <strong>{{ $object->object_summery }}</strong></li>
                                            <li class="list-group-item">{{__('Object type')}}: <strong>{{ __($object->object_type) }}</strong></li>
                                            <li class="list-group-item">{{__('Object format')}}: <strong>{{ __(ucfirst(trans($object->object_format))) }}</strong>
                                                <i class="fa-solid fa-file-{{ $object->object_format }}"></i>
                                            </li>
                                            <li class="list-group-item">{{__('Usage license')}}: <strong>{{ __($object->object_license) }}</strong></li>
                                            @if(isset($object->object_file))<li class="list-group-item">{{__('File link')}}: <strong><a href="{{ asset('uploads/objects/'.$object->object_file) }}">{{__('Click here to download')}} <i class="fa fa-download" aria-hidden="true"></i>
                                                    </a></strong></li>@endif
                                            @if(isset($object->object_url))<li class="list-group-item">{{__('Object URL')}}: <strong>{{ $object->object_url }}</strong></li>@endif
                                        </ul>

                                    </div>
                                </div>
                @endforeach
                    </div>
                </div>
            @else
                <div class="text-center text-warning w-full fs-3">{{__('No data found.')}}</div>
            @endif
        </div>
    </div>

</x-app-layout>
