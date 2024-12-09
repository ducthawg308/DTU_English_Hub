@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h4 class="text-center mb-4">Điền từ</h4>
    <div class="text-center mb-4">
        <p><strong>Đề án, dự án, kế hoạch (n)</strong></p>
        <div class="d-flex justify-content-center">
            <span class="revealed-letter">p</span>
            <span class="blank">_</span>
            <span class="blank">_</span>
            <span class="blank">_</span>
            <span class="blank">_</span>
            <span class="blank">_</span>
            <span class="revealed-letter">o</span>
        </div>
    </div>
    <div class="d-flex justify-content-center">
        <input id="answer-input" type="text" class="form-control text-center" style="width: 200px;" placeholder="Nhập từ vào đây">
    </div>
    <div class="text-center mt-4">
        <button id="check-answer" class="btn btn-primary">Kiểm tra</button>
    </div>
    <p id="feedback" class="text-center mt-3"></p>
</div>

<script>
    document.getElementById('check-answer').addEventListener('click', function() {
        const correctAnswer = 'proposal'; // Đáp án đúng
        const userAnswer = document.getElementById('answer-input').value.trim().toLowerCase();
        const feedback = document.getElementById('feedback');
        
        if (userAnswer === correctAnswer) {
            feedback.textContent = "Chính xác! 🎉";
            feedback.classList.add('text-success');
            feedback.classList.remove('text-danger');
        } else {
            feedback.textContent = "Sai rồi. Hãy thử lại! 😢";
            feedback.classList.add('text-danger');
            feedback.classList.remove('text-success');
        }
    });
</script>
@endsection
