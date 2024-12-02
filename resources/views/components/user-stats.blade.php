<div class="d-flex justify-content-between align-items-center">
    <div class="d-flex flex-column justify-content-between align-items-start">
        <h5 class="content-desc">Employees</h5>
        <h3 class="statistics-value">{{ number_format($totalUsers) }}</h3>
    </div>
    <button class="btn-statistics">
        <a href="/manager/user"><img src="{{asset('img/global/times.svg')}}" alt=""></a>
    </button>
</div>
<div class="statistics-list">
    @foreach($latestUsers as $index => $user)
        <img class="statistics-image" 
             src="{{ $user['photo'] }}" 
             alt="{{ $user['name'] }}"
             title="{{ $user['name'] }}">
    @endforeach
</div>