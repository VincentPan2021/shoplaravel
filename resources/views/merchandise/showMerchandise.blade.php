@extends('layout.master')

@section('title', $title)

@section('content')
    <h1>{{ $title }}</h1>

    @include('components.validationErrorMessage')

    <label>
        商品名稱：
        {{ $Merchandise->name }}
    </label><br><br>

    <label>
        商品介紹：<br>
        {{ $Merchandise->introduction }}
    </label><br><br>

    <label>
        商品照片：<br>
        <img src="{{ $Merchandise->photo }}">
    </label><br><br>

    <label>
        商品價格：
        {{ $Merchandise->price }}
    </label><br><br>

    <label>
        商品剩餘數量：
        {{ $Merchandise->remain_count }}
    </label><br><br>

    <form action="/merchandise/{{ $Merchandise->id }}/buy" method="post">
        {!! csrf_field() !!}

    <label>
        購買數量：
        <select name="buy_count">
            <option value="1">1</option>
        @for($count=1; $count <= $Merchandise->remain_count; $count++)
            <option value="{{ $count }}">{{ $count }}</option>
        @endfor
        </select>
    </label><br><br>
    <input class="btn btn-primary" type="submit" value="我要購買">

    </form>
@endsection
