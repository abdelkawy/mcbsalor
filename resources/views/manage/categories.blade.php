<x-app-layout>
    <x-slot name="header">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a class="text-primary" href="{{ route('dashboard', app()->getLocale()) }}">{{__('Dashboard')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('Categories') }}</li>
            </ol>
        </nav>

    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(Route::currentRouteName() == 'category_update')
                        @foreach($category as $categoryData)
                        <p class="h3 underline">{{__('Update Category Data')}}</p>
                        <form method="POST" action="{{ route('category_update', app()->getLocale()) }}">
                            @csrf

                            <input type="hidden" name="category_id" id="category_id" value="{{ $categoryData->id }}">
                            <div class="mb-3">
                                <label for="parent_category" class="form-label">{{__('Parent category')}}</label>
                                <select class="form-select" aria-label="Default parent category" id="parent_category" name="parent_category">
                                    <option value="0" @if($categoryData->parent_category == 0) selected @endif >{{__('Is parent')}}</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" @if($categoryData->parent_category == $category->id) selected @endif >{{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="category_name" class="form-label">{{__('Category came')}}</label>
                                <input type="text" class="form-control" id="category_name" name="category_name" value="{{ $categoryData->category_name }}">
                                @error('category_name')
                                <p class="px-3 text-danger text-xs">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="cat_description" class="form-label">{{__('Description')}}</label>
                                <textarea type="text" class="form-control" id="cat_description" name="cat_description">{{ $categoryData->cat_description }}</textarea>
                                @error('cat_description')
                                <p class="px-3 text-danger text-xs">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="d-grid gap-2 col-6 mx-auto">
                                <button class="btn btn-outline-primary" type="submit">{{ __('Save the update') }}</button>
                            </div>
                        </form>
                        @endforeach
                    @else
                        <p class="h3 underline">{{__('Add New Category')}}</p>
                        <form method="POST" action="{{ route('manage_categories', app()->getLocale()) }}">
                            @csrf
                            <div class="mb-3">
                                <label for="parent_category" class="form-label">{{__('Parent Category')}}</label>
                                <select class="form-select" aria-label="Default select example" id="parent_category" name="parent_category">
                                    <option value="0" selected>{{__('Is parent')}}</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="category_name" class="form-label">{{__('Category Name')}}</label>
                                <input type="text" class="form-control" id="category_name" name="category_name" value="{{ old('category_name') }}">
                                @error('category_name')
                                <p class="px-3 text-danger text-xs">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="cat_description" class="form-label">{{__('Description')}}</label>
                                <textarea type="text" class="form-control" id="cat_description" name="cat_description">{{ old('cat_description') }}</textarea>
                                @error('cat_description')
                                <p class="px-3 text-danger text-xs">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="d-grid gap-2 col-6 mx-auto">
                                <button class="btn btn-outline-primary" type="submit">{{ __('Save and add') }}</button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @if(Route::currentRouteName() != 'category_update')
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table id="dataTable" class="table table-hover">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">{{__('Name')}}</th>
                            <th scope="col">{{__('Description')}}</th>
                            <th scope="col">{{__('Parent category')}}</th>
                            <th width="300px"> ... </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($categories as $category)
                        <tr>
                            <th scope="row">{{ $category->id }}</th>
                            <td>{{ $category->category_name }}</td>
                            <td>{{ $category->cat_description }}</td>
                            <td>@if($category->parent_category !== 0) {{ $category->parent->category_name }} @else {{__('Is parent')}} @endif</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                    <a class="btn btn-outline-success" href="{{ route('manage_courses', app()->getLocale()) }}?catid={{ $category->id }}">{{__('Courses')}}</a>
                                    <a class="btn btn-outline-warning" href="{{ route('category_update', app()->getLocale()) }}?catid={{ $category->id }}">{{__('Update')}}</a>
                                    <button class="btn btn-outline-danger" onclick="deleteAction('{{ route('category_delete', app()->getLocale()) }}?catid={{ $category->id }}')">{{__('Delete')}}</button>

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
