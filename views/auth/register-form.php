<form method="POST" action="/auth/register">
    {!! csrf_field() !!}

    <div class="form-group">
        <label for="register-firstname">Name mic</label>
        <input type="text" name="firstname" value="{{ old('firstname') }}" id="register-firstname" class="form-control">
    </div>

    <div class="form-group">
        <label for="register-lastname">Name de familie</label>
        <input type="text" name="lastname" value="{{ old('lastname') }}" id="register-lastname" class="form-control">
    </div>

    <div class="form-group">
        <label for="register-email"> Email </label>
        <input type="email" name="email" value="{{ old('email') }}" autocomplete="off" class="form-control" id="register-email">
    </div>

    <div class="form-group">
        <label for="register-password"> Parolă </label>
        <input type="password" name="password" autocomplete="off" id="register-password" class="form-control">
    </div>

    <div class="form-group">
        <button type="submit" class="btn-default btn">Înregistrează</button>
    </div>
</form>