<x-guest-layout>
    <div class="container-fluid">
        <div class="row">
            @if(auth()->user()->role === 'Editor' || auth()->user()->role === 'Admin')
                <div class="col">
                    <div class="card border-warning mb-3">
                        <div class="card-header">{{__('Categories')}}</div>
                        <div class="card-body text-dark">
                            <h5 class="card-title">{{__('Manage categories')}}</h5>
                            <p class="card-text mb-4">{{__('You can add, edit and delete categories.')}}</p>
                            <a href="{{ route('manage_categories',app()->getLocale()) }}"
                               class="btn btn-outline-warning w-50">{{__('Start now')}}</a>
                        </div>
                    </div>
                </div>
            @endif
            <div class="col">
                <div class="card border-success mb-3">
                    <div class="card-header">{{__('Courses')}}</div>
                    <div class="card-body text-dark">
                        <h5 class="card-title">{{__('Manage courses')}}</h5>
                        <p class="card-text mb-4">{{__('You can add, edit and delete courses, topics and learning objects.')}}</p>
                        <a href="{{ route('manage_courses',app()->getLocale()) }}"
                           class="btn btn-outline-success w-50">{{__('Start now')}}</a>
                    </div>
                </div>
            </div>
            @if(auth()->user()->role === 'Admin')
                <div class="col">
                    <div class="card border-danger mb-3">
                        <div class="card-header">{{__('Users')}}</div>
                        <div class="card-body text-dark">
                            <h5 class="card-title">{{__('Manage users')}}</h5>
                            <p class="card-text mb-4">{{__('You can add, edit and delete users.')}}</p>
                            <a href="{{ route('register',app()->getLocale()) }}"
                               class="btn btn-outline-danger w-50">{{__('Start now')}}</a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <main class="px-md-4">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">{{__('Performance chart')}}</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <button type="button"
                                class="btn btn-sm btn-outline-secondary">{{__('Export to Spreadsheet')}}</button>

                    </div>
                </div>

                <canvas class="my-4 w-100" id="myChart" width="900" height="380"></canvas>

                <h2>{{__('Chart data')}}</h2>
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">عنوان</th>
                            <th scope="col">عنوان</th>
                            <th scope="col">عنوان</th>
                            <th scope="col">عنوان</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>1,001</td>
                            <td>بيانات</td>
                            <td>عشوائية</td>
                            <td>تثري</td>
                            <td>الجدول</td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"
            integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"
            integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha"
            crossorigin="anonymous"></script>
    <script src="{{ asset('js/dashboard.js') }}"></script>


</x-guest-layout>
