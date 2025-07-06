@extends('layouts.app')
@section('content')
<style>
    .text-danger {
        color: #e72010 !important;
    }
</style>
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="contact-us container">
        <div class="mw-930">
            <h2 class="page-title">CONTACT US</h2>
        </div>
    </section>

    <hr class="mt-2 text-secondary " />
    <div class="mb-4 pb-4"></div>

    <section class="contact-us container">
        <div class="mw-930">
            <div class="contact-us__form">
                @if (Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ Session::get('success') }}
                </div>
                @endif
                <form action="{{route('home.contact.store')}}" name="contact-us-form" class="needs-validation" novalidate="" method="POST">
                    @csrf
                    <h3 class="mb-5">Get In Touch</h3>
                    <div class="form-floating my-4">
                        <input type="text" class="form-control" name="name" placeholder="Name *" value="{{old('name')}}" required="">
                        <label for="contact_us_name">Name *</label>
                        @error('name')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-floating my-4">
                        <input type="text" class="form-control" name="phone" placeholder="Phone *" value="{{old('phone')}}" required="">
                        <label for="contact_us_name">Phone *</label>
                        @error('phone')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-floating my-4">
                        <input type="email" class="form-control" name="email" placeholder="Email address *" value="{{old('email')}}" required="">
                        <label for="contact_us_name">Email address *</label>
                        @error('email')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="my-4">
                        <textarea class="form-control form-control_gray" name="comment" placeholder="Your Message" cols="30"
                            rows="8" required="">{{old('comment')}}</textarea>
                        @error('comment')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="my-4">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
            <!-- Google Maps Embed -->
            <div class="ratio ratio-16x9">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2949.280348515156!2d85.32852187453419!3d27.667376427254993!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb195c5094c7e3%3A0xa14e4acd90c5395!2sBaAma%20Consultant%20Service%20Pvt.%20Ltd.!5e1!3m2!1sen!2snp!4v1751799607293!5m2!1sen!2snp" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </section>
</main>
@endsection
