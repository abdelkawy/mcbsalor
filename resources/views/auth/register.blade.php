<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage users') }}
        </h2>
    </x-slot>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('register', app()->getLocale()) }}">
                    @csrf

                    <!-- Name -->
                        <div>
                            <x-label for="name" :value="__('Name')"></x-label>

                            <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
                                     required
                                     autofocus></x-input>
                        </div>

                        <!-- Email Address -->
                        <div class="mt-3">
                            <x-label for="email" :value="__('Email')"></x-label>

                            <x-input id="email" class="block mt-1 w-full" type="email" name="email"
                                     :value="old('email')"
                                     required></x-input>
                        </div>

                        <!-- Password -->
                        <div class="row g-2 mt-3">
                            <div class="col-sm-6">
                                <x-label for="password" :value="__('Password')"></x-label>

                                <x-input id="password" class="block mt-1 w-full"
                                         type="password"
                                         name="password"
                                         required autocomplete="new-password"></x-input>
                            </div>
                            <!-- Confirm Password -->
                            <div class="col-sm">
                                <x-label for="password_confirmation" :value="__('Confirm Password')"></x-label>

                                <x-input id="password_confirmation" class="block mt-1 w-full"
                                         type="password"
                                         name="password_confirmation" required></x-input>
                            </div>
                        </div>
                        <!-- Job -->
                        <div class="row g-2 mt-3">
                            <div class="col-sm-6">
                                <x-label for="job" :value="__('Job')"></x-label>

                                <x-input id="job" class="block mt-1 w-full"
                                         type="text"
                                         name="job" :value="old('job')"></x-input>
                            </div>
                            <!-- Employer -->
                            <div class="col-sm">
                                <x-label for="employer" :value="__('Employer')"></x-label>

                                <x-input id="employer" class="block mt-1 w-full"
                                         type="text"
                                         name="employer" :value="old('employer')"></x-input>
                            </div>
                        </div>
                        <div class="mt-3">
                            <label for="bio" class="form-label">{{__('Bio')}}</label>
                            <textarea id="bio" name="bio" rows="3" class="block mt-1 w-full">{{old('bio')}}</textarea>
                        </div>
                        <div class="mt-3 w-50">
                            <label for="role" class="form-label">{{__('User role')}}</label>
                            <select class="form-select" aria-label="Default user role" id="role" name="role">
                                <option value="SME" selected>{{__('SME')}}</option>
                                <option value="Editor">{{__('Editor')}}</option>
                                <option value="Admin">{{__('Admin')}}</option>
                            </select>
                        </div>
                        <div class="flex items-center justify-end mt-4">

                            <x-button class="ml-4">
                                {{ __('Register new user') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @if(Route::currentRouteName() != 'user_update')
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">{{__('Name')}}</th>
                                <th scope="col">{{__('Email')}}</th>
                                <th scope="col">{{__('Job')}}</th>
                                <th scope="col">{{__('Employer')}}</th>
                                <th scope="col">{{__('User role')}}</th>
                                <th width="160px"> ... </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <th scope="row">{{ $user->id }}</th>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->job }}</td>
                                    <td>{{ $user->employer }}</td>
                                    <td>{{ __($user->role) }}</td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                            <a class="btn btn-outline-warning" href="{{ route('user_update', app()->getLocale()) }}?uid={{ $user->id }}">{{__('Update')}}</a>
                                            <button class="btn btn-outline-danger" onclick="deleteAction('{{ route('user_delete', app()->getLocale()) }}?uid={{ $user->id }}')">{{__('Delete')}}</button>

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
