@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="col-lg-5 mb-2">
            <div class="mb-3 d-flex align-items-center">
                <audio controls="" src="{{ asset('storage/app/public/audio/' . $exercise->audio) }}" style="width: 100%;">Your browser does not support audio!</audio>
            </div>
        </div>
        <div class="mb-3 dictation__input-container">
            <div data-focus-guard="true" tabindex="-1" style="width: 1px; height: 0px; padding: 0px; overflow: hidden; position: fixed; top: 1px; left: 1px;">

            </div>
            <div data-focus-lock-disabled="disabled">
                <textarea class="form-control dictation__input " placeholder="Type what you hear..." autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" data-gramm="false" data-gramm_editor="false" data-enable-grammarly="false" style="height: 75.6px !important;"></textarea>
            </div>
        <div data-focus-guard="true" tabindex="-1" style="width: 1px; height: 0px; padding: 0px; overflow: hidden; position: fixed; top: 1px; left: 1px;"></div><button class="btn position-absolute bottom-0 end-0 z-2"><i class="bi bi-mic-fill"></i></button></div><div class="d-flex align-items-center mb-3"><div class="flex-grow-1"><button id="btn-check" class="btn btn-primary me-3">Check</button><button id="btn-skip" class="btn btn-outline-secondary">Skip</button></div><button class="btn border d-inline d-lg-none ms-2">Replay</button><button id="btn-next" class="btn btn-success ms-2" style="display: none;">Next</button></div>
    </div>
@endsection