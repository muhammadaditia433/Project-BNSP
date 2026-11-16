@if (session('ok'))<div class="alert ok">{{ session('ok') }}</div>@endif
@if ($errors->any())
<div class="alert err"><ul>@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
@endif
