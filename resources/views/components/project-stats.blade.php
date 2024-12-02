<div class="d-flex justify-content-between align-items-center">
    <div class="d-flex flex-column justify-content-between align-items-start">
        <h5 class="content-desc">Projects</h5>
        <h3 class="statistics-value">{{ number_format($totalProjects) }}</h3>
    </div>
    <button class="btn-statistics">
        <a href="/manager/project"><img src="{{asset('img/global/times.svg')}}" alt=""></a>
    </button>
</div>
<div class="statistics-list">
    @foreach($latestProjects as $index => $project)
        <div class="statistics-icon {{ ['one', 'two', 'three', 'four', 'five'][$index] }}" 
             title="{{ $project['name'] }}">
            <span>{{ $project['initials'] }}</span>
        </div>
    @endforeach
</div>