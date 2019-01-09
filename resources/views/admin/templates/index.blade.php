@extends('admin.layout')

@section('header')
<div class="py-4 px-6">
        <h1 class="w-full p-2">
                <span class="text-lg font-semibold text-grey-darker uppercase borqder-b">
                        Templates 
                </span>
        </h1>

        <h3 class="px-2 text-sm font-light text-grey-dark">
                Import new templates for various content types.
        </h3>
</div>        
@endsection


@section('main')
        
        <div class="pt-4 flex justify-between">
                <div class="flex w-4/5 md:w-1/3">  
                        
                        <input type="text" value="{{ $query }}" id="txtSearch" class="p-2 w-full text-sm bg-white border-l border-t border-b" placeholder="Search...">
                        <button class="border p-2 text-sm" id="btnSearch">Go</button>        

                </div>

                <button id="btnNew" class="border border-teal px-2 py-1 rounded text-sm bg-teal hover:bg-orange hover:border-orange text-white shadow">
                        New Template
                </button>
        </div>

        <div class="w-full mt-8 bg-white shadow">
                <table class="w-full text-left text-sm text-grey-darker border-collapse">
                        <thead class="bg-grey-lighter uppercase border-b">
                                <tr>
                                        <th class="py-2 px-6 font-semibold">#</th>
                                        <th class="py-2 px-6 font-semibold">Name</th>
                                        <th class="py-2 px-6 font-semibold">Created</th>
                                </tr>
                        </thead>
                        <tbody>
                                @foreach($templates as $item)
                                        <tr class="hover:bg-grey-lightest hover:shadow-inner cursor-pointer border-b border-blue-lightest">
                                                <td class="py-2 px-6">{{ $loop->iteration }}</td>
                                                <td class="py-2 px-6">
                                                        <a href="{{ route('templates.show', $item->id)}}" class="no-underline text-blue">
                                                                {{ $item->name }}
                                                        </a>
                                                </td>
                                                <td class="py-2 px-6">{{ $item->created_at->diffForHumans() }}</td>
                                        </tr>
                                @endforeach
                        </tbody>
                </table>

                <div class="w-full bg-grey-lightest h-12 flex justify-between px-2 py-2 font-normal text-xs text-blue-light border-b">
                        {{ $templates->links() }}
                </div>
        </div>

        <p class="text-xs text-right py-4 text-grey-darker">
                {{ count($templates) }} records found
        </p>

        <!-- <img src="/svg/undraw_content_vbqo.svg" class="absolute pin-b pin-r z-0"> -->
        
@endsection

@section('script')

        <script>
                document.getElementById('btnSearch').onclick = function () {
                        location.href = '{{ route('templates.index') }}' + '?q=' + document.getElementById('txtSearch').value 
                }

                document.getElementById('btnNew').onclick = function () {
                        this.disabled = true;
                        this.classList.add('opacity-50');
                        location.href = '{{ route("templates.create")}}'
                }
        </script>

@endsection