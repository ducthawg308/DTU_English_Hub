@extends('layouts.app')

@section('content')
    <div class="container px-5 my-5" style="min-height: 80vh;">
        <h1 class="mt-4">Tạo từ vựng từ AI</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">DTU English Hub</a></li>
            <li class="breadcrumb-item active">Tạo từ vựng từ AI</li>   
        </ol>

        <div class="card">
            <div class="card-body">
                <form id="ai-form">
                    @csrf
                    <div class="mb-3">
                        <label for="topic" class="form-label">Chủ đề từ vựng</label>
                        <input type="text" class="form-control" id="topic" name="topic" required placeholder="Bạn muốn tạo từ vựng về chủ đề gì?">
                    </div>

                    <div class="mb-3">
                        <label for="word_count" class="form-label">Số lượng từ vựng</label>
                        <input type="number" class="form-control" id="word_count" name="word_count" required min="1" max="50" placeholder="Số lượng từ vựng bạn muốn tạo">
                    </div>

                    <button type="submit" class="btn btn-primary">Tạo từ vựng</button>
                </form>
                <div id="loading" style="display: none;">Đang tạo từ vựng...</div>
            </div>
        </div>

        <div id="vocabulary-result" class="mt-5"></div>
        <button id="save-vocab" class="btn btn-success mt-3 mx-auto" style="display: none;">Thêm vào danh sách của tôi</button>
        
    </div>

    <script>
        let generatedVocabulary = [];
    
        document.getElementById('ai-form').addEventListener('submit', function(event) {
            event.preventDefault();
    
            let topic = document.getElementById('topic').value.trim();
            let wordCount = document.getElementById('word_count').value;
            let loading = document.getElementById('loading');
            let resultContainer = document.getElementById('vocabulary-result');
            let saveButton = document.getElementById('save-vocab');
    
            if (!topic || wordCount < 1 || wordCount > 50) {
                alert("Vui lòng nhập chủ đề và số lượng từ hợp lệ (1-50).");
                return;
            }
    
            loading.style.display = 'block';
            resultContainer.innerHTML = '';
            saveButton.style.display = 'none';
    
            let formData = new FormData();
            formData.append('topic', topic);
            formData.append('word_count', wordCount);
            formData.append('_token', '{{ csrf_token() }}');
    
            fetch('{{ route("generate.vocabulary") }}', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                loading.style.display = 'none';
    
                if (data.error) {
                    resultContainer.innerHTML = `<p class='text-danger'>Lỗi: ${data.error}</p>`;
                    return;
                }
    
                generatedVocabulary = data.vocabularies;
    
                let vocabHtml = "<h3 class='mt-5 text-center'>Danh sách từ vựng</h3><ul class='list-group'>";
                data.vocabularies.forEach((word, index) => {
                    vocabHtml += `<li class="list-group-item">
                                    <input type="checkbox" class="form-check-input select-word" data-index="${index}">
                                    <strong>${word.word}</strong> (${word.pronounce}): ${word.meaning} <br>
                                    <em>Ví dụ:</em> ${word.example}
                                </li>`;
                });
    
                vocabHtml += "</ul>";
                resultContainer.innerHTML = vocabHtml;
                saveButton.style.display = 'block';

                saveButton.onclick = function () {
                    let selectedWords = [];
                    document.querySelectorAll('.select-word:checked').forEach(checkbox => {
                        let index = checkbox.getAttribute('data-index');
                        selectedWords.push(generatedVocabulary[index]);
                    });

                    if (selectedWords.length === 0) {
                        alert("Vui lòng chọn ít nhất một từ vựng để lưu!");
                        return;
                    }

                    fetch('{{ route("save.vocabulary") }}', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                        body: JSON.stringify({ topic: topic, vocabularies: selectedWords })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert("Lưu danh sách từ vựng thành công!");
                            saveButton.style.display = 'none';
                        } else {
                            alert("Lỗi: " + data.error);
                        }
                    })
                    .catch(error => {
                        console.error('Lỗi khi lưu từ vựng:', error);
                        alert("Đã xảy ra lỗi khi lưu danh sách.");
                    });
                };
            })
            .catch(error => {
                loading.style.display = 'none';
                resultContainer.innerHTML = `<p class='text-danger'>Lỗi: ${error.message}</p>`;
            });
        });
    </script>
@endsection