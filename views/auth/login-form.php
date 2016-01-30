<form method="POST" action="/auth/login">
    {!! csrf_field() !!}

    <div class="form-group">
        <label for="login-email"> Email </label>
        <input type="email" name="email" value="{{ old('email') }}" class="form-control" id="login-email">
    </div>

    <div>
        <label for="login-password"> Parolă </label>
        <input type="password" name="password" id="login-password" class="form-control">
    </div>

    <div class="checkbox">
        <label>
            <input type="checkbox" name="remember"> Ține-mă logat
        </label>
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary">Login</button>
    </div>
</form>