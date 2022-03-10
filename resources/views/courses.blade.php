<x-app-layout>
    <x-slot name="header">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a class="text-primary"
                                               href="{{ route('home', app()->getLocale()) }}">{{__('Home')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('Courses') }}</li>
            </ol>
        </nav>
    </x-slot>
    <div class="album py-5 bg-light">
        <div class="container">

            @if($courses->count() != 0)
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                    @foreach($courses as $course)
                        <div class="col">
                            <div class="card shadow-sm">
                                @if(isset($course->course_image))
                                    <img src="{{ asset('uploads/courses/'.$course->course_image) }}"
                                         class="bd-placeholder-img card-img-top" style="height: 225px; width:100%"
                                         alt="{{ $course->course_code }}">
                                @else
                                    <img src="{{ asset('uploads/courses/default.jpg') }}"
                                         class="bd-placeholder-img card-img-top" style="height: 225px; width:100%"
                                         alt="{{ $course->course_code }}">

                                @endif
                                <div class="position-absolute top-50 start-50 translate-middle rounded-pill text-white bg-dark h5 p-2"> {{ $course->course_code }}</div>
                                <div class="card-body">
                                    <a href="{{ route('topics',app()->getLocale()) }}?crsid={{ $course->id }}">
                                        <p class="h5">{{ $course->course_name }}</p>
                                    </a>
                                    <p class="card-text">
                                         {{ Str::limit($course->course_summery, 150) }}</p>


                                    <div class="btn-group mt-3">
                                        <a href="{{ route('topics',app()->getLocale()) }}?crsid={{ $course->id }}"
                                           class="btn btn-sm btn-outline-primary">{{__('Show content')}}</a>
                                        @if(auth()->id() && (auth()->id() === $course->course_sm_expert || auth()->user()->role === 'Editor' || auth()->user()->role === 'Admin'))
                                            <a href="{{ route('course_update',app()->getLocale()) }}?crsid={{ $course->id }}"
                                               class="btn btn-sm btn-outline-warning">{{__('Update')}}</a>
                                        @endif
                                        @if($course->is_publish !== 1 && auth()->id() && (auth()->user()->role === 'Editor' || auth()->user()->role === 'Admin'))
                                            <a href="{{ route('course_publish',app()->getLocale()) }}?crsid={{ $course->id }}"
                                               class="btn btn-sm btn-outline-success">{{__('Publish')}}</a>
                                        @elseif($course->is_publish === 1 && auth()->id() && (auth()->user()->role === 'Editor' || auth()->user()->role === 'Admin'))
                                            <button class="btn btn-sm btn-outline-default"
                                                    disabled>{{__('Published')}}</button>
                                        @endif
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
                <div class="text-center mt-3">{{ $courses->links() }}</div>


            @else
                <div class="text-center text-warning w-full fs-3">{{__('No data found.')}}</div>
            @endif

        </div>
    </div>

</x-app-layout>
