@if($errors && count($errors))
<ul class="list-group">
    @foreach($errors->all() as $err)
        <li class="list-group-item list-group-item-danger">
        {{ $err }}
        </li>
    @endforeach
</ul>
<hr>
@endif