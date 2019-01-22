<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Bliss Admin - Login</title>
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet" />
    
    
</head>
<body class="font-sans bg-blue-lightest">

    <div class="w-full flex justify-center items-center h-screen">
        @if(get_param('login_native_active') === 'yes' || get_param('login_google_active') === 'yes' || get_param('login_facebook_active') === 'yes' )
        <div class="w-4/5 sm:w-3/5 md:w-1/2 lg:w-2/5 xl:w-1/3 bg-white shadow-lg roundeds-lg border-blue-light border-t-4">

        <div class="w-full px-8 py-2 text-blue">
            <div class="py-2 text-3xl">{{ __('Login') }}</div>
            
        </div>
            @if(get_param('login_facebook_active') === 'yes' || get_param('login_google_active') === 'yes')
            <div class="w-full px-8 py-4 border-t">
                
                <div class="w-full text-grey-dark mb-6 text-center">
                    Login or Sign-up with your social account
                </div>

                @if(get_param('login_google_active') === 'yes')
                <div class="my-4 mx-auto w-full lg:w-3/4 xl:w-2/3 pt-2 pb-3 pl-4 rounded bg-red text-white font-semibold cursor-pointer">
                    <svg viewBox="0 0 50 50"  class="heroicon h-5 w-5 fill-current text-white bg-red" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <path d="M 25.996094 48 C 13.3125 48 2.992188 37.683594 2.992188 25 C 2.992188 12.316406 13.3125 2 25.996094 2 C 31.742188 2 37.242188 4.128906 41.488281 7.996094 L 42.261719 8.703125 L 34.675781 16.289063 L 33.972656 15.6875 C 31.746094 13.78125 28.914063 12.730469 25.996094 12.730469 C 19.230469 12.730469 13.722656 18.234375 13.722656 25 C 13.722656 31.765625 19.230469 37.269531 25.996094 37.269531 C 30.875 37.269531 34.730469 34.777344 36.546875 30.53125 L 24.996094 30.53125 L 24.996094 20.175781 L 47.546875 20.207031 L 47.714844 21 C 48.890625 26.582031 47.949219 34.792969 43.183594 40.667969 C 39.238281 45.53125 33.457031 48 25.996094 48 Z "/>
                    </svg> 
                    <a href="{{ route('social.login', 'google') }}" class="ml-2 no-underline text-white">
                        Login Via Google
                    </a>
                </div>
                @endif

                @if(get_param('login_facebook_active') === 'yes')
                <div class="my-4 mx-auto w-full lg:w-3/4 xl:w-2/3 pt-2 pb-3 pl-4 rounded bg-blue text-white font-semibold cursor-pointer">
                    <svg viewBox="0 0 24 24"  class="heroicon h-5 w-5 fill-current text-white bg-blue" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z"/>
                    </svg> 
                    <a href="{{ route('social.login', 'facebook') }}" class="ml-2 no-underline text-white">
                        Login Via Facebook
                    </a>
                </div>
                @endif

            </div>
            @endif
            @if(get_param('login_native_active') === 'yes')
            <div class="w-full px-8 py-6 bg-grey-lightest border-t">
                
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="w-full">
                        <div class="w-full flex justify-between">
                            <label for="email" class="text-grey-darker">{{ __('E-Mail Address') }}</label>
                            <a href="/register" class="no-underline text-sm text-blue hover:text-blue-dark">
                                {{ __('New Account') }}
                            </a>
                        </div>

                        <div class="w-full">
                            <input id="email" type="email" class="w-full bg-white p-3 my-2 border rounded" name="email" value="{{ old('email') }}" required>

                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif

                        </div>
                    </div>

                    <div class="w-full">
                        <label for="password" class="text-grey-darker">{{ __('Password') }}</label>

                        <div class="w-full">
                            <input id="password" type="password" class="w-full bg-white p-3 my-2 border rounded" name="password" required>

                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- <div class="w-full my-2">
                        
                        <div class="form-check">
                            <input class="" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                            <label class="text-grey-darker" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                            
                        </div>
                    
                    </div> -->

                    <div class="w-full mt-2">
                        <div class="pyw-2 flex justify-between">
                            <button type="submit" class="py-2 px-8 bg-blue hover:bg-blue-dark text-white font-bold rounded">
                                {{ __('Login') }}
                            </button>

                            <a class="font-bold text-blue hover:text-blue-dark text-sm no-underline py-2" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        </div>
                    </div>
                </form>
            </div>
            @endif
        </div>

        @else
                This website does not provide a login mechanism
        @endif
    </div>

</body>
</html>

