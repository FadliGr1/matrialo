<div class="d-flex justify-content-between align-items-center">
    <div class="d-flex flex-column justify-content-between align-items-start">
        <h5 class="content-desc">Vendors</h5>
        <h3 class="statistics-value">{{ number_format($totalVendors) }}</h3>
    </div>
    <button class="btn-statistics">
        <a href="/manager/vendor"><img src="{{asset('img/global/times.svg')}}" alt=""></a>
    </button>
</div>
<div class="statistics-list">
    @foreach($latestVendors as $index => $vendor)
        <div class="statistics-icon {{ ['one', 'two', 'three', 'four', 'five'][$index] }}" 
             title="{{ $vendor['name'] }}">
            <span>{{ $vendor['initials'] }}</span>
        </div>
    @endforeach
</div>