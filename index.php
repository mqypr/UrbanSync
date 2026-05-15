<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./styles/style.css">
  <title>Home - UrbanSync</title>
  <link rel="icon" type="image/x-icon" href="/images/logo.ico">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="UrbanSync, A B2B company specializing in infrastructure analytics and improvement.">
  <meta name="author" content="Reach Peng, Liron Willathgamuwa, Dylan Kelly, MD Areen ">

  <!-- Open Graph (for social sharing previews) -->
  <meta property="og:title" content="UrbanSync">
  <meta property="og:description" content="making streets faster and safer">
  <meta property="og:image" content="assets/images/hero-preview.jpg">
  <meta property="og:url" content="https://mqypr.github.io/UrbanSync/">
  <meta property="og:type" content="website">
  <style>
    .navbar {
      background: none;
    }

    .navbar-link-item-a {
      color: white;
    }

    .navbar-link-item-a:hover {
      background-color: rgba(220, 239, 241, 0.2);
    }
  </style>
</head>

<body>
  <!--HEADER-->
  <?php include "./header.inc" ?>
  <main>
    <!--HERO SECTION
    CONTAINS: background picture, company name, and description-->
    <section class="index-hero">
      <h1 class="index-hero-h1">UrbanSync</h1>
      <h2 class="index-hero-slogan">It's about time your streets get an
        <span style="text-decoration: underline;">upgrade</span>
      </h2>
    </section>
    <section class="index-intro">
      <div class="index-intro-description">
        <h2 class="index-intro-title">Infrastructure for the Future.</h2>
        <p>UrbanSync is the smart city Infrastructure based in Melbourne, here to bring a complete upgrade to your
          city's streets and buildings. We make infrastructure safer <span
            class="index-intro-description-highlight">and</span> faster</p>
        <!--highlight "and"-->
      </div>
      <figure class="index-intro-vid">
        <video autoplay muted loop playsinline src="./images/promo-video.mp4" class="index-intro-vid-content"></video>
        <figcaption class="index-intro-figcaption">Video by City Melbourne youtube <a href="#footnote-3"
            class="index-intro-figcaption-sup"><sup>1</sup></a></figcaption>
      </figure>
    </section>
    <section class="index-stats">
      <div class="index-stats-vid">
        <video autoplay loop muted playsinline>
          <source src="./images/stats-bg-vid.mp4">
        </video>
      </div>
      <div class="index-stats-content">
        <h2 class="index-stats-number">Up to <span class="index-stats-number-highlight">15%<a href="#footnote-2"><sup
                style="font-size: 30%">2</sup></a>
          </span></h2>
        <p class="index-stats-text">Early adopters have seen improvement in traffic congestion, allowing for a general
          efficiency for citizens, giving them more time to enjoy.</p>
      </div>
    </section>
    <section class="index-compare">
      <h2 class="index-compare-title">The Pioneer</h2>
      <div class="index-compare-wrapper">
        <table class="index-compare-table">
          <thead>
            <tr>
              <th class="index-compare-col-label"></th>
              <th class="index-compare-col-us">UrbanSync</th>
              <th class="index-compare-col-them">Competitors</th>
            </tr>
          </thead>
          <tbody>
            <tr class="index-compare-category-row">
              <td colspan="3" class="index-compare-table-category">Performance</td>
            </tr>
            <tr>
              <td class="index-compare-feature">Fast project turn-around</td>
              <td class="index-compare-check us">✓</td>
              <td class="index-compare-check them">✗</td>
            </tr>
            <tr>
              <td class="index-compare-feature">Industry-leading quality</td>
              <td class="index-compare-check us">✓</td>
              <td class="index-compare-check them">✗</td>
            </tr>
            <tr class="index-compare-category-row">
              <td colspan="3" class="index-compare-table-category">Efficiency</td>
            </tr>
            <tr>
              <td class="index-compare-feature">Affordable pricing ($)</td>
              <td class="index-compare-check us">✓</td>
              <td class="index-compare-check them">✗</td>
            </tr>
            <tr>
              <td class="index-compare-feature">Minimal resource overload</td>
              <td class="index-compare-check us">✓</td>
              <td class="index-compare-check them">✗</td>
            </tr>
            <tr class="index-compare-category-row">
              <td colspan="3" class="index-compare-table-category">Additional Services</td>
            </tr>
            <tr>
              <td class="index-compare-feature">Hardware & software integration</td>
              <td class="index-compare-check us">✓</td>
              <td class="index-compare-check them">✓</td>
            </tr>
            <tr>
              <td class="index-compare-feature">Real-time analysis dashboard</td>
              <td class="index-compare-check us">✓</td>
              <td class="index-compare-check them">–</td>
            </tr>
            <tr>
              <td class="index-compare-feature">Bespoke city modeling</td>
              <td class="index-compare-check us">✓</td>
              <td class="index-compare-check them">–</td>
            </tr>
          </tbody>
        </table>
      </div>
    </section>
    <section class="index-footnote">
      <ol>
        <li class="index-footnote-item" id="footnote-0">Logo was AI generated: "create a round logo with the name 'UrbanSync'"</li>
        <li class="index-footnote-item" id="footnote-1">Source: <a href="https://www.freepik.com/free-photo/city-buildings-night_10399859.htm#fromView=keyword&page=1&position=3&uuid=8bfdbdac-3e69-4a16-a49f-b6df951f832b&query=Night+city">freepik.com</a></li>
        <li class="index-footnote-item" id="footnote-2">Source: <a href="https://www.transport.nsw.gov.au/system/files/media/documents/2025/integrated-connected-data-for-safer-final-report-august-2025.pdf">transport.nsw.gov.au</a></li>
        <li class="index-footnote-item" id="footnote-3">Source: <a href="https://www.youtube.com/watch?v=0iYKMj_uhXg">youtube.com</a></li>
      </ol>
    </section>
  </main>
  <!--FOOTER -->
  <?php include "footer.inc" ?>
</body>

</html>