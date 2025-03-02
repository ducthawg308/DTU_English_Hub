@extends('layouts.app')
@section('content')
    <main class="container-lg py-4">
        <div class="message"></div>
        
        <div class="p-3 bg-opacity-10 rounded shadow">
            <h1>Luyện phát âm (Tiếng Anh Mỹ)</h1>
            <p>
                Cùng với: 
                <a class="font-weight-bold" href="https://www.youtube.com/user/theteachervanessa" target="_blank">
                    Speak English With Vanessa
                </a>
            </p>
            <hr>
            <div class="row justify-content-center">
                <div class="col-md-9">
                    <iframe id="player" frameborder="0" allowfullscreen allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        referrerpolicy="strict-origin-when-cross-origin" width="100%" height="480" 
                        src="https://www.youtube.com/embed/tpN9CPwZ-oE?enablejsapi=1" 
                        data-gtm-yt-inspected-8="true" data-gtm-yt-inspected-18="true">
                    </iframe>

                    <div class="mt-3" id="js-sound-buttons-container">
                        <button class="btn btn-outline-success shadow-none me-3 mb-3 player-btn" data-time="0">Intro</button>
                        <button class="btn btn-outline-success shadow-none me-3 mb-3 player-btn" data-time="54">short a</button>
                        <button class="btn btn-outline-success shadow-none me-3 mb-3 player-btn" data-time="64">short e</button>
                        <button class="btn btn-outline-success shadow-none me-3 mb-3 player-btn" data-time="72">short i</button>
                        <button class="btn btn-outline-success shadow-none me-3 mb-3 player-btn" data-time="90">short o</button>
                        <button class="btn btn-outline-success shadow-none me-3 mb-3 player-btn" data-time="98">short u</button>
                        <button class="btn btn-outline-success shadow-none me-3 mb-3 player-btn" data-time="108">long a</button>
                        <button class="btn btn-outline-success shadow-none me-3 mb-3 player-btn" data-time="116">long e</button>
                        <button class="btn btn-outline-success shadow-none me-3 mb-3 player-btn" data-time="124">long i</button>
                        <button class="btn btn-outline-success shadow-none me-3 mb-3 player-btn" data-time="132">long o</button>
                        <button class="btn btn-outline-success shadow-none me-3 mb-3 player-btn" data-time="142">long u</button>
                        <button class="btn btn-outline-success shadow-none me-3 mb-3 player-btn" data-time="151">long oo</button>
                        <button class="btn btn-outline-success shadow-none me-3 mb-3 player-btn" data-time="177">b</button>
                        <button class="btn btn-outline-success shadow-none me-3 mb-3 player-btn" data-time="186">k</button>
                        <button class="btn btn-outline-success shadow-none me-3 mb-3 player-btn" data-time="194">d</button>
                        <button class="btn btn-outline-success shadow-none me-3 mb-3 player-btn" data-time="217">f</button>
                        <button class="btn btn-outline-success shadow-none me-3 mb-3 player-btn" data-time="227">g</button>
                        <button class="btn btn-outline-success shadow-none me-3 mb-3 player-btn" data-time="235">h</button>
                        <button class="btn btn-outline-success shadow-none me-3 mb-3 player-btn" data-time="242">j</button>
                        <button class="btn btn-outline-success shadow-none me-3 mb-3 player-btn" data-time="250">l</button>
                        <button class="btn btn-outline-success shadow-none me-3 mb-3 player-btn" data-time="266">m</button>
                        <button class="btn btn-outline-success shadow-none me-3 mb-3 player-btn" data-time="275">n</button>
                        <button class="btn btn-outline-success shadow-none me-3 mb-3 player-btn" data-time="300">p</button>
                        <button class="btn btn-outline-success shadow-none me-3 mb-3 player-btn" data-time="309">r</button>
                        <button class="btn btn-outline-success shadow-none me-3 mb-3 player-btn" data-time="317">s</button>
                        <button class="btn btn-outline-success shadow-none me-3 mb-3 player-btn" data-time="327">t</button>
                        <button class="btn btn-outline-success shadow-none me-3 mb-3 player-btn" data-time="344">v</button>
                        <button class="btn btn-outline-success shadow-none me-3 mb-3 player-btn" data-time="354">w</button>
                        <button class="btn btn-outline-success shadow-none me-3 mb-3 player-btn" data-time="363">y</button>
                        <button class="btn btn-outline-success shadow-none me-3 mb-3 player-btn" data-time="372">z</button>
                        <button class="btn btn-outline-success shadow-none me-3 mb-3 player-btn" data-time="384">ch</button>
                        <button class="btn btn-outline-success shadow-none me-3 mb-3 player-btn" data-time="391">sh</button>
                        <button class="btn btn-outline-success shadow-none me-3 mb-3 player-btn" data-time="404">unvoiced /th</button>
                        <button class="btn btn-outline-success shadow-none me-3 mb-3 player-btn" data-time="412">voiced /th</button>
                        <button class="btn btn-outline-success shadow-none me-3 mb-3 player-btn" data-time="421">hw</button>
                        <button class="btn btn-outline-success shadow-none me-3 mb-3 player-btn" data-time="448">ng</button>
                        <button class="btn btn-outline-success shadow-none me-3 mb-3 player-btn" data-time="458">nk</button>
                        <button class="btn btn-outline-success shadow-none me-3 mb-3 player-btn" data-time="471">ur</button>
                        <button class="btn btn-outline-success shadow-none me-3 mb-3 player-btn" data-time="482">ar</button>
                        <button class="btn btn-outline-success shadow-none me-3 mb-3 player-btn" data-time="491">or</button>
                        <button class="btn btn-outline-success shadow-none me-3 mb-3 player-btn" data-time="503">oi</button>
                        <button class="btn btn-outline-success shadow-none me-3 mb-3 player-btn" data-time="526">ow</button>
                        <button class="btn btn-outline-success shadow-none me-3 mb-3 player-btn" data-time="534">oo</button>
                        <button class="btn btn-outline-success shadow-none me-3 mb-3 player-btn" data-time="541">aw</button>
                        <button class="btn btn-outline-success shadow-none me-3 mb-3 player-btn" data-time="550">zh</button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        let player;

        function onYouTubeIframeAPIReady() {
            player = new YT.Player("player", {
                events: {
                    onStateChange: onPlayerStateChange,
                },
            });
        }

        function onPlayerStateChange(event) {
            if (event.data === YT.PlayerState.PLAYING) {
                setInterval(updateButtonState, 500);
            }
        }

        document.querySelectorAll(".player-btn").forEach((btn) => {
            btn.addEventListener("click", function () {
                let time = this.getAttribute("data-time");
                if (player) {
                    player.seekTo(time, true);
                }
            });
        });

        function updateButtonState() {
            let currentTime = player.getCurrentTime();
            let activeButton = null;

            document.querySelectorAll(".player-btn").forEach((btn) => {
                let time = btn.getAttribute("data-time");
                if (currentTime >= time && currentTime < time + 5) {
                    activeButton = btn;
                }
            });

            document.querySelectorAll(".player-btn").forEach((btn) => {
                btn.classList.remove("btn-warning");
            });
            
            if (activeButton) {
                activeButton.classList.add("btn-warning");
            }
        }

        let tag = document.createElement("script");
        tag.src ="https://www.youtube.com/iframe_api";
        let firstScriptTag = document.getElementsByTagName("script")[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
    </script>
@endsection
