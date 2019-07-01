<div class="w-full">
        @if(session()->has('message'))
                        <div class="bg-green-lightest text-green text-sm py-4 px-6 mb-6 border-b border-green">{{ session('message') }}</div>
        @endif

        <div class="px-6 py-6">
                <h3 class="font-bold text-indigo">Application Update</h3>
                <p class="py-4 text-grey-dark">Download and install the packages to update your blog now.</p>
                <form action="{{ route('app.update') }}" method="post">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-green text-white rounded shadow hover:bg-green-dark">Update Application</button>
                </form>
        </div>
</div>