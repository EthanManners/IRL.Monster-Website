<?php
$tokenFromQuery = isset($_GET['t']) ? $_GET['t'] : '';
$retryHref = '/clients/will/' . ($tokenFromQuery !== '' ? '?t=' . urlencode($tokenFromQuery) : '');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
  <link rel="shortcut icon" href="/assets/images/IRLMOnster.png" type="image/x-icon">
  <title>Stream Key Received | IRL Monster</title>
  <link rel="stylesheet" href="/assets/web/assets/mobirise-icons2/mobirise2.css">
  <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap-grid.min.css">
  <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap-reboot.min.css">
  <link rel="stylesheet" href="/assets/theme/css/style.css">
  <link rel="preload" href="https://fonts.googleapis.com/css2?family=Liter&display=swap&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Liter&display=swap&display=swap"></noscript>
  <link rel="preload" as="style" href="/assets/mobirise/css/mbr-additional.css?v=XDXjuH"><link rel="stylesheet" href="/assets/mobirise/css/mbr-additional.css?v=XDXjuH" type="text/css">
</head>
<body>
<section class="header16" style="position: relative; overflow: hidden; min-height: 100vh; background: #000; display: flex; align-items: center; justify-content: center; padding: 2rem;">
  <div style="text-align: center; color: white; width: 100%; max-width: 500px;">
    <h1 style="font-size: 2.5rem; margin-bottom: 1rem;"><strong>Got it. Your stream key was received. You can close this page.</strong></h1>
    <a href="<?php echo htmlspecialchars($retryHref, ENT_QUOTES, 'UTF-8'); ?>" style="color: #b8d4ff; text-decoration: underline;">Submit a different key</a>
  </div>
</section>
</body>
</html>
