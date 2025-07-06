@extends('layouts.app')
@section('content')
@push('scripts')
  <script src="https://cdn.tailwindcss.com"></script>
@endpush

<body class="font-sans text-gray-700">

  <!-- Hero Banner -->
  <section class="relative h-[200px] bg-cover bg-center" style="background-image: url('https://dummyimage.com/1600x500/000/');">
    <div class="absolute inset-0 bg-black bg-opacity-50"></div>
    <div class="relative z-10 flex flex-col justify-center items-center h-full text-center text-red">
      <h1 class="text-4xl md:text-5xl font-bold mb-2 text-red">About Pabis Collection</h1>
      <p class="text-lg md:text-xl">Redefining fashion with elegance and authenticity</p>
    </div>
  </section>

  <!-- About Section -->
  <section class="py-16 px-4 max-w-7xl mx-auto">
    <div class="flex flex-col md:flex-row items-center gap-8">
      <div class="md:w-1/2">
        <img src="assets/images/shop/shop_banner3.jpg" alt="Pabis Collection" class="rounded-lg shadow-lg w-full h-auto" />
      </div>
      <div class="md:w-1/2">
        <h2 class="text-3xl font-bold mb-4">Who We Are</h2>
        <p class="mb-4">
          At <strong>Pabis Collection</strong>, we believe fashion is more than clothing — it's an expression of identity and creativity.
          Founded with a vision to empower individuals through stylish and affordable apparel, we curate collections that blend tradition, trends, and craftsmanship.
        </p>
        <p>
          Whether you're dressing for daily life or a special occasion, our pieces are designed to make you feel confident, comfortable, and uniquely you.
        </p>
      </div>
    </div>
  </section>

  <!-- Mission & Values -->
  <section class="bg-gray-100 py-16 px-4">
    <div class="max-w-7xl mx-auto text-center">
      <h2 class="text-3xl font-bold mb-12">Our Mission & Values</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div>
          <h4 class="text-xl font-semibold mb-2">Quality First</h4>
          <p>We source high-quality fabrics to ensure every product meets our premium standards.</p>
        </div>
        <div>
          <h4 class="text-xl font-semibold mb-2">Inclusive Fashion</h4>
          <p>Style for everyone — we celebrate diversity through our inclusive sizing and modern designs.</p>
        </div>
        <div>
          <h4 class="text-xl font-semibold mb-2">Sustainability</h4>
          <p>We're committed to ethical production and environmentally conscious practices.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Call to Action -->
  <section class="py-16 px-4 text-center">
    <div class="max-w-2xl mx-auto">
      <h3 class="text-3xl font-bold mb-4">Join the Pabis Community</h3>
      <p class="mb-6">Stay updated with our latest collections, offers, and style inspiration.</p>
      <a href="{{route('shop.index')}}" class="inline-block bg-black text-white px-6 py-3 rounded hover:bg-gray-800 transition">Shop Now</a>
    </div>
  </section>
@endsection
