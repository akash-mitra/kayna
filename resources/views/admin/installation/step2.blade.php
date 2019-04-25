@extends('admin.fullpage')

@section('main')

<div class="w-full md:w-3/4 max-w-lg mx-auto h-screen p-4">
        <div class="w-full mt-12 pb-2">
                <span class="px-12 py-10 text-2xl font-mono font-bold rounded-full bg-indigo-lightest text-indigo-dark">2</span>
                <span class="py-6 px-2 text-xl text-indigo-dark">Configure the Website</span>
        </div>

        <div class="w-full ml-8 mt-2 sm:flex">

                <div class="sm:w-1/2 px-6 py-10 bg-white rounded-lg shadow-lg">
                        @if ($errors->any())
                        <div class="p-4 bg-orange-lightest rounded mb-4 text-red">
                                <ul>
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                </ul>
                        </div>
                        @endif
                        <form method="post" action="{{ route('installation-process', 2) }}">
                                @csrf

                                <div class="w-full px-3">
                                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-last-name">
                                                Logo Text
                                        </label>
                                        <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-grey" id="logo_text" type="text" name="logo_text" value="{{ old('logo_text') }}" placeholder="e.g. Magic School">
                                        <p class="text-xs text-grey-dark italic mt-2">Logo text will appear in header beside logo. This may or may not be same as your website name.</p>
                                </div>

                                <div class="w-full px-3 mt-6">
                                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-last-name">
                                                About
                                        </label>
                                        <textarea class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-grey" id="ta-about" name="about" type="email" placeholder="e.g. Get your weekly dose of Wizardries and Sorceries">{{ old('about') }}</textarea>
                                        <p class="text-xs text-grey-dark italic mt-2">Write a few lines generally describing your site. This may be used as meta description.</p>
                                </div>

                                <div class="w-full px-3 mt-6">
                                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-last-name">
                                                Enable User registration?
                                        </label>
                                        <flip-switch class="my-2 text-grey-dark text-xs italic" color="indigo" width="16" :state="enableRegistration" @toggle="enableRegistration=!enableRegistration"></flip-switch>
                                        <input type="hidden" name="enable_registration" v-model="enableRegistration">
                                        <p class="text-xs text-grey-dark italic mt-2">Registered users can leave feedback and comments to your posts</p>
                                </div>

                                <div class="w-full px-3 mt-8 flex justify-between">
                                        <a href="{{ route('installation', 1) }}" class="no-underline px-8 py-2 text-grey-dark rounded border">Back</a>
                                        <button type="submit" class="cursor-pointer px-8 py-2 bg-green text-white hover:bg-indigo-light rounded shadow">Next</button>
                                </div>
                        </form>
                </div>

                <div class="px-4 py-6 sm:w-1/2 flex items-center justify-center sm:justify-end">
                        <svg class="w-64 h-64" id="e66cdcae-b662-46fb-b424-18ba1a805fb0" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" width="832.5" height="677.84461" viewBox="0 0 832.5 677.84461">
                                <title>Configure</title>
                                <ellipse cx="667" cy="643.84461" rx="151" ry="34" fill="#6c63ff" />
                                <ellipse cx="681" cy="633.84461" rx="151" ry="34" fill="none" stroke="#3f3d56" stroke-miterlimit="10" />
                                <circle cx="436.5" cy="304.34461" r="30" fill="#6c63ff" />
                                <circle cx="557.5" cy="304.34461" r="30" fill="#6c63ff" />
                                <circle cx="678.5" cy="304.34461" r="30" fill="#6c63ff" />
                                <circle cx="12.5" cy="20.34461" r="3" fill="#f86b75" />
                                <circle cx="21.5" cy="20.34461" r="3" fill="#fad375" />
                                <circle cx="30.5" cy="20.34461" r="3" fill="#8bcc55" />
                                <rect x="67" y="66.84461" width="206" height="64" fill="#6c63ff" />
                                <rect x="0.5" y="10.34461" width="364" height="216" fill="none" stroke="#3f3d56" stroke-miterlimit="10" />
                                <line x1="0.5" y1="26.70288" x2="364.5" y2="26.70288" fill="none" stroke="#3f3d56" stroke-miterlimit="10" />
                                <circle cx="13.5" cy="18.34461" r="3" fill="none" stroke="#3f3d56" stroke-miterlimit="10" />
                                <circle cx="22.5" cy="18.34461" r="3" fill="none" stroke="#3f3d56" stroke-miterlimit="10" />
                                <circle cx="31.5" cy="18.34461" r="3" fill="none" stroke="#3f3d56" stroke-miterlimit="10" />
                                <rect x="79.5" y="54.34461" width="206" height="64" fill="none" stroke="#3f3d56" stroke-miterlimit="10" />
                                <rect x="41" y="158.84461" width="276" height="8.27586" fill="#f2f2f2" />
                                <rect x="41" y="178.70668" width="276" height="8.27586" fill="#f2f2f2" />
                                <rect x="41" y="198.56875" width="276" height="8.27586" fill="#f2f2f2" />
                                <rect x="44" y="154.84461" width="276" height="8.27586" fill="none" stroke="#3f3d56" stroke-miterlimit="10" />
                                <rect x="44" y="174.70668" width="276" height="8.27586" fill="none" stroke="#3f3d56" stroke-miterlimit="10" />
                                <rect x="44" y="194.56875" width="276" height="8.27586" fill="none" stroke="#3f3d56" stroke-miterlimit="10" />
                                <circle cx="96.5" cy="394.34461" r="3" fill="#f86b75" />
                                <circle cx="105.5" cy="394.34461" r="3" fill="#fad375" />
                                <circle cx="114.5" cy="394.34461" r="3" fill="#8bcc55" />
                                <rect x="151" y="440.84461" width="206" height="64" fill="#6c63ff" />
                                <polyline points="448.5 428.345 448.5 600.345 84.5 600.345 84.5 384.345 380.5 384.345" fill="none" stroke="#3f3d56" stroke-miterlimit="10" />
                                <line x1="84.5" y1="400.70288" x2="381" y2="400.70288" fill="none" stroke="#3f3d56" stroke-miterlimit="10" />
                                <circle cx="97.5" cy="392.34461" r="3" fill="none" stroke="#3f3d56" stroke-miterlimit="10" />
                                <circle cx="106.5" cy="392.34461" r="3" fill="none" stroke="#3f3d56" stroke-miterlimit="10" />
                                <circle cx="115.5" cy="392.34461" r="3" fill="none" stroke="#3f3d56" stroke-miterlimit="10" />
                                <rect x="163.5" y="428.34461" width="206" height="64" fill="none" stroke="#3f3d56" stroke-miterlimit="10" />
                                <circle cx="392.5" cy="221.34461" r="3" fill="#f86b75" />
                                <circle cx="401.5" cy="221.34461" r="3" fill="#fad375" />
                                <circle cx="410.5" cy="221.34461" r="3" fill="#8bcc55" />
                                <rect x="380.5" y="211.34461" width="364" height="216" fill="none" stroke="#3f3d56" stroke-miterlimit="10" />
                                <line x1="380.5" y1="227.70288" x2="744.5" y2="227.70288" fill="none" stroke="#3f3d56" stroke-miterlimit="10" />
                                <circle cx="393.5" cy="219.34461" r="3" fill="none" stroke="#3f3d56" stroke-miterlimit="10" />
                                <circle cx="402.5" cy="219.34461" r="3" fill="none" stroke="#3f3d56" stroke-miterlimit="10" />
                                <circle cx="411.5" cy="219.34461" r="3" fill="none" stroke="#3f3d56" stroke-miterlimit="10" />
                                <circle cx="441.5" cy="299.34461" r="30" fill="none" stroke="#3f3d56" stroke-miterlimit="10" />
                                <circle cx="562.5" cy="299.34461" r="30" fill="none" stroke="#3f3d56" stroke-miterlimit="10" />
                                <circle cx="683.5" cy="299.34461" r="30" fill="none" stroke="#3f3d56" stroke-miterlimit="10" />
                                <rect x="396" y="354.84461" width="82" height="8" fill="#f2f2f2" />
                                <rect x="518" y="354.84461" width="82" height="8" fill="#f2f2f2" />
                                <rect x="640" y="354.84461" width="82" height="8" fill="#f2f2f2" />
                                <rect x="400" y="351.84461" width="82" height="8" fill="none" stroke="#3f3d56" stroke-miterlimit="10" />
                                <rect x="522" y="351.84461" width="82" height="8" fill="none" stroke="#3f3d56" stroke-miterlimit="10" />
                                <rect x="644" y="351.84461" width="82" height="8" fill="none" stroke="#3f3d56" stroke-miterlimit="10" />
                                <rect x="98" y="529.84461" width="63" height="54" fill="#f2f2f2" />
                                <rect x="214.5" y="530.34461" width="63" height="54" fill="#f2f2f2" />
                                <rect x="331" y="530.84461" width="63" height="54" fill="#f2f2f2" />
                                <rect x="107" y="519.84461" width="63" height="54" fill="none" stroke="#3f3d56" stroke-miterlimit="10" />
                                <rect x="223.5" y="520.34461" width="63" height="54" fill="none" stroke="#3f3d56" stroke-miterlimit="10" />
                                <rect x="340" y="520.84461" width="63" height="54" fill="none" stroke="#3f3d56" stroke-miterlimit="10" />
                                <polygon points="600.786 204.492 572.726 220.039 602.65 209.483 600.786 204.492" fill="#79758c" />
                                <ellipse cx="792.31015" cy="315.8657" rx="7.82868" ry="15.77231" transform="translate(-242.57387 149.13382) rotate(-17.99425)" fill="#3f3d56" />
                                <ellipse cx="816.71468" cy="303.83928" rx="5.90628" ry="11.13657" transform="translate(-237.66497 156.08467) rotate(-17.99425)" fill="#3f3d56" />
                                <polygon points="610.365 195.681 628.977 188.961 632.933 199.919 614.919 212.087 610.365 195.681" fill="#3f3d56" />
                                <path d="M792.33488,347.04626l5-11s12-32,1-26-15,22-15,22l-3,10Z" transform="translate(-183.75 -111.0777)" fill="#a0616a" />
                                <path d="M929.33488,513.04626s-17,33-22,34-5-30-5-30,10-9,14-8S929.33488,513.04626,929.33488,513.04626Z" transform="translate(-183.75 -111.0777)" fill="#a0616a" />
                                <path d="M904.33488,721.04626s9,5,5,16-6,8-8,17-20,8-21,4-3-20,2-26S904.33488,721.04626,904.33488,721.04626Z" transform="translate(-183.75 -111.0777)" fill="#55536e" />
                                <path d="M815.33488,721.04626s-9,5-5,16,6,8,8,17,20,8,21,4,3-20-2-26S815.33488,721.04626,815.33488,721.04626Z" transform="translate(-183.75 -111.0777)" fill="#55536e" />
                                <path d="M899.33488,521.04626s8,5,10,36-1,66-2,74,1,20,3,26-5,52-5,52a23.4326,23.4326,0,0,1,0,20c-5,11-20,22-24,11a27.13063,27.13063,0,0,0-3-11c-3-6,2-30,2-30s-4-38-3-48-12-69-14-79-1-18-2-15-19,86-19,86,2,53,1,60,4,21,1,26-9,23-20,12-9-15-10-20,0-11,0-19-8-53-4-60,2-16,1-32-2-93,8-107S899.33488,521.04626,899.33488,521.04626Z" transform="translate(-183.75 -111.0777)" fill="#3f3d56" />
                                <circle cx="691.08488" cy="198.46856" r="24" fill="#a0616a" />
                                <path d="M890.33488,319.04626s-1,36,4,42-43-5-43-5,11-23,4-38S890.33488,319.04626,890.33488,319.04626Z" transform="translate(-183.75 -111.0777)" fill="#a0616a" />
                                <path d="M899.33488,357.04626s-2-8-14-10-26.19084-4-30.59542,0-6.40458,9-9.40458,9h-14l-22,39s11,13,8,37-8,68-8,68a219.99527,219.99527,0,0,1,21,34c10,20,79,18,75-17,0,0-5-9-3-17s8-62,8-62l23-61S901.33488,361.04626,899.33488,357.04626Z" transform="translate(-183.75 -111.0777)" fill="#55536e" />
                                <path d="M926.33488,376.04626h7s4,23,3,37-1,47-1,47,4,8,3,15-3,26-3,26-1,27-20,13c0,0-6-3-3-16s-2-27-2-27,3-9,2-15-5-25-5-25Z" transform="translate(-183.75 -111.0777)" fill="#55536e" />
                                <path d="M836.33488,359.04626l-5-3s-7-3-17,0-15,2-19,1-1-11-1-11-8-14-16-6-8,24-8,24-5,10,13,16,26,15,26,15h20Z" transform="translate(-183.75 -111.0777)" fill="#55536e" />
                                <path d="M873.20839,338.19386a4.63628,4.63628,0,0,0-2.8751-4.13,13.10926,13.10926,0,0,0-3.41741-.67489c-3.40526-.43912-6.90823-1.6879-8.8918-4.28928-2.64122-3.46385-1.91928-8.30936-4.03611-12.0696a41.85984,41.85984,0,0,0-3.22706-4.24013c-3.69409-4.94381-4.34515-11.25545-4.68151-17.26a7.41034,7.41034,0,0,1,.40689-3.60635,13.863,13.863,0,0,1,2.28185-2.81564,9.35213,9.35213,0,0,0,2.26249-6.241c-.10806-4.6505,6.54605-7.77555,11.25866-9.38154s9.82338-1.86178,14.84422-1.92973c2.88641-.03906,5.86539-.00491,8.51833,1.04929a19.607,19.607,0,0,1,4.27089,2.54282c5.5601,4.0699,10.78209,9.07349,12.64833,15.40628a33.3114,33.3114,0,0,1,1.01324,8.8482,5.7908,5.7908,0,0,1-.39612,2.72307c-.66724,1.34161-2.24018,2.06829-3.25707,3.2061-1.89928,2.12511-1.56121,5.19994-1.80185,7.94983a18.21013,18.21013,0,0,1-8.944,13.77276,11.406,11.406,0,0,0-2.79721,1.9338,12.27894,12.27894,0,0,0-1.54257,2.69289C882.84517,335.5174,877.80544,338.05811,873.20839,338.19386Z" transform="translate(-183.75 -111.0777)" fill="#3f3d56" />
                                <polygon points="192.598 10.671 179.278 18.05 193.483 13.04 192.598 10.671" fill="#79758c" />
                                <ellipse cx="380.03836" cy="121.88906" rx="3.71613" ry="7.48683" transform="translate(-202.81554 12.28627) rotate(-17.99425)" fill="#3f3d56" />
                                <ellipse cx="391.62274" cy="116.18033" rx="2.8036" ry="5.28632" transform="translate(-200.48537 15.58571) rotate(-17.99425)" fill="#3f3d56" />
                                <polygon points="197.145 6.488 205.98 3.299 207.858 8.5 199.307 14.276 197.145 6.488" fill="#3f3d56" />
                                <polygon points="282.598 382.671 269.278 390.05 283.483 385.04 282.598 382.671" fill="#79758c" />
                                <ellipse cx="470.03836" cy="493.88906" rx="3.71613" ry="7.48683" transform="translate(-313.33226 58.28467) rotate(-17.99425)" fill="#3f3d56" />
                                <ellipse cx="481.62274" cy="488.18033" rx="2.8036" ry="5.28632" transform="translate(-311.00209 61.58411) rotate(-17.99425)" fill="#3f3d56" />
                                <polygon points="287.145 378.488 295.98 375.299 297.858 380.5 289.307 386.276 287.145 378.488" fill="#3f3d56" />
                        </svg>
                </div>

        </div>

        <!-- <div class="w-full mt-8 text-right border-indigo py-8">
                
        </div> -->
</div>

@endsection

@section('script')
<script>
        new Vue({
                el: 'main',
                data: {
                        enableRegistration: true
                }
        })
</script>
@endsection