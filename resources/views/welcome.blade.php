<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>SIWATA</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/landing/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/landing/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/landing/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/landing/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/landing/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/landing/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Lumia
  * Template URL: https://bootstrapmade.com/lumia-bootstrap-business-template/
  * Updated: Mar 17 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top d-flex align-items-center">
    <div class="container d-flex align-items-center">

      <div class="logo me-auto">

        <!-- Uncomment below if you prefer to use an image logo -->
        <a href="index.html"><img src="assets/landing/img/logo.png" alt="" class="img-fluid"></a>
      </div>

      <nav id="navbar" class="navbar order-last order-lg-0">
        <ul>
          <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
          <li><a class="nav-link scrollto" href="#about">Jadwal Sidang</a></li>
          <li><a class="nav-link scrollto" href="#contact">Contact</a></li>
          <li class="nav-item">
            <a class="nav-link scrollto btn-get-started panduan-btn" href="{{ asset('data_file/panduan.pdf') }}" download>Panduan Pengguna</a>
          </li>
          <li class="nav-item login-item"><a class="nav-link scrollto" href="/login">Login</a></li>
          <li class="nav-item register-item"><a class="nav-link scrollto btn-get-started register-btn" href="/register">Register</a></li>


        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav>






    </div>
  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex flex-column justify-content-center align-items-center">
    <div class="container text-center text-md-left" data-aos="fade-up">
      <h1>Welcome to <span>SIWATA</span></h1>
      <h2>Sistem Informasi Penjadwalan Sidang Tugas Akhir</h2>
    </div>
  </section><!-- End Hero -->

  <main id="main">

    <!-- ======= What We Do Section ======= -->
    <section id="what-we-do" class="what-we-do">
      <div class="container">

        <div class="section-title">
          <h2>Apa Yang Kami Lakukan</h2>
        </div>

        <div class="row">
          <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
            <div class="icon-box">
              <div class="icon"><i class="bx bxl-dribbble"></i></div>
              <h4><a href="">Manajemen Penjadwalan</a></h4>
              <p>Memungkinkan pengguna untuk membuat, mengatur, dan memantau jadwal secara efisien.</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-md-0">
            <div class="icon-box">
              <div class="icon"><i class="bx bx-file"></i></div>
              <h4><a href="">Pelaporan Sidang TA</a></h4>
              <p>Memudahkan mahasiswa untuk mengunggah laporan sidang Tugas Akhir dan memungkinkan dosen memberikan umpan balik secara langsung.</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-lg-0">
            <div class="icon-box">
              <div class="icon"><i class="bx bx-tachometer"></i></div>
              <h4><a href="">Analisis Data</a></h4>
              <p>Menganalisis data penjadwalan sidang untuk mengoptimalkan pengelolaan waktu secara efektif</p>
            </div>
          </div>

        </div>

      </div>
    </section><!-- End What We Do Section -->

    <!-- ======= About Section ======= -->
    <section id="about" class="about">
        <div class="container">

              <div class="section-title">
                <h2>Jadwal Sidang TA</h2>
              </div>

                <div class="table-responsive">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Mahasiswa</th>
                        <th>Tanggal</th>
                        <th>Ruangan</th>
                        <th>Sesi</th>
                        <th>Ketua</th>
                        <th>Sekretaris</th>
                        <th>Penguji 1</th>
                        <th>Penguji 2</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($sidangTerjadwal as $key => $sidang)
                      <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $sidang->mahasiswa->nama }}</td>
                        <td>{{ $sidang->tanggal }}</td>
                        <td>{{ $sidang->ruang->nama_ruangan }}</td>
                        <td>{{ $sidang->sesi }}</td>
                        <td>{{ $sidang->ketuaNama->nama }}</td>
                        <td>{{ $sidang->sekretarisNama->nama }}</td>
                        <td>{{ $sidang->penguji1->nama }}</td>
                        <td>{{ $sidang->penguji2->nama }}</td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
              </div>

          </div>
        </div>
      </section><!-- End About Section -->





    <!-- ======= Counts Section ======= -->
    <section id="counts" class="counts">
        <div class="container d-flex justify-content-center align-items-center">
            <div class="row justify-content-between">

          <div class="col-lg-2 col-5">
            <div class="count-box">
              <i class="bi bi-journal-richtext"></i>
              <span data-purecounter-start="0" data-purecounter-end="{{ $sidangTerjadwal->count() }}" data-purecounter-duration="1" class="purecounter"></span>
              <p>Sidang Terjadwal</p>
            </div>
          </div>

          <div class="col-lg-2 col-5">
            <div class="count-box">
              <i class="bi bi-journal-richtext"></i>
              <span data-purecounter-start="0" data-purecounter-end="{{ $sidangSelesai->count() }}" data-purecounter-duration="1" class="purecounter"></span>
              <p>Sidang Selesai</p>
            </div>
          </div>

          <div class="col-lg-2 col-5">
            <div class="count-box">
              <i class="bi bi-headset"></i>
              <span data-purecounter-start="0" data-purecounter-end="{{ $kuotaSidang}}" data-purecounter-duration="1" class="purecounter"></span>
              <p>Kuota Sidang</p>
            </div>
          </div>

          <div class="col-lg-2 col-5 ">
            <div class="count-box">
              <i class="bi bi-people"></i>
              <span data-purecounter-start="0" data-purecounter-end="{{ $dosen }}" data-purecounter-duration="1" class="purecounter"></span>
              <p>Dosen</p>
            </div>
          </div>

          <div class="col-lg-2 col-5 ">
            <div class="count-box">
              <i class="bi bi-people"></i>
              <span data-purecounter-start="0" data-purecounter-end="{{ $mahasiswa }}" data-purecounter-duration="1" class="purecounter"></span>
              <p>Mahasiswa</p>
            </div>
          </div>

        </div>

      </div>
    </section><!-- End Counts Section -->


    <!-- ======= Team Section ======= -->
    <section id="team" class="team">
      <div class="container">

        <div class="section-title">
          <h2>Team</h2>
          <p>Team Develop SIWATA</p>
        </div>

        <div class="row">
          <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
            <div class="member">
              <img src="assets/landing/img/team/cowo.png" alt="">
              <h4>Abdillah Rahman</h4>
              <span>Back-End</span>
              <p>
                Magni qui quod omnis unde et eos fuga et exercitationem. Odio veritatis perspiciatis quaerat qui aut aut aut
              </p>
              <div class="social">
                <a href=""><i class="bi bi-twitter"></i></a>
                <a href=""><i class="bi bi-facebook"></i></a>
                <a href=""><i class="bi bi-instagram"></i></a>
                <a href=""><i class="bi bi-linkedin"></i></a>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
            <div class="member">
              <img src="assets/landing/img/team/cowo.png" alt="">
              <h4>Alfa Ramadhan</h4>
              <span>Front-End</span>
              <p>
                Repellat fugiat adipisci nemo illum nesciunt voluptas repellendus. In architecto rerum rerum temporibus
              </p>
              <div class="social">
                <a href=""><i class="bi bi-twitter"></i></a>
                <a href=""><i class="bi bi-facebook"></i></a>
                <a href=""><i class="bi bi-instagram"></i></a>
                <a href=""><i class="bi bi-linkedin"></i></a>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
            <div class="member">
              <img src="assets/landing/img/team/cewe.png" alt="">
              <h4>Aura Zulaikha</h4>
              <span>Back-End</span>
              <p>
                Voluptas necessitatibus occaecati quia. Earum totam consequuntur qui porro et laborum toro des clara
              </p>
              <div class="social">
                <a href=""><i class="bi bi-twitter"></i></a>
                <a href=""><i class="bi bi-facebook"></i></a>
                <a href=""><i class="bi bi-instagram"></i></a>
                <a href=""><i class="bi bi-linkedin"></i></a>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
            <div class="member">
              <img src="assets/landing/img/team/cowo.png" alt="">
              <h4>Rayhan Juliansyah</h4>
              <span>Front-End</span>
              <p>
                Voluptas necessitatibus occaecati quia. Earum totam consequuntur qui porro et laborum toro des clara
              </p>
              <div class="social">
                <a href=""><i class="bi bi-twitter"></i></a>
                <a href=""><i class="bi bi-facebook"></i></a>
                <a href=""><i class="bi bi-instagram"></i></a>
                <a href=""><i class="bi bi-linkedin"></i></a>
              </div>
            </div>
          </div>

        </div>

      </div>
    </section><!-- End Team Section -->

    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact section-bg">
      <div class="container">

        <div class="section-title">
          <h2>Contact</h2>
          <p>Hubungi Kami</p>
        </div>

        <div class="row mt-5 justify-content-center">

          <div class="col-lg-10">

            <div class="info-wrap">
              <div class="row">
                <div class="col-lg-4 info">
                  <i class="bi bi-geo-alt"></i>
                  <h4>Location:</h4>
                  <p>Jl. Limau Manis No. 302<br>Gadut, Padang 535022</p>
                </div>

                <div class="col-lg-4 info mt-4 mt-lg-0">
                  <i class="bi bi-envelope"></i>
                  <h4>Email:</h4>
                  <p>siwata@gmail.com<br>siwataxyz.com</p>
                </div>

                <div class="col-lg-4 info mt-4 mt-lg-0">
                  <i class="bi bi-phone"></i>
                  <h4>Call:</h4>
                  <p>+62 0821 55488 51<br>+62 5589 12321 14</p>
                </div>
              </div>
            </div>

          </div>

        </div>

        <div class="row mt-5 justify-content-center">
          <div class="col-lg-10">
            <form action="assets/landing/forms/contact.php" method="post" role="form" class="php-email-form">
              <div class="row">
                <div class="col-md-6 form-group">
                  <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required>
                </div>
                <div class="col-md-6 form-group mt-3 mt-md-0">
                  <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required>
                </div>
              </div>
              <div class="form-group mt-3">
                <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required>
              </div>
              <div class="form-group mt-3">
                <textarea class="form-control" name="message" rows="5" placeholder="Message" required></textarea>
              </div>
              <div class="my-3">
                <div class="loading">Loading</div>
                <div class="error-message"></div>
                <div class="sent-message">Your message has been sent. Thank you!</div>
              </div>
              <div class="text-center"><button type="submit">Send Message</button></div>
            </form>
          </div>

        </div>

      </div>
    </section><!-- End Contact Section -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer">

    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-3 col-md-6 footer-contact">
            <h3>SIWATA</h3>
            <p>
                Jl. Limau Manis No. 302 <br>
                Gadut, Padang 535022<br>
              Sumatera Barat <br><br>
              <strong>Phone:</strong> +62 0821 55488 51<br>
              <strong>Email:</strong> siwata@gmail.com<br>
            </p>
          </div>

          <div class="col-lg-2 col-md-6 footer-links">
            <h4>Useful Links</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Home</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">About us</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Services</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Terms of service</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Privacy policy</a></li>
            </ul>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Our Services</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Web Design</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Web Development</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Product Management</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Marketing</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Graphic Design</a></li>
            </ul>
          </div>

          <div class="col-lg-4 col-md-6 footer-newsletter">
            <h4>Join Our Newsletter</h4>
            <p>Dapatkan Informasi terbaru dari kami</p>
            <form action="" method="post">
              <input type="email" name="email"><input type="submit" value="Subscribe">
            </form>
          </div>

        </div>
      </div>
    </div>

    <div class="container d-md-flex py-4">

      <div class="me-md-auto text-center text-md-start">
        <div class="copyright">
          &copy; Copyright <strong><span>SIWATA</span></strong>. All Rights Reserved
        </div>

      </div>
      <div class="social-links text-center text-md-right pt-3 pt-md-0">
        <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
        <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
        <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
        <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
        <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
      </div>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/landing/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/landing/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/landing/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/landing/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/landing/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/landing/vendor/waypoints/noframework.waypoints.js"></script>
  <script src="assets/landing/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/landing/js/main.js"></script>

</body>

</html>
