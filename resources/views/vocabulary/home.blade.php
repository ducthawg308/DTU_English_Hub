@extends('layouts.app')
@section('content')
    <div class="my-5">
        <div class="position-relative">
          <div class="max-w-1200px mx-4 md:mx-8 xl:mx-auto">
            <div class="leading-6 d-flex justify-content-center gap-8 align-items-center mt-8 flex-column-reverse lg:flex-row mb-3 lg:mb-6">
              <img src="Star" class="position-absolute top-12 left-27p d-none lg:block" alt="Star" />
              <div class="d-flex flex-column align-items-center">
                <h1 class="text-lg sm:text-2xl lg:text-40px text-title text-center lg:text-start font-semibold mb-4">
                  English Vocabulary
                </h1>
                <p class="text-sm sm:text-base lg:text-lg font-text-regular text-sub-title mb-0 text-gray-600">
                  Let's start your journey to learn categorized English vocabulary on Daily Dictation
                </p>
              </div>
              <img src="Star" class="position-absolute top-0 right-30p d-none lg:block" alt="Start" />
            </div>
          </div>
        </div>
    </div>

    <div class="container my-5">
      <a href="{{ route('topic.vocabulary') }}" class="btn btn-primary">Học từ vựng có sẵn của hệ thống</a>
      <a href="{{ route('custom.vocabulary') }}" class="btn btn-primary">Tự custom hệ thống tự vựng của riêng bạn</a>
  </div>
@endsection