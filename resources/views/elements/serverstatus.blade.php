<div class="box" style="width: 100%">
    <div class="columns">
        <div class="column">
            <div class="title-category">Server status
                <p class="text-category has-text-weight-medium">@if ($server != null)Players currently playing {{$server->GetInfo()['Players'] . '/' . $server->GetInfo()['MaxPlayers']}} people @endif</p>
                <p class="text-stats">{{ $settings->hostname }}</p>
            </div>

            @if ($server != null)
                <progress class="progress is-primary" value="{{ $server->GetInfo()['Players'] }}" max="{{ $server->GetInfo()['MaxPlayers'] }}"></progress>
                <p class="text-category has-text-dark">
                    @if(!empty($server->GetPlayers()))
                        Playing on the server now..
                        <ul class="text-category has-text-weight-medium">
                            @foreach ($server->GetPlayers() as $key => $player)
                                {{$player}} @if(count($server->GetPlayers()) > 1), @elseif((count($server->GetPlayers())-1) == $key) @endif
                            @endforeach
                        </ul>
                    @else
                        There are no players currently playing.
                    @endif

                </p>
            @else
                <p class="text-stats has-text-danger">Server unavailable</p>
                <progress class="progress is-danger"></progress>
            @endif

        </div>
    </div>
</div>