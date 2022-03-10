<x-app-layout>

    <x-slot name="header">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-primary" href="{{ route('home', app()->getLocale()) }}">{{__('Home')}}</a></li>
                    <li class="breadcrumb-item"><a class="text-primary" href="{{ route('courses', app()->getLocale()) }}">{{__('Courses')}}</a></li>
                    <li class="breadcrumb-item" aria-current="page">{{ $course_code }}</li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Topics') }}</li>
                </ol>
            </nav>
    </x-slot>
    <div class="album py-5 bg-light">
        <div class="container">

            @if(isset($course_image))
                <img src="{{ asset('uploads/courses/'.$course_image) }}"
                     class="img-fluid" style="height: 300px; width:100%" alt="{{ $course_code }}">
            @else
                <img src="{{ asset('uploads/courses/default.jpg') }}"
                     class="img-fluid" style="height: 300px; width:100%" alt="{{ $course_code }}">
            @endif
                <div class="position-absolute start-50 translate-middle rounded-pill text-white bg-dark h5 p-2"> {{__('SME')}}: {{ $expert }}</div>

            <p class="h3 mt-5">{{ $course_code.': '.$course_name }}</p>

            <p class="card-text mt-3">{{ $course_summery }}</p>
<div class="h3 text-center mt-3 p-2 border-bottom"> {{__('Topics')}}</div>
            @if($topics->count() != 0)
                <div class="accordion mt-3" id="accordionTopics">
                    <?php $count = 0; ?>
                    @foreach($topics as $topic)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading{{$topic->id}}">
                                <button class="accordion-button @if($count != 0) collapsed @endif" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapse{{$topic->id}}"
                                        aria-expanded="true" aria-controls="collapse{{$topic->id}}">
                                    {{ $topic->topic_name }}
                                </button>
                            </h2>
                            <div id="collapse{{$topic->id}}"
                                 class="accordion-collapse collapse @if($count == 0) show @endif"
                                 aria-labelledby="heading{{$topic->id}}" data-bs-parent="#accordionTopics">
                                <div class="accordion-body">
                                    {{ $topic->topic_summery }}
                                    <hr class="mt-2">
                                    <div class="btn-group mt-2">
                                        <a href="{{ route('objects',app()->getLocale()) }}?crsid={{ $topic->course_id }}&tid={{ $topic->id }}"
                                           class="btn btn-sm btn-outline-primary">{{__('Show objects')}}</a>
                                        @if(auth()->id() && (auth()->id() == $topic->course->course_sm_expert|| auth()->user()->role === 'Editor' || auth()->user()->role === 'Admin'))
                                            <a href="{{ route('topic_update', app()->getLocale()) }}?tid={{ $topic->id }}"
                                               class="btn btn-sm btn-outline-warning">{{__('Update')}}</a>
                                        @endif
                                    </div>

                                </div>
                            </div>
                        </div>
                        <?php $count++; ?>
                    @endforeach
                </div>
            @else
                <div class="text-center text-warning w-full fs-3">{{__('No data found.')}}</div>
            @endif
        </div>
    </div>

</x-app-layout>
