<div class="w-full max-w-sm mx-auto1 px-1 py-6 md:px-6">
        @if(session()->has('message'))
                        <div class="bg-green-lightest text-green text-sm py-4 px-6 mb-6 border-b border-green">{{ session('message') }}</div>
        @endif

        <div class="w-full px-6 py-1">
                <h3 class="font-bold text-indigo">General Site Config</h3>
                <p class="py-2 text-grey-dark">Manage site-wide configuration paramters</p>
        </div>       

        <div class="w-full px-6 py-1">
                
                <div class="my-4">
                        <label class="block text-gray-dark text-sm font-bold mb-2" for="sitename">
                                Site Name
                        </label>
                        <input v-model="sitename" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-dark leading-tight focus:outline-none focus:shadow-outline" id="sitename" type="text" placeholder="e.g., MyBlog">
                </div>
                <div class="my-4">
                        <label class="block text-gray-dark text-sm font-bold mb-2" for="tagline">
                                Site Title / Tag Line 
                        </label>
                        <input v-model="tagline" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-dark leading-tight focus:outline-none focus:shadow-outline" id="tagline" type="text" placeholder="e.g., Chronicle of my daily Life">
                </div>
                <div class="my-4">
                        <label class="block text-gray-dark text-sm font-bold mb-2" for="sitedesc">
                                Site Description
                        </label>
                        <textarea v-model="sitedesc" class="h-24 shadow appearance-none border rounded w-full py-2 px-3 text-gray-dark leading-tight focus:outline-none focus:shadow-outline" id="sitedesc" type="text" placeholder="e.g., Write a few lines about this blog in general. This information will be used as site-wide meta description"></textarea>
                </div>
        </div>

        <div class="w-full px-6 py-1">
                <button class="bg-blue hover:bg-blue-dark text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" @click="update(['sitename', 'tagline', 'sitedesc'])">Save</button>
        </div>
        
</div>