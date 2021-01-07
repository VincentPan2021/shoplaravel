@extends('layout.master')

@section('title', $title)

@section('content')
    <h1>{{ $title }}</h1>

    <a href="/merchandise/create" class="btn btn-primary">新增商品資料</a>

    <table class="table">
        <tr>
            <th>編號</th>
            <th>名稱</th>
            <th>圖片</th>
            <th>狀態</th>
            <th>價格</th>
            <th>剩餘數量</th>
            <th>編輯</th>
        </tr>
        @foreach($MerchandisePaginate as $Merchandise)
        <tr>
            <td>{{ $Merchandise->id}}</td>
            <td>{{ $Merchandise->name}}</td>
            <td><img width="250" src="{{ $Merchandise->photo}}"></td>
            <td>
                @if($Merchandise->status == 'C')
                建立中
                @else
                可銷售
                @endif
            </td>
            <td>{{ $Merchandise->price}}</td>
            <td>{{ $Merchandise->remain_count}}</td>
            <td>
                <a class="btn btn-success" href="/merchandise/{{ $Merchandise->id }}/edit">編輯</a>
            </td>
        </tr>
        @endforeach
    </table>

    {{ $MerchandisePaginate->links() }}
@endsection
