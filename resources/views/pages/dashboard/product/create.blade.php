<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Product &raquo; Create
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div>
                @if ($errors->any()){
                    <div class="mb-5" role="alert">
                        <div class="px-4 py-2 font-bold text-white bg-red-500 rounded-t">
                            There's something wrong!!
                        </div>
                        <div class="px-4 py-3 text-red-700 bg-red-100 border border-red-400 rounded-b">
                            <p>
                                <ul>
                                    @foreach ($errors->all() as $error )
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </p>
                        </div>
                    </div>
                }
                @endif
                <form action="{{ route('dashboard.product.store') }}" class="w-full" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="flex flex-wrap -mx-3 mb-6">
                       <div class="w-full px-3">
                        <label for="grid-last-name" class="block uppercase trascking-wide text-gray-700 text-xs font-bold mb-2">
                            Name
                        </label>
                        <input type="text" placeholder="Product Name" id="gripd-last-name" value="{{ old('name') }}" name="name" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bd-white focus:border-gray-500">
                       </div>
                    </div>
                    <div class="flex flex-wrap -mx-3 mb-6">
                       <div class="w-full px-3">
                        <label for="grid-last-name" class="block uppercase trascking-wide text-gray-700 text-xs font-bold mb-2">
                            Price
                        </label>
                        <input type="text" placeholder="Price" id="gripd-last-name" value="{{ old('name') }}" name="price" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bd-white focus:border-gray-500">
                       </div>
                    </div>
                    <div class="flex flex-wrap -mx-3 mb-6">
                       <div class="w-full px-3">
                        <label for="grid-last-name" class="block uppercase trascking-wide text-gray-700 text-xs font-bold mb-2">
                            Category
                        </label>
                        <select name="categories_id" id="categories_id" class="form-select appearance-none block w-full px-3 py-1,5 text-base font-normal  text-gray-700 bg-gray-200 bg-clip-padding bg-no-repeat border border-solid border-gray-300 rounded
                         transition ease-in-out m-0 focus:text-gray-700  focus:bg-white focus:border-blue-600 focus:outline-none" aria-label="category_id">
                        <option selected value="{{ old('categories_id') }}">Choose Category</option>    
                        @foreach ($category as  $data)
                            <option value="{{ $data->id }}">{{ $data->name }}</option>
                        @endforeach
                        </select>
                       </div>
                    </div>
                    <div class="flex flex-wrap -mx-3 mb-6">
                       <div class="w-full px-3">
                        <label for="grid-last-name" class="block uppercase trascking-wide text-gray-700 text-xs font-bold mb-2">
                            Description
                        </label>
                        <input type="text" placeholder="Description" id="gripd-last-name" value="{{ old('name') }}" name="description" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bd-white focus:border-gray-500">
                       </div>
                    </div>
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3 text-center ">
                            <button type="submit" class="btn btn-primary shadow-lg text-black font-bold py-2 px-4 rounded">
                                Save Product
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const checkbox = document.getElementById("flexCheckIndeterminate");
        checkbox.indeterminate = true;
    </script>
</x-app-layout>
