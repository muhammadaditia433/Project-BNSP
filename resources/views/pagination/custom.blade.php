@if ($paginator->hasPages())
<div class="pager">
    @if ($paginator->onFirstPage())
        <span class="btn sec sm">&laquo; Sebelumnya</span>
    @else
        <a class="btn sm" href="{{ $paginator->previousPageUrl() }}">&laquo; Sebelumnya</a>
    @endif
    <span class="mut">Halaman {{ $paginator->currentPage() }}</span>
    @if ($paginator->hasMorePages())
        <a class="btn sm" href="{{ $paginator->nextPageUrl() }}">Berikutnya &raquo;</a>
    @else
        <span class="btn sec sm">Berikutnya &raquo;</span>
    @endif
</div>
@endif
