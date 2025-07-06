@extends('layouts.app')
@section('content')
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="contact-us container">
        <div class="mw-930">
            <h2 class="page-title">About US</h2>
        </div>

        <div class="about-us__content pb-5 mb-5">
            <p class="mb-5">
                <img loading="lazy" class="w-100 h-auto d-block" src="assets/images/about/about-1.jpg" width="1410"
                    height="550" alt="" />
            </p>
            <div class="mw-930">
                <h3 class="mb-4">OUR STORY</h3>
                <p class="fs-6 fw-medium mb-4">At Pabis Collection, fashion is not just about clothing — it’s a lifestyle, a voice, a reflection of individuality.
                    Founded with the dream of bringing together elegance, comfort, and cultural identity,
                    we are committed to crafting pieces that celebrate self-expression and empower confidence.</p>
                <p class="mb-4">From humble beginnings, Pabis Collection has grown into a trusted name in the fashion industry by blending modern trends with timeless styles.
                    Our garments are designed with precision, passion, and an understanding of the diverse needs of our customers.

                    We believe in storytelling through design — and every piece we create carries the narrative of craftsmanship, authenticity, and purpose.</p>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h5 class="mb-3">Our Mission</h5>
                        <p class="mb-3">To deliver high-quality, stylish, and affordable fashion that inspires confidence, celebrates individuality,
                            and brings joy to every wardrobe — while embracing sustainability and responsible craftsmanship.</p>
                    </div>
                    <div class="col-md-6">
                        <h5 class="mb-3">Our Vision</h5>
                        <p class="mb-3">To become a leading fashion brand known for empowering self-expression through inclusive, sustainable, and trend-forward clothing —
                            loved by individuals who value both quality and meaning in what they wear.</p>
                    </div>
                </div>
            </div>
            <div class="mw-930 d-lg-flex align-items-lg-center">
                <div class="image-wrapper col-lg-6">
                    <img class="h-auto" loading="lazy" src="assets/images/about.jpg" width="450" height="500" alt="">
                </div>
                <div class="content-wrapper col-lg-6 px-lg-4">
                    <h5 class="mb-3">The Company</h5>
                    <p>Pabis Collection is more than a fashion brand — it's a movement toward mindful fashion that embraces beauty, diversity, and creativity.

                        We specialize in curating collections that merge contemporary aesthetics with everyday comfort. Every product is thoughtfully designed and carefully manufactured to meet the highest standards of quality.

                        With a strong belief in ethical production and a customer-first philosophy, we aim to build lasting relationships and deliver experiences that go beyond just clothing.

                        From runway-inspired styles to casual essentials, Pabis Collection is here to dress you for every moment — with confidence, grace, and style.</p>
                </div>
            </div>
        </div>
    </section>
    <!-- Call to Action -->
    <section class="pb-5 text-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h3 class="mb-3">Join the Pabis Community</h3>
                    <p class="mb-4">Stay connected with Pabis Collection for the latest fashion trends, exclusive offers, new arrivals, and timeless style inspiration —
                         delivered straight to you to keep your wardrobe fresh and on point.</p>
                    <a href="{{ route('shop.index') }}" class="btn btn-dark btn-lg">Shop Now</a>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
