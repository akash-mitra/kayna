
<div class="w-full md:w-1/3 p-6">
    <div class="w-full flex justify-between items-center">    
        <span class="font-bold text-indigo">Native</span>
        <div class="mt-2">
            <input class="mr-2 leading-tight" v-model="login_native_active" @change="change('loginNativeStateClass')" type="checkbox" true-value="yes" false-value="no">
            <span>Enable</span>
        </div>
    </div>
    
    <p class="my-2 py-1 text-xs text-grey-dark">
        This will allow users to register or login using the native login system. Users will have to verify their e-mail addresses when they use native login.
    </p>

    <div class="mt-2">
        <button @click="save('loginNativeStateClass', ['login_native_active'])" :class="loginNativeStateClass" class="px-4 py-2 rounded text-white">Save</button>
    </div>

</div>

<div class="w-full md:w-1/3 p-6 border-t border-b md:border-t-0 md:border-b-0 md:border-l md:border-r">
    <div class="w-full flex justify-between">
        <div>
            <svg viewBox="0 0 24 24" class="heroicon h-5 w-5 fill-current text-blue" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z" />
            </svg>
            <span class="font-bold text-blue ml-2">Facebook</span>
        </div>
        <div class="mt-2">
            <input class="mr-2 leading-tight" v-model="login_facebook_active" @change="change('loginFBStateClass')" type="checkbox" true-value="yes" false-value="no">
            <span>Enable</span>
        </div>
    </div>
    <div class="mt-6 text-grey-dark">
        <div>
            Client ID
            <input v-model="login_facebook_client_id" @change="change('loginFBStateClass')" type="text" class="w-full my-2 p-2 border rounded font-mono bg-grey-lightest hover:bg-white" />
        </div>
        <div>
            App Secret
            <input v-model="login_facebook_client_secret" @change="change('loginFBStateClass')" type="text" class="w-full my-2 p-2 border rounded font-mono bg-grey-lightest hover:bg-white" />
        </div>

    </div>

    <div class="mt-2">
        <button @click="save('loginFBStateClass', ['login_facebook_active', 'login_facebook_client_secret', 'login_facebook_client_id'])" :class="loginFBStateClass" class="px-4 py-2 rounded text-white">Save</button>

    </div>
</div>



<div class="w-full md:w-1/3 p-6">
    <div class="w-full flex justify-between">
        <div>
            <svg viewBox="0 0 50 50" class="heroicon h-5 w-5 fill-current text-red" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <path d="M 25.996094 48 C 13.3125 48 2.992188 37.683594 2.992188 25 C 2.992188 12.316406 13.3125 2 25.996094 2 C 31.742188 2 37.242188 4.128906 41.488281 7.996094 L 42.261719 8.703125 L 34.675781 16.289063 L 33.972656 15.6875 C 31.746094 13.78125 28.914063 12.730469 25.996094 12.730469 C 19.230469 12.730469 13.722656 18.234375 13.722656 25 C 13.722656 31.765625 19.230469 37.269531 25.996094 37.269531 C 30.875 37.269531 34.730469 34.777344 36.546875 30.53125 L 24.996094 30.53125 L 24.996094 20.175781 L 47.546875 20.207031 L 47.714844 21 C 48.890625 26.582031 47.949219 34.792969 43.183594 40.667969 C 39.238281 45.53125 33.457031 48 25.996094 48 Z " />
            </svg>
            <span class="font-bold text-red ml-2">Google</span>
        </div>
        <div class="mt-2">
            <input class="mr-2 leading-tight" v-model="login_google_active" @change="change('loginGoogleStateClass')" type="checkbox" true-value="yes" false-value="no">
            <span>Enable</span>
        </div>
    </div>
    <div class="mt-6 text-grey-dark">
        <div>
            Client ID
            <input v-model="login_google_client_id" @change="change('loginGoogleStateClass')" type="text" class="w-full my-2 p-2 border rounded font-mono bg-grey-lightest hover:bg-white" />
        </div>
        <div>
            App Secret
            <input v-model="login_google_client_secret" @change="change('loginGoogleStateClass')" type="text" class="w-full my-2 p-2 border rounded font-mono bg-grey-lightest hover:bg-white" />
        </div>

    </div>

    <div class="mt-2">
        <button @click="save('loginGoogleStateClass', ['login_google_active', 'login_google_client_secret', 'login_google_client_id'])" :class="loginGoogleStateClass" class="px-4 py-2 rounded text-white">Save</button>

    </div>
</div>

