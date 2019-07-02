<div class="w-full">
        @if(session()->has('message'))
                        <div class="bg-green-lightest text-green text-sm py-4 px-6 mb-6 border-b border-green">{{ session('message') }}</div>
        @endif

        <div class="px-6 py-6">
                <h3 class="font-bold text-indigo">Blog Feed Setup</h3>
                <p class="py-2 text-grey-dark">Your blog will be able to generate below feeds automatically when you enable this feature</p>

                <table class="w-full my-4 bg-white shadow rounded text-left table-collapse">
                        <thead class="text-xs font-semibold text-grey-darker border-b-2">
                                <tr>
                                        <th class="py-4 px-6">Feed Type</th>
                                        <th class="hidden sm:table-cell p-4">Purpose</th>
                                        <th class="py-4 px-6">URL</th>
                                </tr>
                        </thead>
                        <tbody class="align-baseline">
                                <tr class="border-b hover:bg-grey-lightest">
                                        <td class="px-6 py-2 text-xs max-w-xs align-middle">RSS 2.0</td>
                                        <td class="hidden sm:table-cell px-4 py-2 text-xs align-middle">
                                                RSS stands for "Really Simple Syndication". It is a way to easily distribute a list of headlines, update notices, and sometimes content to a wide number of people. It is used by computer programs that organize those headlines and notices for easy reading.
                                        </td>
                                        <td class="px-6 py-2 text-xs max-w-xs align-middle">{{ url('feed/rss') }}</td>
                                </tr>
                                <tr class="border-b hover:bg-grey-lightest">
                                        <td class="px-6 py-2 text-xs max-w-xs align-middle">Atom</td>
                                        <td class="hidden sm:table-cell px-4 py-2 text-xs align-middle">
                                                The original function of Atom feeds is to provide website users with a consistent format that allows them to be quickly and easily informed about news on different websites. Users only need to subscribe to an Atom feed, and can then use various Feed readers or their browser.
                                        </td>
                                        <td class="px-6 py-2 text-xs max-w-xs align-middle">{{ url('feed/atom') }}</td>
                                </tr>
                                <tr class="border-b hover:bg-grey-lightest">
                                        <td class="px-6 py-2 text-xs max-w-xs align-middle">Sitemap</td>
                                        <td class="hidden sm:table-cell px-4 py-2 text-xs align-middle">
                                                A Sitemap is a list of web pages created for web crawlers so they can find your web content fast and easy. The search engine can use a sitemap to see the newest pages on a website, or all the web pages together, including all images, video content, etc.
                                        </td>
                                        <td class="px-6 py-2 text-xs max-w-xs align-middle">{{ url('feed/sitemap') }}</td>
                                </tr>
                        </tbody>
                </table>

                <div>                        
                        <label for="checkbox" class="my-4">
                                <input type="checkbox" id="checkbox" v-model="enable_site_feeds" true-value="yes" false-value="no">
                                Enable RSS, ATOM and Sitemap Feeds.
                        </label>

                        <div class="w-full block my-4">
                                <button type="button" @click="update(['enable_site_feeds'])" class="px-4 py-2 bg-green text-white rounded shadow hover:bg-green-dark">Save</button>
                        </div>
                </div>
        </div>
</div>