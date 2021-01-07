<nav>
@if(session()->has('user_id'))
    <a class="btn btn-warning" href="/user/auth/sign-out">{{ trans('shop.auth.sign-out') }}</a> |
    <a class="btn btn-success" href="/transaction">交易紀錄</a> |
@else
    <a class="btn btn-primary" href="/user/auth/sign-up">{{ trans('shop.auth.sign-up') }}</a> | 
    <a class="btn btn-success" href="/user/auth/sign-in">{{ trans('shop.auth.sign-in') }}</a> |
    <a class="btn btn-success" href="#">{{ trans('shop.auth.facebook-sign-in') }}</a> |
@endif
    <a class="btn btn-info" href="#">分享到Facebook</a> |
</nav>