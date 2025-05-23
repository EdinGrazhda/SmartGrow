<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartGrow</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="styles.css">
            <link rel="icon" href="img/logo3.png">

    <style>
        /* Global Styles */
:root {
    --primary-color: #79a62f ;
    --secondary-color: #134c1f;
    --dark-color: #377f2b ;
    --light-color: #f8f9fc;
    --transition: all 0.3s ease;
}

body {
    font-family: 'Poppins', sans-serif;
    color: #333;
    overflow-x: hidden;
}

h1, h2, h3, h4, h5, h6 {
    font-weight: 700;
}

a {
    text-decoration: none;
    transition: var(--transition);
}

.section-heading {
    font-size: 2.5rem;
    margin-bottom: 1rem;
    position: relative;
    display: inline-block;
}

.section-heading::after {
    content: '';
    position: absolute;
    width: 50px;
    height: 3px;
    background-color: var(--primary-color);
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
}

.section-subheading {
    color: #6c757d;
    margin-bottom: 2rem;
}

/* Navbar Styles */
.navbar {
    padding: 1rem 0;
    transition: var(--transition);
    background-color: transparent;
}

.navbar.scrolled {
    background-color: white;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    padding: 0.5rem 0;
}

.navbar-brand {
    font-weight: 700;
    font-size: 1.5rem;
    color: var(--primary-color);
}

.nav-link {
    font-weight: 500;
    margin: 0 10px;
    position: relative;
}

.nav-link::after {
    content: '';
    position: absolute;
    width: 0;
    height: 2px;
    background-color: var(--secondary-color);
    bottom: 0;
    left: 0;
    transition: var(--transition);
}

.nav-link:hover::after {
    width: 100%;
}

/* Hero Section */
.hero-section {
    height: 100vh;
    background: url('https://via.placeholder.com/1920x1080') no-repeat center center;
    background-size: cover;
    position: relative;
    color: white;
    display: flex;
    align-items: center;
}

.hero-section .overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #78a62f75 0%, #79a62f 100%);
}

.animated-heading {
    font-size: 3.5rem;
    margin-bottom: 1.5rem;
    opacity: 0;
    transform: translateY(30px);
    animation: fadeInUp 1s ease forwards 0.5s;
}

.animated-text {
    font-size: 1.5rem;
    margin-bottom: 2rem;
    opacity: 0;
    transform: translateY(30px);
    animation: fadeInUp 1s ease forwards 0.8s;
}

.animated-button {
    opacity: 0;
    transform: translateY(30px);
    animation: fadeInUp 1s ease forwards 1.1s;
    background-color: var(--secondary-color);
    border: none;
    padding: 0.75rem 2rem;
    transition: var(--transition);
}

.animated-button:hover {
    background-color: #79a62f ;
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
}

.highlight {
    color: var(--secondary-color);
}

.wave-container {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
}

/* Services Section */
.service-card {
    background-color: white;
    padding: 2rem;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    transition: var(--transition);
    height: 100%;
}

.service-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
}

.icon-box {
    width: 70px;
    height: 70px;
    background-color: var(--light-color);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    transition: var(--transition);
}

.service-card:hover .icon-box {
    background-color: var(--primary-color);
    color: white;
}

.icon-box i {
    font-size: 1.8rem;
    color: var(--primary-color);
    transition: var(--transition);
}

.service-card:hover .icon-box i {
    color: white;
}

.service-card h3 {
    font-size: 1.5rem;
    margin-bottom: 1rem;
    text-align: center;
}

.service-card p {
    color: #6c757d;
    text-align: center;
}

/* Mission Section */
.mission-image img {
    transition: var(--transition);
}

.mission-image:hover img {
    transform: scale(1.05);
}

.mission-content {
    padding: 2rem;
}

.mission-content .section-heading {
    text-align: left;
}

.mission-content .section-heading::after {
    left: 0;
    transform: none;
}

