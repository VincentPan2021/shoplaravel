@extends('layout.master')

@section('title', $title)

@section('content')
    <h1>{{ $title }}</h1>

    @include('components.validationErrorMessage')

    <form action="/merchandise/{{ $Merchandise->id }}" method="post" enctype="multipart/form-data">
    {!! csrf_field() !!}
    {{ method_field('PUT') }}

    <label>
        商品狀態：
        <select name="status">
            <option value="C">建立中</option>
            <option value="S">可販售</option>
        </select>
    </label><br><br>

    <label>
        商品名稱：
        <input type="text" name="name" placeholder="商品名稱" value="{{ old('name', $Merchandise->name) }}">
    </label><br><br>

    <label>
        商品英文名稱：
        <input type="text" name="name_en" placeholder="商品英文名稱" value="{{ old('name', $Merchandise->name_en) }}">
    </label><br><br>

    <label>
        商品介紹：<br>
        <textarea name="introduction" rows="5" cols="40" placeholder="商品介紹">{{ old('introduction', $Merchandise->introduction) }}</textarea>
    </label><br><br>

    <label>
        商品英文介紹：<br>
        <textarea name="introduction_en" rows="5" cols="40" placeholder="商品英文介紹">{{ old('introduction', $Merchandise->introduction_en) }}</textarea>
    </label><br><br>

    <label>
        商品照片：
        <input type="file" name="photo" placeholder="商品照片"><br>
        <img width="150" src="{{ $Merchandise->photo }}">
    </label><br><br>

    <label>
        商品價格：
        <input type="text" name="price" placeholder="商品價格" value="{{ old('price', $Merchandise->price) }}">
    </label><br><br>

    <label>
        商品剩餘數量：
        <input type="text" name="remain_count" placeholder="商品剩餘數量：" value="{{ old('remain_count', $Merchandise->remain_count) }}">
    </label><br><br>

    <input type="submit" class="btn btn-primary" value="更新商品資料">
    <a href="/merchandise/manage" class="btn btn-danger">返回商品列表</a>

    </form>
@endsection
