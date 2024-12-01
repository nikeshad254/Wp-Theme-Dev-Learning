<?php

require_once plugin_dir_path(__FILE__) . 'GetPets.php';
$getPets = new GetPets();
get_header(); ?>

<div class="page-banner">
  <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg'); ?>);"></div>
  <div class="page-banner__content container container--narrow">
    <h1 class="page-banner__title">Pet Adoption</h1>
    <div class="page-banner__intro">
      <p>Providing forever homes one search at a time.</p>
    </div>
  </div>
</div>

<div class="container container--narrow page-section">

  <p>This page took <strong><?php echo timer_stop(); ?></strong> seconds to prepare. Found <strong><?= $getPets->count; ?></strong> results (showing the first <?= count($getPets->pets) ?>).</p>

  <table class="pet-adoption-table">
    <tr>
      <th>Name</th>
      <th>Species</th>
      <th>Weight</th>
      <th>Birth Year</th>
      <th>Hobby</th>
      <th>Favorite Color</th>
      <th>Favorite Food</th>
    </tr>
    <?php
    foreach ($getPets->pets as $pet) {
    ?>
      <tr>
        <td><?= $pet->petname; ?></td>
        <td><?= $pet->species; ?></td>
        <td><?= $pet->petweight; ?></td>
        <td><?= $pet->birthyear; ?></td>
        <td><?= $pet->favhobby; ?></td>
        <td><?= $pet->favcolor; ?></td>
        <td><?= $pet->favfood; ?></td>
      </tr>
    <?php
    }
    ?>

  </table>

</div>

<?php get_footer(); ?>