.mission-values {
    margin-top: 2rem;
}

.value-item {
    display: flex;
    align-items: center;
    margin-bottom: 1rem;
}

.value-item i {
    color: var(--primary-color);
    margin-right: 1rem;
    font-size: 1.2rem;
}

/* Counter Section */
.counter-section {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--dark-color) 100%);
    color: white;
    padding: 5rem 0;
}

.counter-box {
    text-align: center;
    padding: 2rem;
}

.counter-box i {
    font-size: 3rem;
    margin-bottom: 1.5rem;
    color: var(--secondary-color);
}

.counter-box h3 {
    font-size: 3rem;
    margin-bottom: 1rem;
}

.counter-box p {
    font-size: 1.2rem;
    opacity: 0.8;
}

/* Testimonials Section */
.testimonial-item {
    padding: 3rem;
}

.testimonial-img {
    width: 100px;
    height: 100px;
    margin: 0 auto 2rem;
    overflow: hidden;
    border: 5px solid var(--light-color);
}

.testimonial-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.testimonial-text {
    font-size: 1.2rem;
    font-style: italic;
    margin-bottom: 1.5rem;
    color: #555;
}

.client-position {
    color: var(--primary-color);
    font-weight: 500;
}

.carousel-control-prev,
.carousel-control-next {
    width: 50px;
    height: 50px;
    background-color: var(--primary-color);
    border-radius: 50%;
    top: 50%;
    transform: translateY(-50%);
    opacity: 0.7;
}

.carousel-control-prev {
    left: -25px;
}

.carousel-control-next {
    right: -25px;
}

.carousel-control-prev:hover,
.carousel-control-next:hover {
    opacity: 1;
}

/* Contact Section */
.contact-info {
    background-color: #4eb052;
    color: white;
    padding: 3rem;
    border-radius: 10px;
    height: 100%;
}

.contact-info h3 {
    margin-bottom: 1.5rem;
}

.contact-item {
    display: flex;
    align-items: flex-start;
    margin-bottom: 1.5rem;
}

.contact-item i {
    margin-right: 1rem;
    font-size: 1.2rem;
}

.social-links {
    display: flex;
}

.social-icon {
    width: 40px;
    height: 40px;
    background-color: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    color: white;
    transition: var(--transition);
}

.social-icon:hover {
    background-color: white;
    color: var(--primary-color);
    transform: translateY(-5px);
}

.contact-form {
    background-color: white;
    padding: 3rem;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
}

.form-control {
    padding: 0.8rem 1.2rem;
    border-radius: 5px;
    margin-bottom: 1.5rem;
}

.form-control:focus {
    box-shadow: none;
    border-color: var(--primary-color);
}

/* Footer */
.footer {
    background-color:#4eb052;
    color: white;
}

.footer a {
    color: rgba(255, 255, 255, 0.7);
}

.footer a:hover {
    color: white;
}

.footer-logo {
    font-weight: 700;
    font-size: 1.5rem;
    color: white;
}



/* Back to Top Button */
.back-to-top {
    position: fixed;
    bottom: 30px;
    right: 30px;
    width: 50px;
    height: 50px;
    background-color: var(--primary-color);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 99;
    opacity: 0;
    visibility: hidden;
    transition: var(--transition);
}

.back-to-top.active {
    opacity: 1;
    visibility: visible;
}

