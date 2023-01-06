<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Category &raquo; Create
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
                <form action="{{ route('dashboard.category.store') }}" class="w-full" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="flex flex-wrap -mx-3 mb-6">
                       <div class="w-full px-3">
                        <label for="grid-last-name" class="block uppercase trascking-wide text-gray-700 text-xs font-bold mb-2">
                            Name
                        </label>
                        <input type="text" placeholder="Category Name" id="gripd-last-name" value="{{ old('name') }}" name="name" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bd-white focus:border-gray-500">
                       </div>
                    </div>
                    <div class="flex glex-wrap -mx-3 mb-6">
                        <div class="w-full px-3 text-right">
                            <button type="submit" class="shadow-lg bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Save Category
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
