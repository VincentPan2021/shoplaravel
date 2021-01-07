@extends('layout.master')

@section('title', $title)

@section('content')
    <h1>{{ $title }}</h1>

    <table class="table">
        <tr>
            <th>商品名稱</th>
            <th>圖片</th>
            <th>單價</th>
            <th>購買數量</th>
            <th>總金額</th>
            <th>購買時間</th>
        </tr>
        @foreach($Transactions as $Transaction)
        <tr>
            <td>
                <a href="/merchandise/{{ $Transaction->Merchandise->id}}">
                    {{ $Transaction->Merchandise->name}}
                </a>
            </td>
            <td><img width="250" src="{{ $Transaction->Merchandise->photo}}"></td>
            <td>$ {{ number_format($Transaction->price) }}</td>
            <td>{{ $Transaction->buy_count}}</td>
            <td>$ {{ number_format($Transaction->total_price) }}</td>
            <td>{{ $Transaction->created_at}}</td>
        </tr>
        @endforeach
    </table>

    {{ $Transactions->links() }}
@endsection
