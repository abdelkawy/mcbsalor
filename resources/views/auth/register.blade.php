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
                    @if(Route::currentRouteName() === 'user_update')
                        @foreach($user as $userData)
                            <form method="POST" action="{{ route('user_update', app()->getLocale()) }}">
                                @csrf
                                <input type="hidden" name="user_id" id="user_id" value="{{ $userData->id }}">
                                <div class="row g-2 mt-3">
                                    <!-- Name -->
                                    <div class="col">
                                            <x-label for="name" :value="__('Name')"></x-label>

                                            <x-input id="name" class="block mt-1 w-full" type="text" name="name"
                                                     :value="$userData->name"
                                                     required
                                                     autofocus></x-input>
                                        @error('name')
                                        <p class="px-3 text-danger text-xs">{{ $message }}</p>
                                        @enderror
                                        </div>

                                        <!-- Email Address -->
                                        <div class="col">
                                            <x-label for="email" :value="__('Email')"></x-label>

                                            <x-input id="email" class="block mt-1 w-full" type="email" name="email"
                                                     :value="$userData->email"
                                                     required readonly></x-input>
                                            @error('email')
                                            <p class="px-3 text-danger text-xs">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- Password -->
                                    <div class="row g-3 mt-3">
                                        <div class="col">
                                            <x-label for="password" :value="__('Password')"></x-label>

                                            <x-input id="password" class="block mt-1 w-full"
                                                     type="password"
                                                     name="password"
                                                     ></x-input>
                                            @error('password')
                                            <p class="px-3 text-danger text-xs">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <!-- Confirm Password -->
                                        <div class="col">
                                            <x-label for="password_confirmation"
                                                     :value="__('Confirm Password')"></x-label>

                                            <x-input id="password_confirmation" class="block mt-1 w-full"
                                                     type="password"
                                                     name="password_confirmation" ></x-input>
                                        </div>
                                        <div class="col">
                                            <label for="role" class="form-label">{{__('User role')}}</label>
                                            <select class="form-select" aria-label="Default user role" id="role"
                                                    name="role">
                                                <option value="SME"
                                                        @if($userData->role === 'SME') selected @endif>{{__('SME')}}</option>
                                                <option value="Editor"
                                                        @if($userData->role === 'Editor') selected @endif>{{__('Editor')}}</option>
                                                <option value="Admin"
                                                        @if($userData->role === 'Admin') selected @endif>{{__('Admin')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Job -->
                                    <div class="row g-2 mt-3">
                                        <div class="col">
                                            <x-label for="job" :value="__('Job')"></x-label>

                                            <x-input id="job" class="block mt-1 w-full"
                                                     type="text"
                                                     name="job" :value="$userData->job"></x-input>
                                            @error('job')
                                            <p class="px-3 text-danger text-xs">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <!-- Employer -->
                                        <div class="col">
                                            <x-label for="employer" :value="__('Employer/Department')"></x-label>

                                            <x-input id="employer" class="block mt-1 w-full"
                                                     type="text"
                                                     name="employer" :value="$userData->employer"></x-input>
                                            @error('employer')
                                            <p class="px-3 text-danger text-xs">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <label for="bio" class="form-label">{{__('Bio')}}</label>
                                        <textarea id="bio" name="bio" rows="3"
                                                  class="block mt-1 w-full">{{$userData->bio}}</textarea>
                                        @error('bio')
                                        <p class="px-3 text-danger text-xs">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="flex items-center justify-end mt-4">

                                        <x-button class="ml-4">
                                            {{ __('Save user data') }}
                                        </x-button>
                                    </div>
                            </form>
                        @endforeach
                    @else
                        <form method="POST" action="{{ route('register', app()->getLocale()) }}">
                            @csrf
                            <div class="row g-2 mt-3">
                                <!-- Name -->
                                <div class="col">
                                    <x-label for="name" :value="__('Name')"></x-label>

                                    <x-input id="name" class="block mt-1 w-full" type="text" name="name"
                                             :value="old('name')"
                                             required
                                             autofocus></x-input>
                                    @error('name')
                                    <p class="px-3 text-danger text-xs">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Email Address -->
                                <div class="col">
                                    <x-label for="email" :value="__('Email')"></x-label>

                                    <x-input id="email" class="block mt-1 w-full" type="email" name="email"
                                             :value="old('email')"
                                             required></x-input>
                                    @error('email')
                                    <p class="px-3 text-danger text-xs">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <!-- Password -->
                            <div class="row g-3 mt-3">
                                <div class="col">
                                    <x-label for="password" :value="__('Password')"></x-label>

                                    <x-input id="password" class="block mt-1 w-full"
                                             type="password"
                                             name="password"
                                             required autocomplete="new-password"></x-input>
                                    @error('password')
                                    <p class="px-3 text-danger text-xs">{{ $message }}</p>
                                    @enderror
                                </div>
                                <!-- Confirm Password -->
                                <div class="col">
                                    <x-label for="password_confirmation" :value="__('Confirm Password')"></x-label>

                                    <x-input id="password_confirmation" class="block mt-1 w-full"
                                             type="password"
                                             name="password_confirmation" required></x-input>
                                </div>
                                <div class="col">
                                    <label for="role" class="form-label">{{__('User role')}}</label>
                                    <select class="form-select" aria-label="Default user role" id="role" name="role">
                                        <option value="SME"
                                                @if(old('role') === 'SME') selected @endif>{{__('SME')}}</option>
                                        <option value="Editor"
                                                @if(old('role') === 'Editor') selected @endif>{{__('Editor')}}</option>
                                        <option value="Admin"
                                                @if(old('role') === 'Admin') selected @endif>{{__('Admin')}}</option>
                                    </select>
                                </div>
                            </div>
                            <!-- Job -->
                            <div class="row g-2 mt-3">
                                <div class="col-sm-6">
                                    <x-label for="job" :value="__('Job')"></x-label>

                                    <x-input id="job" class="block mt-1 w-full"
                                             type="text"
                                             name="job" :value="old('job')"></x-input>
                                    @error('job')
                                    <p class="px-3 text-danger text-xs">{{ $message }}</p>
                                    @enderror
                                </div>
                                <!-- Employer -->
                                <div class="col-sm">
                                    <x-label for="employer" :value="__('Employer/Department')"></x-label>

                                    <x-input id="employer" class="block mt-1 w-full"
                                             type="text"
                                             name="employer" :value="old('employer')"></x-input>
                                    @error('employer')
                                    <p class="px-3 text-danger text-xs">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="mt-3">
                                <label for="bio" class="form-label">{{__('Bio')}}</label>
                                <textarea id="bio" name="bio" rows="3"
                                          class="block mt-1 w-full">{{old('bio')}}</textarea>
                                @error('bio')
                                <p class="px-3 text-danger text-xs">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-center justify-end mt-4">

                                <x-button class="ml-4">
                                    {{ __('Register new user') }}
                                </x-button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @if(Route::currentRouteName() !== 'user_update')
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th scope="col">{{__('Name')}}</th>
                                <th scope="col">{{__('Email')}}</th>
                                <th scope="col">{{__('Job')}}</th>
                                <th scope="col">{{__('Employer/Department')}}</th>
                                <th scope="col">{{__('User role')}}</th>
                                <th width="160px"> ...</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->job }}</td>
                                    <td>{{ $user->employer }}</td>
                                    <td>{{ __($user->role) }}</td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                            <a class="btn btn-outline-warning"
                                               href="{{ route('user_update', app()->getLocale()) }}?uid={{ $user->id }}">{{__('Update')}}</a>
                                            <button class="btn btn-outline-danger"
                                                    onclick="deleteAction('{{ route('user_delete', app()->getLocale()) }}?uid={{ $user->id }}')">{{__('Delete')}}</button>

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
