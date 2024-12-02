<div class="document-card">
    @foreach ($activities as $activity)
        <div class="document-item">
            <div class="d-flex justify-content-start align-items-center">
                <div class="document-icon globe">
                    <img src="{{asset('img/home/document/twitch.svg')}}" alt="">
                </div>
                <div class="d-flex flex-column justify-content-between align-items-start">
                    <h2 class="document-title">{{ $activity->user->username ?? 'Activity'}}</h2>
                    <span class="document-desc text-black" 
                          data-bs-toggle="tooltip" 
                          data-bs-placement="top" 
                          title="{{ $activity->description }}">
                        {{ implode(' ', array_slice(explode(' ', $activity->description), 0, 4)) }}...
                    </span>
                </div>
            </div>
        </div>
    @endforeach
</div>