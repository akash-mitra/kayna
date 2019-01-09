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
        

        <div class="w-1/3 bg-white px-8 py-4 shadow-lg rounded border-blue-light border-t-2">
            <div class="flex justify-between text-blue">
                <div class="pt-2 pb-6 text-3xl">{{ __('Login') }}</div>
                <div class="mt-4 text-sm">
                    <a href="/register" class="no-underline text-blue hover:text-blue-dark p-2 rounded hover:bg-blue-lightest">
                        {{ __('New Account') }}
                    </a>
                </div>
            </div>
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="w-full">
                    <label for="email" class="text-grey-darker">{{ __('E-Mail Address') }}</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="w-full bg-grey-lighter p-3 my-2 border rounded" name="email" value="{{ old('email') }}" required autofocus>

                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif

                    </div>
                </div>

                <div class="w-full">
                    <label for="password" class="text-grey-darker">{{ __('Password') }}</label>

                    <div class="col-md-6">
                        <input id="password" type="password" class="w-full bg-grey-lighter p-3 my-2 border rounded" name="password" required>

                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="w-full my-2">
                    
                    <div class="form-check">
                        <input class="" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                        <label class="text-grey-darker" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                        
                    </div>
                
                </div>

                <div class="w-full my-2">
                    <div class="py-2 flex justify-between">
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
    </div>

</body>
</html>

