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
                <form action="{{ route('dashboard.transaction.update', $item->id) }}" class="w-full" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="flex flex-wrap -mx-3 mb-6">
                       <div class="w-full px-3">
                        <label for="grid-last-name" class="block uppercase trascking-wide text-gray-700 text-xs font-bold mb-2">
                            Status
                        </label>
                        <select name="status" id="status" class="form-select appearance-none block w-full px-3 py-1,5 text-base font-normal  text-gray-700 bg-gray-200 bg-clip-padding bg-no-repeat border border-solid border-gray-300 rounded
                         transition ease-in-out m-0 focus:text-gray-700  focus:bg-white focus:border-blue-600 focus:outline-none" aria-label="status">
                        <option selected value="{{ $item->status }}">{{ $item->status }}</option>    
                            <option value="pending">pending</option>
                            <option value="success">Selesai</option>
                            <option value="shipping">Dalam Perjalanan</option>
                            <option value="cancelled">Dibatalkan</option>
                            <option value="failed">Gagal</option>
                        </select>
                       </div>
                    </div>
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3 text-center ">
                            <button type="submit" class="btn btn-primary shadow-lg text-black font-bold py-2 px-4 rounded">
                                Update Transaction
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
