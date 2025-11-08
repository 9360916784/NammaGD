<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Namma GD - AI-Powered Group Discussion Web App</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><i class="bi bi-chat"></i> Namma GD</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
                data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" 
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
                    <li class="nav-item"><a class="nav-link" href="#howitworks">How It Works</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                    <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="signup.php">Signup</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="bg-light text-dark py-5">
        <div class="container text-center">
            <h1 class="display-4 fw-bold">Practice Group Discussions with AI Feedback</h1>
            <p class="lead">Boost your communication skills with real-time GD simulations, AI-powered feedback, and personalized learning modules.</p>
            <a href="login.php" class="btn btn-primary btn-lg mt-3">Get Started</a>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5">
        <div class="container">
            <h2 class="text-center mb-4">Key Features</h2>
            <div class="row text-center">
                <div class="col-md-4">
                    <i class="bi bi-journal-richtext display-4 text-primary"></i>
                    <h4 class="mt-3">Learning Module</h4>
                    <p>Access videos, articles, and quizzes to master the art of group discussion.</p>
                </div>
                <div class="col-md-4">
                    <i class="bi bi-camera-video display-4 text-success"></i>
                    <h4 class="mt-3">Practice GD</h4>
                    <p>Join real-time GD sessions with peers and random topics using WebRTC.</p>
                </div>
                <div class="col-md-4">
                    <i class="bi bi-robot display-4 text-warning"></i>
                    <h4 class="mt-3">AI Feedback</h4>
                    <p>Get personalized feedback on grammar, sentiment, and delivery instantly.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section id="howitworks" class="bg-light py-5">
        <div class="container">
            <h2 class="text-center mb-4">How It Works</h2>
            <div class="row text-center">
                <div class="col-md-4">
                    <span class="badge bg-primary rounded-pill p-3">1</span>
                    <h5 class="mt-3">Learn</h5>
                    <p>Go through our learning content and prepare yourself for GD sessions.</p>
                </div>
                <div class="col-md-4">
                    <span class="badge bg-success rounded-pill p-3">2</span>
                    <h5 class="mt-3">Practice</h5>
                    <p>Join or host a GD room with up to 6 participants and a random topic.</p>
                </div>
                <div class="col-md-4">
                    <span class="badge bg-warning rounded-pill p-3">3</span>
                    <h5 class="mt-3">Improve</h5>
                    <p>Get AI-generated feedback to identify your strengths and areas for improvement.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="contact-section" id="contact">
        <div class="container">

            <div class="row gy-4">

                <h1>contact us</h1>
                <div class="col-lg-6">

                    <div class="row gy-4">
                        <div class="col-md-6">
                            <div class="info-box">
                                <i class="bi bi-geo-alt"></i>
                                <h3>Address</h3>
                                <p>New ByPass,<br>Karur, 639002</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <i class="bi bi-telephone"></i>
                                <h3>Call Us</h3>
                                <p>+91 9943626462<br>+91 8072784994</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <i class="bi bi-envelope"></i>
                                <h3>Email Us</h3>
                                <p>nammagd@gmail.com<br>nammagd1@gmail.com</p>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-lg-6 form">
                    <form action="contact.php" method="POST" class="php-email-form">
                        <div class="row gy-4">

                            <div class="col-md-6">
                                <input type="text" name="name" class="form-control" placeholder="Your Name" required>
                            </div>

                            <div class="col-md-6 ">
                                <input type="email" class="form-control" name="email" placeholder="Your Email" required>
                            </div>

                            <div class="col-md-12">
                                <input type="text" class="form-control" name="subject" placeholder="Subject" required>
                            </div>

                            <div class="col-md-12">
                                <textarea class="form-control" name="message" rows="5" placeholder="Message"
                                    required></textarea>
                            </div>

                            <div class="col-md-12 text-center">
                                <button type="submit" name="submit">Send Message</button>
                            </div>

                        </div>
                    </form>

                </div>

            </div>

        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-light py-3 text-center">
        <p class="mb-0">&copy; <?php echo date('Y'); ?> Namma GD | AI-Powered Group Discussion Platform</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
