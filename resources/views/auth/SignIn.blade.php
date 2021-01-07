
@extends('layout.master')

@section('title', $title)

@section('content')

@include('components.validationErrorMessage')

<form action="" method="post">
{!! csrf_field() !!}

{{ trans('shop.user.fields.email') }}:
<input type="text" name="email" placeholder="{{ trans('shop.user.fields.email') }}" value="{{ old('email') }}"><br>
<br>

{{ trans('shop.user.fields.password') }}:
<input type="password" name="password" placeholder="{{ trans('shop.user.fields.password') }}" value="{{ old('password') }}"><br>
<br>

<input type="submit" class="btn btn-primary" value="{{ trans('shop.auth.login') }}">

</form>

@endsection
