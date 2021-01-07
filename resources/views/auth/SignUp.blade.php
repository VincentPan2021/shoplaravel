
@extends('layout.master')

@section('title', $title)

@section('content')

@include('components.validationErrorMessage')

<form action="" method="post">
{!! csrf_field() !!}

暱稱:
<input type="text" name="nickname" placeholder="暱稱" value="{{ old('nickname') }}"><br>
<br>

Email:
<input type="text" name="email" placeholder="Email" value="{{ old('email') }}"><br>
<br>

密碼:
<input type="password" name="password" placeholder="密碼"><br>
<br>

確認密碼:
<input type="password" name="password_confirmation" placeholder="確認密碼"><br>
<br>

帳號類型:
<select name="type">
    <option value="G" {{ old('type')=='G'?'selected':'' }}>一般會員</option>
    <option value="A" {{ old('type')=='A'?'selected':'' }}>管理者</option>
</select><br>
<br>

<input type="submit" class="btn btn-primary" value="註冊">

<form>

@endsection
