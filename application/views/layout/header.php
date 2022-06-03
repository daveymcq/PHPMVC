<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Website</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php stylesheet_link_tag('https://fonts.googleapis.com/css?family=Open+Sans&display=swap'); ?>
    <?php stylesheet_link_tag('global/style'); ?>
  </head>

  <body>
    <header>
      <div class="logo">
        <div class="desktop">
          <a href="#">website</a>
        </div>

        <div class="mobile">
          <div class="mobile-nav-dropdown">
            <div></div>
            <div></div>
            <div></div>
          </div>

          <nav class="dropdown-menu">
            <ul>
              <li><a href="#">Link A</a></li>
              <li><a href="#">Link B</a></li>
              <li><a href="#">Link C</a></li>
            </ul>
          </nav>
        </div>
      </div>

      <nav class="main-nav">
        <ul>
          <li><a href="#">Link A</a></li>
          <li><a href="#">Link B</a></li>
          <li><a href="#">Link C</a></li>
        </ul>
      </nav>
    </header>


    <section id="content-wrapper">
      <aside class="sidebar">

      </aside>
      <div class="main-content">