.back-to-top:hover {
    background-color: var(--dark-color);
    color: white;
}
.logo11{
    width: 17vw;
    margin: -5vw;
}
/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive Styles */
@media (max-width: 991px) {
    .navbar-collapse {
        background-color: white;
        padding: 1rem;
        border-radius: 5px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .animated-heading {
        font-size: 2.5rem;
    }
    
    .animated-text {
        font-size: 1.2rem;
    }
    
    .mission-content {
        padding: 2rem 0;
        margin-top: 2rem;
    }
    
    .contact-info, .contact-form {
        margin-bottom: 2rem;
    }
}

@media (max-width: 767px) {
    .hero-section {
        height: 80vh;
    }
    
    .animated-heading {
        font-size: 2rem;
    }
    
    .section-heading {
        font-size: 2rem;
    }
    
    .counter-box {
        margin-bottom: 2rem;
    }
    
    .carousel-control-prev,
    .carousel-control-next {
        display: none;
    }
}

.plant {
      width: 100px;
      height: 220px;
      position: relative;
    }

    .head-img {
      position: absolute;
      top: -150px;
      left: 40vw;
      transform: translateX(-50%);
      width: 100px;
      height: 1.1s00px;
      animation: bob 2s ease-in-out infinite;
      transform-origin: bottom center;
    }

    @keyframes bob {
      0%   { transform: translateX(-50%) rotate(0deg); }
      50%  { transform: translateX(-50%) rotate(8deg); }
      100% { transform: translateX(-50%) rotate(0deg); }
    }
.phone-frame {
  width: 300px;
  height: 600px;
  margin: 0 auto;
  background: #000;
  border-radius: 40px;
  padding: 20px;
  position: relative;
  box-shadow: 0 30px 60px rgba(0, 0, 0, 0.5);
  transform: perspective(1000px) rotateX(10deg);
}


/* Phone screen */
    .phone-screen {
    width: 100%;
    height: 100%;
    background: #fff;
    border-radius: 30px;
    overflow: hidden;
    position: relative;
    }
    

/* Carousel inside phone */
.carousel-inner {
  height: 100%;
}

.testimonial-item {
  padding: 20px;
}

.testimonial-img img {
  width: 80px;
  height: 80px;
}

/* Optional: simulate camera and speaker */
.phone-notch {
  position: absolute;
  top: 10px;
  left: 50%;
  transform: translateX(-50%);
  height: 30px;
  width: 120px;
  background: #111;
  border-radius: 20px;
  z-index: 10;
}
 .grass-container {
        height: 30px;
        overflow: hidden;
        position: relative;
        margin-bottom: -1px;
      }

      .grass-blade {
        position: absolute;
        bottom: 0;
        width: 12px;
        height: 30px;
        background: linear-gradient(to top, #4caf50, #81c784);
        border-radius: 50% 50% 0 0;
        transform-origin: bottom center;
        animation: sway 3s infinite ease-in-out;
      }

      @keyframes sway {
        0%,
        100% {
          transform: rotate(-8deg);
        }
        50% {
          transform: rotate(8deg);
        }
      }

      /* Different sized blades for more natural look */
      .grass-blade.small {
        height: 20px;
        width: 8px;
      }

      .grass-blade.large {
        height: 35px;
        width: 14px;
      }

       .banner-ai {
    background: linear-gradient(135deg, var(--secondary-color), var(--dark-color));
    color: var(--light-color);
    padding: 4rem 2rem;
    text-align: center;
    border-radius: 1.5rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
    margin: 3rem auto;
    max-width: 1000px;
    position: relative;
    overflow: hidden;
  }

  .banner-ai h1 {
    font-size: 2.8rem;
    font-weight: 900;
    line-height: 1.3;
    margin-bottom: 1.2rem;
  }

  .banner-ai h1 span.key {
    color: #c8ff8e; /* Light lime for contrast */
  }

  .banner-ai h1 span.time {
    color: #afffcb; /* Minty green for freshness */
  }

  .banner-ai p {
    font-size: 1.25rem;
    margin-bottom: 2rem;
    color: var(--light-color);
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
  }

  .banner-ai a button {
    background-color: var(--primary-color);
    color: white;
    border: none;
    padding: 0.85rem 2.2rem;
    font-size: 1.1rem;
    font-weight: 600;
    border-radius: 100px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
  }

  .banner-ai a button:hover {
    background-color: var(--light-color);
    color: var(--dark-color);
    transform: translateY(-2px) scale(1.05);
  }
        </style>
</head>
<body class="loading">
<?php include('loading.php'); ?>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <!-- <a class="navbar-brand" href="#">Your Firm</a> -->
            <img src="img/logo1.png" alt="Farm illustration with tractor" class="logo11">    

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#services">SERVICES</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#mission">OUR MISSION</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#demo">DEMO</a>
                    </li>   
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">CONTACT FORM</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">REGISTER</a>
                    </li><li class="nav-item">
                        <a class="nav-link" href="login.php">LOGIN</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

<!-- Hero Banner Section -->
<section id="home" class="hero-section">
  <div class="overlay"></div>
  <div class="container h-100">
    <div class="row h-100 align-items-center">
      <div class="col-lg-8 mx-auto text-center text-white">
        <h1 class="animated-heading">Welcome to <span class="highlight">SmartGrow</span></h1>
        <p class="lead animated-text">Your Digital Gateway to Fermentation Excellence.</p>
        <a href="#services" class="btn btn-primary btn-lg animated-button">Explore Our Services</a>
      </div>
    </div>
  </div>

  <!-- Wave effect at bottom of hero section -->
  <div class="wave-container">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
      <path fill="#ffffff" fill-opacity="1"
        d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,149.3C960,160,1056,160,1152,138.7C1248,117,1344,75,1392,53.3L1440,32L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
      </path>
    </svg>
  </div>
</section>

    <!-- Services Section -->
    <section id="services" class="py-5">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-lg-8 mx-auto">
                    <h2 class="section-heading" data-aos="fade-up">Our Services</h2>
                    <p class="section-subheading" data-aos="fade-up" data-aos-delay="100">SmartGrow offers innovative, sustainable farming services to help you grow smarter and harvest better.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="service-card">
                        <div class="icon-box">
                            <i class="fa-solid fa-plant-wilt"></i>
                        </div>
                        <h3>Precision Farming Solutions</h3>
                        <p>Maximize yield and efficiency using data-driven techniques, including soil sensors, GPS mapping, and AI analytics.</p>
                    </div>
                </div>
                <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="service-card">
                        <div class="icon-box">
                            <i class="fa-solid fa-tractor"></i>
                        </div>
                        <h3>Organic Crop Cultivation</h3>
                        <p>Grow and deliver fresh, organic produce cultivated without harmful chemicals or synthetic fertilizers.</p>
                    </div>
                </div>
                <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="400">
                    <div class="service-card">
                        <div class="icon-box">
                            <i class="fa-solid fa-wheat-awn"></i>
                        </div>
                        <h3>Smart Greenhouse Management</h3>
                        <p>Automate climate control, irrigation, and lighting for consistent crop growth year-round.</p>
                    </div>
                </div>
                <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="500">
                    <div class="service-card">
                        <div class="icon-box">
                            <i class="fa-solid fa-sun-plant-wilt"></i>
                        </div>
                        <h3>Sustainable Livestock Care</h3>
                        <p>Ethical and eco-friendly livestock management with a focus on animal welfare and environmental balance.</p>
                    </div>
                </div>
                <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="600">
                    <div class="service-card">
                        <div class="icon-box">
                            <i class="fa-solid fa-seedling"></i>
                        </div>
                        <h3>AgriTech Consulting</h3>
                        <p>Personalized guidance on integrating technology into traditional farming practices for improved productivity.</p>
                    </div>
                </div>
                <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="700">
                    <div class="service-card">
                        <div class="icon-box">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <h3>Farm-to-Table Distribution</h3>
                        <p>Direct delivery of fresh farm produce to local markets, restaurants, and homes—reducing waste and travel time.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

      <section class="banner-ai" id="demo">
  <h1><span class="key">Diagnose</span> Your Plant’s Health <span class="time">in Seconds</span></h1>
  <p>Snap a photo and let our AI detect diseases, deficiencies, and offer smart care tips—on the spot.</p>
  <a href="ai.php"><button>🌿 Try Now</button></a>
</section>

 <div class="tower"></div>
    <div class="hub"></div>
    <div class="blades">
      <div class="blade"></div>
      <div class="blade"></div>
      <div class="blade"></div>
      <div class="blade"></div>
    </div>
  </div>
    <!-- Mission Section -->
    <section id="mission" class="py-5 bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="mission-image">
                        <!-- <img src="img/farm.jpg" alt="Our Mission" class="img-fluid rounded shadow"> -->
                         <script type="module" src="https://unpkg.com/@splinetool/viewer@1.9.96/build/spline-viewer.js"></script>
<spline-viewer url="https://prod.spline.design/5jQKLtKWRAAOQuwq/scene.splinecode"></spline-viewer>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="mission-content">
                        <h2 class="section-heading">Our Mission</h2>
                        <p class="lead">At SmartGrow, our mission is to revolutionize farming through innovation, sustainability, and smart technology.</p>
                        <p>We aim to empower farmers with innovative tools, data-driven insights, and eco-friendly solutions that boost productivity while preserving the land for future generations. Our commitment is rooted in progress—with every seed planted, we grow toward a smarter, greener future.</p>
                        <div class="mission-values">
                            <div class="value-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Excellence in Every Digital Harvest</span>
                            </div>
                            <div class="value-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Rooted in Integrity</span>
                            </div>
                            <div class="value-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Innovation That Blooms</span>
                            </div>
                            <div class="value-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Your Success, Our Mission</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Counter Section -->
    <section class="counter-section py-5">
        <div class="container">
            <div class="row text-center">
                <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up">
                    <div class="counter-box">
                        <i class="fas fa-users"></i>
                        <h3 class="counter" data-count="250">0</h3>
                        <p>Happy Clients</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="counter-box">
                        <i class="fas fa-project-diagram"></i>
                        <h3 class="counter" data-count="520">0</h3>
                        <p>Projects Completed</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="counter-box">
                        <i class="fas fa-clock"></i>
                        <h3 class="counter" data-count="15">0</h3>
                        <p>Years of Experience</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="counter-box">
                        <i class="fas fa-award"></i>
                        <h3 class="counter" data-count="35">0</h3>
                        <p>Awards Won</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section
    <section class="testimonials-section py-5 bg-light">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-lg-8 mx-auto">
                    <h2 class="section-heading" data-aos="fade-up">What Our Clients Say</h2>
                    <p class="section-subheading" data-aos="fade-up" data-aos-delay="100">Hear from businesses we've helped succeed</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="testimonial-item text-center">
                                    <div class="testimonial-img">
                                        <img src="https://via.placeholder.com/100" alt="Client" class="rounded-circle">
                                    </div>
                                    <p class="testimonial-text">"Your Firm transformed our business operations. Their strategic guidance helped us increase efficiency by 40% and expand into new markets."</p>
                                    <h5>John Smith</h5>
                                    <p class="client-position">CEO, Tech Innovations</p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="testimonial-item text-center">
                                    <div class="testimonial-img">
                                        <img src="https://via.placeholder.com/100" alt="Client" class="rounded-circle">
                                    </div>
                                    <p class="testimonial-text">"The team at Your Firm provided exceptional service. Their attention to detail and innovative solutions helped us overcome significant challenges."</p>
                                    <h5>Sarah Johnson</h5>
                                    <p class="client-position">Director, Global Solutions</p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="testimonial-item text-center">
                                    <div class="testimonial-img">
                                        <img src="https://via.placeholder.com/100" alt="Client" class="rounded-circle">
                                    </div>
                                    <p class="testimonial-text">"Working with Your Firm has been a game-changer for our business. Their strategic insights and dedicated support have been invaluable to our growth."</p>
                                    <h5>Michael Brown</h5>
                                    <p class="client-position">Founder, Innovative Startups</p>
                                </div>
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section> -->
<section class="testimonials-section py-5 bg-light">
  <div class="container text-center">
    <div class="row mb-5">
      <div class="col-lg-8 mx-auto">
        <h2 class="section-heading">What Our Clients Say</h2>
        <p class="section-subheading">Hear from businesses we've helped succeed</p>
      </div>
    </div>

    <!-- 3D Phone -->
<div class="phone-frame">
  <div class="phone-notch"></div>
  <div class="phone-screen">
    <div id="photoCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="img/foto1.jpg" class="d-block w-100" alt="Photo 1">
        </div>
        <div class="carousel-item">
          <img src="img/foto2.jpg" class="d-block w-100" alt="Photo 2">
        </div>
        <div class="carousel-item">
          <img src="img/foto3.jpg" class="d-block w-100" alt="Photo 3">
        </div>
      </div>
    </div>
  </div>
</div>
    <!-- Contact Section -->
    <section id="contact" class="py-5">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-lg-8 mx-auto">
                    <h2 class="section-heading" data-aos="fade-up">Get In Touch</h2>
                    <p class="section-subheading" data-aos="fade-up" data-aos-delay="100">We'd love to hear from you</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6" data-aos="fade-down">
                    <div class="contact-info">
                        <h3>Contact Information</h3>
                        <p>Reach out to us for any inquiries or to schedule a consultation.</p>
                        <div class="contact-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>123 Business Avenue, Suite 500, New York, NY 10001</span>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-phone"></i>
                            <span>+1 (555) 123-4567</span>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-envelope"></i>
                            <span>info@yourfirm.com</span>
                        </div>
                        <div class="social-links mt-4">
                            <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-up">
                    <div class="contact-form">
                        <form id="contactForm">
                            <div class="mb-3">
                                <input type="text" class="form-control" id="from_name" name="from_name" placeholder="Your Name" required>
                            </div>
                            <div class="mb-3">
                                <input type="email" class="form-control" id="from_email" name="from_email" placeholder="Your Email" required>
                            </div>
                            <div class="mb-3">
                                <input type="text" class="form-control" id="subject" name="subject" placeholder="Subject">
                            </div>
                            <div class="mb-3">
                                <textarea class="form-control" id="message" name="message" rows="5" placeholder="Your Message" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg w-100" style="background-color: #4eb052">
                                <span id="submit-text">Send Message</span>
                                <span id="submit-spinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                            </button>
                        </form>
                        <div id="formSuccess" class="alert alert-success mt-3 d-none">
                            Your message has been sent successfully!
                        </div>
                        <div id="formError" class="alert alert-danger mt-3 d-none">
                            There was an error sending your message. Please try again.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Grass animation container -->
    <div class="grass-container">
      <!-- Small grass blades -->
      <div
        class="grass-blade small"
        style="left: 2%; animation-delay: 0.1s"
      ></div>
      <div
        class="grass-blade small"
        style="left: 8%; animation-delay: 1s"
      ></div>
      <div
        class="grass-blade small"
        style="left: 17%; animation-delay: 0.5s"
      ></div>
      <div
        class="grass-blade small"
        style="left: 28%; animation-delay: 1.5s"
      ></div>
      <div
        class="grass-blade small"
        style="left: 38%; animation-delay: 0.3s"
      ></div>
      <div
        class="grass-blade small"
        style="left: 55%; animation-delay: 0.9s"
      ></div>
      <div
        class="grass-blade small"
        style="left: 65%; animation-delay: 1.7s"
      ></div>
      <div
        class="grass-blade small"
        style="left: 78%; animation-delay: 0.4s"
      ></div>
      <div
        class="grass-blade small"
        style="left: 88%; animation-delay: 1.2s"
      ></div>
      <div
        class="grass-blade small"
        style="left: 97%; animation-delay: 0.8s"
      ></div>

      <!-- Medium grass blades -->
      <div class="grass-blade" style="left: 5%; animation-delay: 0.7s"></div>
      <div class="grass-blade" style="left: 14%; animation-delay: 0.2s"></div>
      <div class="grass-blade" style="left: 21%; animation-delay: 1.3s"></div>
      <div class="grass-blade" style="left: 32%; animation-delay: 0.6s"></div>
      <div class="grass-blade" style="left: 45%; animation-delay: 1.8s"></div>
      <div class="grass-blade" style="left: 52%; animation-delay: 0.3s"></div>
      <div class="grass-blade" style="left: 61%; animation-delay: 1.1s"></div>
      <div class="grass-blade" style="left: 73%; animation-delay: 0.5s"></div>
      <div class="grass-blade" style="left: 84%; animation-delay: 1.6s"></div>
      <div class="grass-blade" style="left: 92%; animation-delay: 0.9s"></div>

      <!-- Large grass blades -->
      <div
        class="grass-blade large"
        style="left: 10%; animation-delay: 0.4s"
      ></div>
      <div
        class="grass-blade large"
        style="left: 25%; animation-delay: 1.4s"
      ></div>
      <div
        class="grass-blade large"
        style="left: 41%; animation-delay: 0.8s"
      ></div>
      <div
        class="grass-blade large"
        style="left: 58%; animation-delay: 1.9s"
      ></div>
      <div
        class="grass-blade large"
        style="left: 69%; animation-delay: 0.6s"
      ></div>
      <div
        class="grass-blade large"
        style="left: 80%; animation-delay: 1.5s"
      ></div>
      <div
        class="grass-blade large"
        style="left: 95%; animation-delay: 0.3s"
      ></div>
    </div>
      <footer class="footer py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4 text-lg-start">
                    <p class="mb-2">© 2023 Your Firm. All Rights Reserved.</p>
                </div>
                <div class="col-lg-4 text-lg-center">
            <img src="img/logo1.png" alt="Farm illustration with tractor" class="logo11">    
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="#" class="me-3">Privacy Policy</a>
                    <a href="#">Terms of Use</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <a href="#" class="back-to-top"><i class="fas fa-arrow-up"></i></a>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- AOS Animation Library -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <!-- EmailJS Library -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@emailjs/browser@3/dist/email.min.js"></script>
    <!-- Custom JS -->
    <script src="script.js"></script>

    <script>
        $(document).ready(function() {
    // Initialize AOS animation library
    AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: true
    });

    // Navbar scroll effect
    $(window).scroll(function() {
        if ($(this).scrollTop() > 50) {
            $('.navbar').addClass('scrolled');
            $('.back-to-top').addClass('active');
        } else {
            $('.navbar').removeClass('scrolled');
            $('.back-to-top').removeClass('active');
        }
    });

    // Smooth scrolling for navbar links
    $('a.nav-link, .animated-button, .back-to-top').on('click', function(e) {
        if (this.hash !== '') {
            e.preventDefault();
            const hash = this.hash;
            $('html, body').animate({
                scrollTop: $(hash).offset().top - 70
            }, 800);
        }
    });

    // Counter animation
    $('.counter').each(function() {
        $(this).prop('Counter', 0).animate({
            Counter: $(this).data('count')
        }, {
            duration: 300,
            easing: 'swing',
            step: function(now) {
                $(this).text(Math.ceil(now));
            }
        });
    });

    // Services card hover effect
    $('.service-card').hover(
        function() {
            $(this).find('.icon-box').addClass('animated pulse');
        },
        function() {
            $(this).find('.icon-box').removeClass('animated pulse');
        }
    );

    // Testimonial carousel autoplay
    $('#testimonialCarousel').carousel({
        interval: 5000
    });

    // Initialize EmailJS
    (function() {
        // Initialize EmailJS with your public key
        emailjs.init("GIMPfkH3Ozq1MzLcJ");
    })();
    
    // Form submission with EmailJS
    $('#contactForm').on('submit', function(e) {
        e.preventDefault();
        
        // Show loading spinner
        $('#submit-text').text('Sending...');
        $('#submit-spinner').removeClass('d-none');
        $('button[type="submit"]').prop('disabled', true);
        
        // Get form values
        const templateParams = {
            from_name: $('#from_name').val(),
            from_email: $('#from_email').val(),
            subject: $('#subject').val(),
            message: $('#message').val()
        };
        
        // Send email using EmailJS
        emailjs.send('service_ivxylli', 'template_x6i4pku', templateParams)
            .then(function(response) {
                console.log('SUCCESS!', response.status, response.text);
                
                // Clear form fields
                $('#from_name').val('');
                $('#from_email').val('');
                $('#subject').val('');
                $('#message').val('');
                
                // Hide spinner, restore button text
                $('#submit-text').text('Send Message');
                $('#submit-spinner').addClass('d-none');
                $('button[type="submit"]').prop('disabled', false);
                
                // Show success message
                $('#formError').addClass('d-none');
                $('#formSuccess').removeClass('d-none').fadeIn();
                
                // Hide success message after 5 seconds
                setTimeout(function() {
                    $('#formSuccess').fadeOut().addClass('d-none');
                }, 5000);
            }, function(error) {
                console.log('FAILED...', error);
                
                // Hide spinner, restore button text
                $('#submit-text').text('Send Message');
                $('#submit-spinner').addClass('d-none');
                $('button[type="submit"]').prop('disabled', false);
                
                // Show error message
                $('#formSuccess').addClass('d-none');
                $('#formError').removeClass('d-none').fadeIn();
                
                // Hide error message after 5 seconds
                setTimeout(function() {
                    $('#formError').fadeOut().addClass('d-none');
                }, 5000);
            });
    });

    // Animated elements on scroll
    $(window).scroll(function() {
        $('.service-card, .mission-content, .mission-image, .counter-box, .testimonial-item, .contact-info, .contact-form').each(function() {
            const position = $(this).offset().top;
            const scroll = $(window).scrollTop();
            const windowHeight = $(window).height();
            
            if (scroll > position - windowHeight + 200) {
                $(this).addClass('animated fadeInUp');
            }
        });
    });

    // Parallax effect for hero section
    $(window).scroll(function() {
        const scroll = $(window).scrollTop();
        $('.hero-section').css({
            'background-position': 'center ' + (scroll * 0.2) + 'px'
        });
    });

    // Add hover animations to buttons
    $('.btn').hover(
        function() {
            $(this).addClass('animated pulse');
        },
        function() {
            $(this).removeClass('animated pulse');
        }
    );

    // Mobile menu toggle animation
    $('.navbar-toggler').on('click', function() {
        $(this).toggleClass('active');
    });

    // Image hover effect
    $('.mission-image').hover(
        function() {
            $(this).addClass('animated pulse');
        },
        function() {
            $(this).removeClass('animated pulse');
        }
    );

    // Dynamic year for copyright
    const currentYear = new Date().getFullYear();
    $('.copyright-year').text(currentYear);

    // Preloader
    $(window).on('load', function() {
        $('.preloader').fadeOut(1000);
    });
});

// jQuery extension for checking if element is in viewport
$.fn.isInViewport = function() {
    const elementTop = $(this).offset().top;
    const elementBottom = elementTop + $(this).outerHeight();
    const viewportTop = $(window).scrollTop();
    const viewportBottom = viewportTop + $(window).height();
    return elementBottom > viewportTop && elementTop < viewportBottom;
};

// Trigger animations when elements come into view
$(window).on('resize scroll', function() {
    $('.animated-element').each(function() {
        if ($(this).isInViewport()) {
            $(this).addClass('animated fadeInUp');
        }
    });
});
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>