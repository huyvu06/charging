@extends('nav.header')
@section('title', 'Chi tiết')
@section('content')

    <div class="container mt-4">
        <div class="row">
            <!-- Article Content -->
            <div class="col-md-8">
                <h2>VinFast tham dự EVS35 – Ra mắt VF 8 và VF 9 tại Châu Âu</h2>
                <p class="text-muted">Posted on 24 tháng 7, 2024 by Trạm Sạc</p>

                <img src="{{asset('images/tram-sac-12.jpg')}}" class="img-fluid mb-4" alt="Article Image">

                <p>Hội nghị và Triển lãm Xe điện Quốc Tế là một sự kiện nổi tiếng và có nhiều ảnh hưởng quan trọng trong
                    ngành công nghiệp ô tô điện. VinFast đã giới thiệu hai mẫu xe mới của mình, VF 8 và VF 9, hứa hẹn sẽ làm
                    thay đổi diện mạo của ngành ô tô điện.</p>

                <hr>

                <!-- Author Section -->
                <div class="media mb-4">
                    <img src="{{asset('images/tram-sac-12.jpg')}}" class="mr-3 rounded-circle" alt="Author Avatar" style="width: 64px;">
                    <div class="media-body">
                        <h5 class="mt-0">TRAMSAC</h5>
                        <p>Author's bio or description goes here. You can include any other relevant information.</p>
                    </div>
                </div>

                <!-- Comments Section -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Trả lời</h5>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="form-group">
                                <textarea class="form-control" rows="4" placeholder="Ý kiến của bạn"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Gửi bình luận</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Sidebar for Recent Posts -->
            <div class="col-md-4">
                <h5>Bài viết mới</h5>
                <ul class="list-group mb-4">
                    <li class="list-group-item"><a href="#">VinFast tham dự EVS35 – Ra mắt VF 8 và VF 9 tại Châu
                            Âu</a></li>
                    <li class="list-group-item"><a href="#">Hyundai dừng phân phối dòng xe Kona tại Việt Nam</a></li>
                    <li class="list-group-item"><a href="#">Chào tất cả mọi người!</a></li>
                </ul>
            </div>
        </div>
    </div>

    {{-- <!-- Map Section -->
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <h5>Bản đồ</h5>
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.4226764426547!2d106.69305671480025!3d10.775653692321214!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752929258a7b0d%3A0xf472d71e62b36261!2sTo%C3%A0%20nh%C3%A0%20V%C4%83n%20ph%C3%B2ng%20Symphony%20Office%20Building!5e0!3m2!1svi!2s!4v1598412023327!5m2!1svi!2s"
                        allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div> --}}


@endsection
