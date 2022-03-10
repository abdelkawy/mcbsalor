<x-guest-layout>
{{--    <div class="container my-5">--}}
{{--        <div class="row p-4 pb-0 pe-lg-0 pt-lg-5 align-items-center rounded-3 border shadow-lg">--}}
{{--            <div class="col-lg-7 p-3 p-lg-5 pt-lg-3">--}}
{{--                <h1 class="display-4 fw-bold lh-1">{{__('Arabic Learning Objects Repository')}}</h1>--}}
{{--                <p class="lead">{{__('Arabic Learning Objects Repository (ALOR) make learning resources more accessible through the creation and availability of shared information resources.')}}</p>--}}
{{--                <p class="lead">{{__('ALOR Learning Repository is an online library of learning objects and associated files. It is a combination of topics, modules, and assets that have been tagged with specific metadata to make them accessible to multiple users.')}}</p>--}}
{{--                <p class="lead">{{__('You can start browsing the available courses or you can login if you a member of administration team.')}}</p>--}}
{{--                <div class="d-grid gap-2 d-md-flex justify-content-md-start mb-4 mb-lg-3">--}}
{{--                    <button type="button" class="btn btn-outline-primary btn-lg px-4 me-md-2 fw-bold">{{__('Courses')}}</button>--}}
{{--                    <button type="button" class="btn btn-outline-secondary btn-lg px-4">{{__('Dashboard')}}</button>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-lg-4 offset-lg-1 p-0 overflow-hidden shadow-lg">--}}
{{--                <img class="rounded-lg-3" src="{{asset('img/logo.png')}}" alt="" width="720">--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

    <div class="px-4 pt-5 my-5 text-center border-bottom">
        <h1 class="display-4 fw-bold mb-4">{{__('Learning Objects Repository')}}</h1>
        <div class="col-lg-6 mx-auto">

            <p class="lead mb-4">{{__('Learning Objects Repository (LOR) make learning resources more accessible through the creation and availability of shared information resources.')}}</p>
            <p class="lead mb-4">{{__('LOR Learning Repository is an online library of learning objects and associated files. It is a combination of topics, modules, and assets that have been tagged with specific metadata to make them accessible to multiple users.')}}</p>
            <p class="lead mb-4">{{__('You can start browsing the available courses or you can login if you a member of administration team.')}}</p>
            <div class="d-grid gap-2 d-sm-flex justify-content-sm-center mb-5">
                <a href="{{ route('courses', app()->getLocale()) }}" class="btn btn-outline-primary btn-lg px-4 me-sm-3">{{__('Courses')}}</a>
                <a href="{{ route('login', app()->getLocale()) }}" class="btn btn-outline-secondary btn-lg px-4">{{__('Login')}}</a>
            </div>
        </div>
        <div class="overflow-hidden" style="max-height: 50vh;">
            <div class="container px-5">
                <img src="{{asset('img/home_image.png')}}" class="img-fluid border rounded-3 shadow-lg mb-4" alt="Home image" width="100%" loading="lazy">
            </div>
        </div>
    </div>
</x-guest-layout>
