@props([
    'title' => 'SILAPRADI - Layanan Pengaduan Ramah Disabilitas',
    'description' => 'Sistem Informasi Layanan Pengaduan Ramah Disabilitas - SILAPRADI. Sampaikan pengaduan Anda dengan mudah dan aman.',
    'image' => asset('img/example_welcome_view.png'),
])

<title>{{ $title }}</title>
<meta name="description" content="{{ $description }}">

<!-- Canonical URL -->
<link rel="canonical" href="{{ url()->current() }}">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:image" content="{{ $image }}">
<meta property="og:image:alt" content="{{ $title }}">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="{{ url()->current() }}">
<meta property="twitter:title" content="{{ $title }}">
<meta property="twitter:description" content="{{ $description }}">
<meta property="twitter:image" content="{{ $image }}">
<meta property="twitter:image:alt" content="{{ $title }}">
