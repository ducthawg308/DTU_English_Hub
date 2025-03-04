@extends('layouts.app')
@section('content')
<main class="main">

    <section id="hero" class="hero section dark-background">

        <img src="img/learn.jpg" alt="" data-aos="fade-in">

        <div class="container d-flex flex-column align-items-center">
        <h2 data-aos="fade-up" data-aos-delay="100">Daily Dictation</h2>
        <p data-aos="fade-up" data-aos-delay="200">Chúng tôi giúp bạn nâng cao kỹ năng nghe, mở rộng vốn từ vựng và làm bài kiểm tra để chinh phục tiếng Anh.</p>
        <div class="d-flex mt-4" data-aos="fade-up" data-aos-delay="300">
            <a href="#about" class="btn-get-started">Bắt đầu ngay</a>
            <a href="https://www.youtube.com/watch?v=Y7f98aduVJ8" class="glightbox btn-watch-video d-flex align-items-center"><i class="bi bi-play-circle"></i><span>Xem hướng dẫn</span></a>
        </div>
        </div>

    </section>

    <section id="about" class="about section">

        <div class="container">

        <div class="row gy-4">
            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
            <h3>Nâng cao trình độ tiếng Anh cùng Daily Dictation</h3>
            <img src="img/listen_home.jpg" class="img-fluid rounded-4 mb-4" alt="">
            <p>Đồng hành cùng hơn 1 triệu người học và giáo viên trên toàn thế giới</p>
            <p>Chúng tôi cam kết mang đến môi trường học tập an toàn và hiệu quả, giúp bạn nâng cao kỹ năng nghe, từ vựng và khả năng làm bài kiểm tra một cách dễ dàng.</p>
            </div>
            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="250">
            <div class="content ps-0 ps-lg-5">
                <p class="fst-italic">
                    Chúng tôi cung cấp cho bạn:
                </p>
                <ul>
                    <li><i class="bi bi-check-circle-fill"></i> <span>Giao diện thân thiện: Giúp bạn học dễ dàng hơn mọi lúc, mọi nơi.</span></li>
                    <li><i class="bi bi-check-circle-fill"></i> <span>Luyện nghe thực tế: Nghe audio/video từ người bản ngữ, tin tức, và hội thoại thường ngày để cải thiện kỹ năng nghe hiểu.</span></li>
                    <li><i class="bi bi-check-circle-fill"></i> <span>Học từ vựng dễ nhớ: Tích hợp flashcards thông minh và bài tập tương tác để mở rộng vốn từ vựng.</span></li>
                    <li><i class="bi bi-check-circle-fill"></i> <span>Bài kiểm tra online: Đánh giá trình độ và định hướng lộ trình học tập của bạn.</span></li>
                    <li><i class="bi bi-check-circle-fill"></i> <span>Cộng đồng học tập: Kết nối với những người học tiếng Anh khác, chia sẻ kinh nghiệm và cùng nhau tiến bộ.</span></li>
                </ul>

                <div class="position-relative mt-4">
                <img src="img/vocab_home.jpg" class="img-fluid rounded-4" alt="">
                <a href="https://www.youtube.com/watch?v=mgty3Bgu-YY&t=1043s" class="glightbox pulsating-play-btn"></a>
                </div>
            </div>
            </div>
        </div>

        </div>

    </section>

    <section id="stats" class="stats section light-background">

        <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">

            <div class="col-lg-3 col-md-6">
            <div class="stats-item d-flex align-items-center w-100 h-100">
                <i class="bi bi-emoji-smile color-blue flex-shrink-0"></i>
                <div>
                <span data-purecounter-start="0" data-purecounter-end="232" data-purecounter-duration="1" class="purecounter"></span>
                <p>Học viên hài lòng</p>
                </div>
            </div>
            </div><!-- End Stats Item -->

            <div class="col-lg-3 col-md-6">
            <div class="stats-item d-flex align-items-center w-100 h-100">
                <i class="bi bi-journal-richtext color-orange flex-shrink-0"></i>
                <div>
                <span data-purecounter-start="0" data-purecounter-end="521" data-purecounter-duration="1" class="purecounter"></span>
                <p>Từ vựng phong phú</p>
                </div>
            </div>
            </div><!-- End Stats Item -->

            <div class="col-lg-3 col-md-6">
            <div class="stats-item d-flex align-items-center w-100 h-100">
                <i class="bi bi-headset color-green flex-shrink-0"></i>
                <div>
                <span data-purecounter-start="0" data-purecounter-end="1463" data-purecounter-duration="1" class="purecounter"></span>
                <p>Bài nghe đa dạng</p>
                </div>
            </div>
            </div><!-- End Stats Item -->

            <div class="col-lg-3 col-md-6">
            <div class="stats-item d-flex align-items-center w-100 h-100">
                <i class="bi bi-people color-pink flex-shrink-0"></i>
                <div>
                <span data-purecounter-start="0" data-purecounter-end="15" data-purecounter-duration="1" class="purecounter"></span>
                <p>Cộng đồng lớn</p>
                </div>
            </div>
            </div><!-- End Stats Item -->

        </div>

        </div>

    </section>

    <section id="services" class="services section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
        <h2>Services</h2>
        <p>TÍNH NĂNG<br></p>
        </div><!-- End Section Title -->

        <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-5">

            <div class="col-xl-4 col-md-6" data-aos="zoom-in" data-aos-delay="200">
            <div class="service-item">
                <div class="img">
                <img src="img/listen_service.jpg" class="img-fluid" alt="">
                </div>
                <div class="details position-relative">
                <div class="icon">
                    <i class="bi bi-ear"></i>
                </div>
                <a href="service-details.html" class="stretched-link">
                    <h3>Luyện nghe</h3>
                </a>
                <p>Cải thiện kỹ năng nghe tiếng Anh của bạn với các bài tập âm thanh và video hấp dẫn phù hợp với các cấp độ khác nhau.</p>
                </div>
            </div>
            </div><!-- End Service Item -->

            <div class="col-xl-4 col-md-6" data-aos="zoom-in" data-aos-delay="300">
            <div class="service-item">
                <div class="img">
                <img src="img/vocab_service.jpg" class="img-fluid" alt="">
                </div>
                <div class="details position-relative">
                <div class="icon">
                    <i class="bi bi-card-text"></i>
                </div>
                <a href="service-details.html" class="stretched-link">
                    <h3>Xây dựng từ vựng</h3>
                </a>
                <p>Mở rộng vốn từ vựng của bạn bằng thẻ ghi chú tương tác, danh sách từ và ví dụ thực tế.</p>
                </div>
            </div>
            </div><!-- End Service Item -->

            <div class="col-xl-4 col-md-6" data-aos="zoom-in" data-aos-delay="400">
            <div class="service-item">
                <div class="img">
                <img src="img/exam_service.jpg" class="img-fluid" alt="">
                </div>
                <div class="details position-relative">
                <div class="icon">
                    <i class="bi bi-journal-check"></i>
                </div>
                <a href="service-details.html" class="stretched-link">
                    <h3>Bài kiểm tra & trắc nghiệm</h3>
                </a>
                <p>Thử thách bản thân bằng các bài kiểm tra tùy chỉnh để theo dõi tiến độ và khả năng duy trì của bạn.</p>
                </div>
            </div>
            </div><!-- End Service Item -->

        </div>

        </div>

    </section>

    <section id="clients" class="clients section light-background">

        <div class="container" data-aos="fade-up">

        <div class="row gy-4">

            <div class="col-xl-2 col-md-3 col-6 client-logo">
            <img src="img/clients/client-1.png" class="img-fluid" alt="">
            </div><!-- End Client Item -->

            <div class="col-xl-2 col-md-3 col-6 client-logo">
            <img src="img/clients/client-2.png" class="img-fluid" alt="">
            </div><!-- End Client Item -->

            <div class="col-xl-2 col-md-3 col-6 client-logo">
            <img src="img/clients/client-3.png" class="img-fluid" alt="">
            </div><!-- End Client Item -->

            <div class="col-xl-2 col-md-3 col-6 client-logo">
            <img src="img/clients/client-4.png" class="img-fluid" alt="">
            </div><!-- End Client Item -->

            <div class="col-xl-2 col-md-3 col-6 client-logo">
            <img src="img/clients/client-5.png" class="img-fluid" alt="">
            </div><!-- End Client Item -->

            <div class="col-xl-2 col-md-3 col-6 client-logo">
            <img src="img/clients/client-6.png" class="img-fluid" alt="">
            </div><!-- End Client Item -->

        </div>

        </div>

    </section>

    <section id="features" class="features section">

        <div class="container">

        <ul class="nav nav-tabs row  d-flex" data-aos="fade-up" data-aos-delay="100">
            <li class="nav-item col-3">
            <a class="nav-link active show" data-bs-toggle="tab" data-bs-target="#features-tab-1">
                <i class="bi bi-headphones"></i>
                <h4 class="d-none d-lg-block">Luyện nghe hiệu quả</h4>
            </a>
            </li>
            <li class="nav-item col-3">
            <a class="nav-link" data-bs-toggle="tab" data-bs-target="#features-tab-2">
                <i class="bi bi-box-seam"></i>
                <h4 class="d-none d-lg-block">Xây dựng từ vựng</h4>
            </a>
            </li>
            <li class="nav-item col-3">
            <a class="nav-link" data-bs-toggle="tab" data-bs-target="#features-tab-3">
                <i class="bi bi-journal-text"></i>
                <h4 class="d-none d-lg-block">Làm bài kiểm tra</h4>
            </a>
            </li>
            <li class="nav-item col-3">
            <a class="nav-link" data-bs-toggle="tab" data-bs-target="#features-tab-4">
                <i class="bi bi-people"></i>
                <h4 class="d-none d-lg-block">Cộng đồng học tập</h4>
            </a>
            </li>
        </ul><!-- End Tab Nav -->

        <div class="tab-content" data-aos="fade-up" data-aos-delay="200">

            <div class="tab-pane fade active show" id="features-tab-1">
            <div class="row">
                <div class="col-lg-6 order-2 order-lg-1 mt-3 mt-lg-0">
                <h3>Luyện Nghe Hiệu Quả</h3>
                <p class="fst-italic">
                    Rèn luyện kỹ năng nghe tiếng Anh với phương pháp khoa học, giúp bạn cải thiện khả năng hiểu và phản xạ ngôn ngữ một cách tự nhiên.
                </p>
                <ul>
                    <li><i class="bi bi-check2-all"></i><span>Bài tập nghe đa dạng – Nghe theo cấp độ, chủ đề và tình huống thực tế.</span></li>
                    <li><i class="bi bi-check2-all"></i> <span>Phương pháp Dictation – Nghe và viết lại để nâng cao khả năng nhận diện âm thanh.</span>.</li>
                    <li><i class="bi bi-check2-all"></i> <span>Luyện tập với phụ đề – Hỗ trợ transcript để so sánh và kiểm tra kết quả ngay lập tức.</span></li>
                </ul>
                <p>
                    Chỉ cần dành vài phút mỗi ngày, bạn sẽ thấy sự tiến bộ rõ rệt trong việc nghe hiểu tiếng Anh, giúp bạn tự tin hơn khi giao tiếp thực tế! 
                </p>
                </div>
                <div class="col-lg-6 order-1 order-lg-2 text-center">
                <img src="img/nghe.jpg" alt="" class="img-fluid rounded-4">
                </div>
            </div>
            </div><!-- End Tab Content Item -->

            <div class="tab-pane fade" id="features-tab-2">
            <div class="row">
                <div class="col-lg-6 order-2 order-lg-1 mt-3 mt-lg-0">
                <h3>Xây Dựng Từ Vựng Hiệu Quả</h3>
                <p>
                    Mở rộng vốn từ vựng tiếng Anh với phương pháp học thông minh, giúp bạn ghi nhớ lâu hơn và áp dụng dễ dàng vào thực tế.
                </p>
                <ul>
                    <li><i class="bi bi-check2-all"></i> <span>Học từ vựng theo chủ đề – Dễ dàng tiếp cận với các từ ngữ phổ biến theo từng lĩnh vực.</span></li>
                    <li><i class="bi bi-check2-all"></i> <span>Flashcard & bài tập tương tác – Ôn tập hiệu quả với hình ảnh, âm thanh và câu ví dụ sinh động.</span></li>
                    <li><i class="bi bi-check2-all"></i> <span>Tạo danh sách từ vựng cá nhân – Lưu lại từ cần học và theo dõi tiến độ của bạn.</span></li>
                </ul>
                <p>
                    Chỉ với vài phút mỗi ngày, bạn sẽ dần xây dựng được vốn từ vựng phong phú, giúp việc đọc, viết và giao tiếp tiếng Anh trở nên dễ dàng hơn! 
                </p>
                </div>
                <div class="col-lg-6 order-1 order-lg-2 text-center">
                <img src="img/vocab.jpg" alt="" class="img-fluid rounded-4">
                </div>
            </div>
            </div><!-- End Tab Content Item -->

            <div class="tab-pane fade" id="features-tab-3">
            <div class="row">
                <div class="col-lg-6 order-2 order-lg-1 mt-3 mt-lg-0">
                <h3>Làm Bài Kiểm Tra Hiệu Quả</h3>
                <p>
                    Kiểm tra và đánh giá trình độ tiếng Anh của bạn với hệ thống bài test đa dạng, giúp bạn xác định điểm mạnh và cải thiện điểm yếu.
                </p>
                <ul>
                    <li><i class="bi bi-check2-all"></i> <span>Bài kiểm tra theo cấp độ – Từ cơ bản đến nâng cao, phù hợp với mọi trình độ.</span></li>
                    <li><i class="bi bi-check2-all"></i> <span> Nhiều dạng câu hỏi – Trắc nghiệm, điền từ, nghe – viết, sắp xếp câu... giúp ôn luyện toàn diện.</span></li>
                    <li><i class="bi bi-check2-all"></i> <span>Phản hồi & chấm điểm tự động – Xem kết quả ngay lập tức và nhận gợi ý cải thiện.</span></li>
                </ul>
                <p class="fst-italic">
                    Thực hành thường xuyên với các bài kiểm tra sẽ giúp bạn theo dõi tiến độ học tập, nâng cao kỹ năng và tự tin hơn khi sử dụng tiếng Anh!
                </p>
                </div>
                <div class="col-lg-6 order-1 order-lg-2 text-center">
                <img src="img/exam.jpg" alt="" class="img-fluid rounded-4">
                </div>
            </div>
            </div><!-- End Tab Content Item -->

            <div class="tab-pane fade" id="features-tab-4">
            <div class="row">
                <div class="col-lg-6 order-2 order-lg-1 mt-3 mt-lg-0">
                <h3>Cộng Đồng Học Tập Sôi Động</h3>
                <p>
                    Kết nối với những người học tiếng Anh trên khắp thế giới, cùng nhau chia sẻ kinh nghiệm và nâng cao kỹ năng mỗi ngày.
                </p>
                <ul>
                    <li><i class="bi bi-check2-all"></i> <span>Thảo luận & hỏi đáp – Đặt câu hỏi, chia sẻ mẹo học và nhận hỗ trợ từ cộng đồng.</span></li>
                    <li><i class="bi bi-check2-all"></i> <span>Luyện tập giao tiếp – Thực hành hội thoại với bạn bè hoặc tham gia nhóm học tập.</span></li>
                    <li><i class="bi bi-check2-all"></i> <span></span>Thử thách & thi đua – Cùng nhau chinh phục mục tiêu học tập qua các thử thách thú vị.</li>
                </ul>
                <p class="fst-italic">
                    Học tiếng Anh sẽ dễ dàng và thú vị hơn khi bạn có một cộng đồng đồng hành, cùng nhau tiến bộ và đạt được mục tiêu nhanh chóng!
                </p>
                </div>
                <div class="col-lg-6 order-1 order-lg-2 text-center">
                <img src="img/community.jpg" alt="" class="img-fluid rounded-4">
                </div>
            </div>
            </div><!-- End Tab Content Item -->

        </div>

        </div>

    </section>

    <section id="testimonials" class="testimonials section dark-background">
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">

                    <!-- Feedback 1 -->
                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <img src="img/testimonials/testimonials-1.jpg" class="testimonial-img" alt="">
                            <h3>Thanh Tùng</h3>
                            <h4>DTU Student</h4>
                            <div class="stars">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <p>
                                <i class="bi bi-quote quote-icon-left"></i>
                                <span>Trang web này thực sự tuyệt vời! Các bài nghe và từ vựng rất dễ hiểu và hữu ích.</span>
                                <i class="bi bi-quote quote-icon-right"></i>
                            </p>
                        </div>
                    </div>

                    <!-- Feedback 2 -->
                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <img src="img/testimonials/testimonials-2.jpg" class="testimonial-img" alt="">
                            <h3>Ngọc Anh</h3>
                            <h4>Giáo viên Tiếng Anh</h4>
                            <div class="stars">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <p>
                                <i class="bi bi-quote quote-icon-left"></i>
                                <span>Website có nhiều nội dung hay, bài luyện nghe rất hiệu quả cho học viên.</span>
                                <i class="bi bi-quote quote-icon-right"></i>
                            </p>
                        </div>
                    </div>

                    <!-- Feedback 3 -->
                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <img src="img/testimonials/testimonials-3.jpg" class="testimonial-img" alt="">
                            <h3>Minh Tú</h3>
                            <h4>Người đi làm</h4>
                            <div class="stars">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <p>
                                <i class="bi bi-quote quote-icon-left"></i>
                                <span>Giao diện đơn giản, dễ sử dụng. Học mỗi ngày giúp mình cải thiện kỹ năng nghe.</span>
                                <i class="bi bi-quote quote-icon-right"></i>
                            </p>
                        </div>
                    </div>

                    <!-- Feedback 4 -->
                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <img src="img/testimonials/testimonials-3.jpg" class="testimonial-img" alt="">
                            <h3>Minh Tú</h3>
                            <h4>Người đi làm</h4>
                            <div class="stars">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <p>
                                <i class="bi bi-quote quote-icon-left"></i>
                                <span>Giao diện đơn giản, dễ sử dụng. Học mỗi ngày giúp mình cải thiện kỹ năng nghe.</span>
                                <i class="bi bi-quote quote-icon-right"></i>
                            </p>
                        </div>
                    </div>

                    <!-- Feedback 5 -->
                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <img src="img/testimonials/testimonials-3.jpg" class="testimonial-img" alt="">
                            <h3>Minh Tú</h3>
                            <h4>Người đi làm</h4>
                            <div class="stars">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <p>
                                <i class="bi bi-quote quote-icon-left"></i>
                                <span>Giao diện đơn giản, dễ sử dụng. Học mỗi ngày giúp mình cải thiện kỹ năng nghe.</span>
                                <i class="bi bi-quote quote-icon-right"></i>
                            </p>
                        </div>
                    </div>

                </div>
                <!-- Pagination -->
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>

    <section id="team" class="team section light-background">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
        <h2>Team</h2>
        <p>SUPPORT TEAM</p>
        </div><!-- End Section Title -->

        <div class="container">

        <div class="row gy-5">

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
            <div class="member">
                <div class="pic"><img src="img/team/team-1.jpg" class="img-fluid" alt=""></div>
                <div class="member-info">
                <h4>Phan Thế Tài</h4>
                <span>Customer Support</span>
                <div class="social">
                    <a href=""><i class="bi bi-twitter-x"></i></a>
                    <a href=""><i class="bi bi-facebook"></i></a>
                    <a href=""><i class="bi bi-instagram"></i></a>
                    <a href=""><i class="bi bi-linkedin"></i></a>
                </div>
                </div>
            </div>
            </div><!-- End Team Member -->

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
            <div class="member">
                <div class="pic"><img src="img/team/team-2.jpg" class="img-fluid" alt=""></div>
                <div class="member-info">
                <h4>Nguyễn Đức Thắng</h4>
                <span>Admin/Moderator</span>
                <div class="social">
                    <a href=""><i class="bi bi-twitter-x"></i></a>
                    <a href=""><i class="bi bi-facebook"></i></a>
                    <a href=""><i class="bi bi-instagram"></i></a>
                    <a href=""><i class="bi bi-linkedin"></i></a>
                </div>
                </div>
            </div>
            </div><!-- End Team Member -->

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
            <div class="member">
                <div class="pic"><img src="img/team/team-3.jpg" class="img-fluid" alt=""></div>
                <div class="member-info">
                <h4>Nguyễn Hòa Nam</h4>
                <span>Academic Team</span>
                <div class="social">
                    <a href=""><i class="bi bi-twitter-x"></i></a>
                    <a href=""><i class="bi bi-facebook"></i></a>
                    <a href=""><i class="bi bi-instagram"></i></a>
                    <a href=""><i class="bi bi-linkedin"></i></a>
                </div>
                </div>
            </div>
            </div><!-- End Team Member -->

        </div>

        </div>

    </section>
</main>
@endsection
