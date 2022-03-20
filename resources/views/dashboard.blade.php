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
                    <h1 class="h2">{{__('Performance chart for this month')}} </h1>
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
                            <th scope="col">{{__('Date')}}</th>
                            <th scope="col">{{__('Login')}}</th>
                            <th scope="col">{{__('Posts')}}</th>
                            <th scope="col">{{__('Changes')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @for($i = 0 ; $i < date('d') ; $i++)
                            <tr>
                                <td>{{ date('Y-m').'-'.str_pad($i+1,2,'0',STR_PAD_LEFT) }}</td>
                                <td>{{ $logins[$i] }}</td>
                                <td>{{ $posts[$i] }}</td>
                                <td>{{ $changes[$i] }}</td>
                            </tr>
                        @endfor
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
    {{--    <script src="{{ asset('js/dashboard.js') }}"></script>--}}
    <script>


        (function () {
            'use strict'

            feather.replace({'aria-hidden': 'true'})

            // Graphs
            let ctx = document.getElementById('myChart')
            const MONTHS = [
                'January',
                'February',
                'March',
                'April',
                'May',
                'June',
                'July',
                'August',
                'September',
                'October',
                'November',
                'December'
            ];
            const DAYS = [];
            const d = new Date();
            let day = d.getDate();
                for (let i = 1; i <= day; i++) DAYS.push(i);
                    //[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30];

            let myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: DAYS,
                    datasets: [{
                        label: 'Logins',
                        data: [
                            @for($i = 0 ; $i < date('d') ; $i++)
                            {{ $logins[$i] }},
                            @endfor
                        ],
                        lineTension: 0,
                        backgroundColor: 'transparent',
                        borderColor: '#007bb9',
                        borderWidth: 4,
                        pointBackgroundColor: '#007bb9'
                    },
                        {
                            label: 'Posts',
                            data: [
                                @for($i = 0 ; $i < date('d') ; $i++)
                                    {{ $posts[$i] }},
                                @endfor
                            ],
                            lineTension: 0,
                            backgroundColor: 'transparent',
                            borderColor: '#7b007b',
                            borderWidth: 4,
                            pointBackgroundColor: '#7b007b'
                        },
                        {
                            label: 'Changes',
                            data: [
                                @for($i = 0 ; $i < date('d') ; $i++)
                                    {{ $changes[$i] }},
                                @endfor
                            ],
                            lineTension: 0,
                            backgroundColor: 'transparent',
                            borderColor: '#7b9b00',
                            borderWidth: 4,
                            pointBackgroundColor: '#7b9b00'
                        }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: false
                            }
                        }]
                    },
                    legend: {
                        display: true
                    }
                }
            })
        })()
    </script>

</x-guest-layout>
