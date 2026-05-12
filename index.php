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
        <span class="index-hero-slogan-highlight">upgrade</span>
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
        <video autoplay muted loop src="./images/promo-video.mp4" class="index-intro-vid-content"></video>
        <figcaption class="index-intro-figcaption">Video by City Melbourne youtube <a href="#footnote-3"
            class="index-intro-figcaption-sup"><sup>1</sup></a></figcaption>
      </figure>
    </section>
    <section class="index-stats">
      <div class="index-stats-vid">
        <video autoplay loop muted>
          <source src="./images/stats-bg-vid.mp4">
        </video>
      </div>
      <div class="index-stats-content">
        <h2 class="index-stats-number">Up to <span class="index-stats-number-highlight">15%<a href="#footnote-2"><sup
                style="font-size: 30%;">2</sup></a>
          </span></h2>
        <p class="index-stats-text">Early adopters have seen improvement in traffic congestion, allowing for a general
          efficiency for citizens, giving them more time to enjoy.</p>
      </div>
    </section>
    <section class="index-compare">
      <h2 class="index-compare-title">
        The Pioneer
      </h2>
      <table class="index-compare-table">
        <tr class="index-compare-table-row">
          <th class="index-compare-table-title">UrbanSync</th>
          <th class="index-compare-table-title">Other Competitors</th>
        </tr>
        <tr class="index-compare-table-row">
          <td class="index-compare-table-category" colspan="2">Performance</td>
        </tr>
        <tr class="index-compare-table-row">
          <td class="index-compare-table-row-data">Fast Project turn-around</td>
          <td class="index-compare-table-row-data">Slow, multiple-step process</td>
        </tr>
        <tr class="index-compare-table-row">
          <td class="index-compare-table-row-data">Industry-leading quality of results</td>
          <td class="index-compare-table-row-data">Standard quality</td>
        </tr>
        <tr class="index-compare-table-row">
          <td class="index-compare-table-category" colspan="2">Efficiency</td>
        </tr>
        <tr class="index-compare-table-row">
          <td class="index-compare-table-row-data">$</td>
          <td class="index-compare-table-row-data">$$$$</td>
        </tr>
        <tr class="index-compare-table-row">
          <td class="index-compare-table-row-data">Minimal Resource Overload</td>
          <td class="index-compare-table-row-data">Unplanned resource overload</td>
        </tr>
        <tr class="index-compare-table-row">
          <td class="index-compare-table-category" colspan="2">Additional Services</td>
        </tr>
        <tr class="index-compare-table-row">
          <td class="index-compare-table-row-data">Hardware & software integration</td>
          <td class="index-compare-table-row-data">Hardware & software integration</td>
        </tr>
        <tr class="index-compare-table-row">
          <td class="index-compare-table-row-data">Real-time analysis dashboard</td>
          <td class="index-compare-table-row-data">-</td>
        </tr>
        <tr class="index-compare-table-row">
          <td class="index-compare-table-row-data">Bespoke city modeling</td>
          <td class="index-compare-table-row-data">-</td>
        </tr>
      </table>
    </section>
    <section class="index-footnote">
      <h3>Footnote</h3>
      <p class="index-footnote-item" id="footnote-0"> logo was ai generated: "create a round logo with the name
        'UrbanSync'"</p>
      <p class="index-footnote-item" id="footnote-1">source:
        https://www.freepik.com/free-photo/city-buildings-night_10399859.htm#fromView=keyword&page=1&position=3&uuid=8bfdbdac-3e69-4a16-a49f-b6df951f832b&query=Night+city
      </p>
      <p class="index-footnote-item" id="footnote-2">source:
        https://www.transport.nsw.gov.au/system/files/media/documents/2025/integrated-connected-data-for-safer-final-report-august-2025.pdf
      </p>
      <p class="index-footnote-item" id="footnote-3">source: https://www.youtube.com/watch?v=0iYKMj_uhXg</p>
    </section>
  </main>
  <!--FOOTER -->
  <?php include "footer.inc" ?>
</body>

</html>