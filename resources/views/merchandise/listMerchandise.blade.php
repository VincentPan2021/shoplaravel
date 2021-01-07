@extends('layout.master')

@section('title', $title)

@section('content')
    <h1>{{ $title }}</h1>

    <table class="table">
        <tr>
            <th>名稱</th>
            <th>圖片</th>
            <th>價格</th>
            <th>剩餘數量</th>
        </tr>
        @foreach($MerchandisePaginate as $Merchandise)
        <tr>
            <td>
                <a href="/merchandise/{{ $Merchandise->id}}">
                    {{ $Merchandise->name}}
                </a>
            </td>
            <td><img width="250" src="{{ $Merchandise->photo}}"></td>
            <td>$ {{ number_format($Merchandise->price) }}</td>
            <td>{{ $Merchandise->remain_count}}</td>
        </tr>
        @endforeach
    </table>

    {{ $MerchandisePaginate->links() }}
@endsection
