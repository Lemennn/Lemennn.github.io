<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add &raquo; Picture
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
                <form action="{{ route('dashboard.product.gallery.index', $product->id) }}" class="w-full" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                                Files
                            </label>
                            <input multiple accept="image/*" value="{{ old('files') }}" name="files[]" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" type="file" placeholder="Gallery Files">
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
