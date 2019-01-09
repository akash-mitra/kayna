<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Bliss Admin - Register</title>
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet" />
    
    
</head>
<body class="font-sans bg-blue-lightest">

    <div class="w-full flex justify-center items-center h-screen">
        

        <div class="w-1/3 bg-white px-8 py-4 shadow-lg rounded border-blue-light border-t-2">
            <div class="flex justify-between text-blue">
                <div class="pt-2 pb-6 text-3xl">{{ __('Create Account') }}</div>
                <div class="mt-4 text-sm">
                    <a href="/login" class="no-underline text-blue hover:text-blue-dark  p-2 rounded hover:bg-blue-lightest">
                        {{ __('Login') }}
                    </a>
                </div>
            </div>
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="w-full">
                    <label for="name" class="text-grey-darker">{{ __('Name') }}</label>

                
                    <input id="name" type="text" class="w-full bg-grey-lighter p-3 my-2 border rounded" name="name" value="{{ old('name') }}" required autofocus>

                    @if ($errors->has('name'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                    
                </div>

                <div class="w-full">
                    <label for="email" class="text-grey-darker">{{ __('E-Mail Address') }}</label>

                
                    <input id="email" type="email" class="w-full bg-grey-lighter p-3 my-2 border rounded" name="email" value="{{ old('email') }}" required>

                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                
                </div>

                <div class="w-full">
                    <label for="password" class="text-grey-darker">{{ __('Password') }}</label>

                
                    <input id="password" type="password" class="w-full bg-grey-lighter p-3 my-2 border rounded" name="password" required>

                    @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                    
                </div>

                <div class="w-full">
                    <label for="password-confirm" class="text-grey-darker">{{ __('Confirm Password') }}</label>
                    
                    <input id="password-confirm" type="password" class="w-full bg-grey-lighter p-3 my-2 border rounded" name="password_confirmation" required>
                    
                </div>

                <div class="w-full my-4">
                    
                    <button type="submit" class="py-2 px-8 bg-blue hover:bg-blue-dark text-white font-bold rounded">
                        {{ __('Register') }}
                    </button>
                
                </div>
            </form>
                
        </div>
    </div>
</body>
</html>


