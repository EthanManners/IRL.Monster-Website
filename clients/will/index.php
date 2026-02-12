<?php
$tokenFromQuery = isset($_GET['t']) ? $_GET['t'] : '';
$expectedToken = getenv('WILL_TOKEN');
$isAuthorized = is_string($expectedToken) && $expectedToken !== '' && hash_equals($expectedToken, $tokenFromQuery);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
  <link rel="shortcut icon" href="/assets/images/IRLMOnster.png" type="image/x-icon">
  <title>Will Stream Key | IRL Monster</title>
  <link rel="stylesheet" href="/assets/web/assets/mobirise-icons2/mobirise2.css">
  <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap-grid.min.css">
  <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap-reboot.min.css">
  <link rel="stylesheet" href="/assets/parallax/jarallax.css">
  <link rel="stylesheet" href="/assets/dropdown/css/style.css">
  <link rel="stylesheet" href="/assets/socicon/css/styles.css">
  <link rel="stylesheet" href="/assets/theme/css/style.css">
  <link rel="preload" href="https://fonts.googleapis.com/css2?family=Liter&display=swap&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Liter&display=swap&display=swap"></noscript>
  <link rel="preload" as="style" href="/assets/mobirise/css/mbr-additional.css?v=XDXjuH"><link rel="stylesheet" href="/assets/mobirise/css/mbr-additional.css?v=XDXjuH" type="text/css">
</head>
<body>
<section id="hero-17-uUzeyLgoMQ" class="header16" style="position: relative; overflow: hidden; min-height: 100vh; background: #000;">
  <div class="starfield-container" style="position:fixed; top:0; left:0; width:100%; height:100%; z-index:0;">
    <div class="starfield-origin" style="position:absolute; top:80%; left:50%; width:1px; height:1px;"></div>
  </div>

  <div style="position: relative; z-index: 1; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 2rem;">
    <div style="text-align: center; color: white; width: 100%; max-width: 360px;">
      <?php if (!$isAuthorized): ?>
        <h1 style="font-size: 2.5rem; margin-bottom: 1rem;"><strong>Invalid link</strong></h1>
        <p style="color: #ddd; margin: 0;">Please request a fresh link.</p>
      <?php else: ?>
        <h1 style="font-size: 2.5rem; margin-bottom: 1rem;"><strong>Welcome back, Will</strong></h1>

        <img id="avatarPreview" src="/assets/images/channels4-profile-816x816.jpg" alt="Will profile picture" style="width: 110px; height: 110px; border-radius: 999px; object-fit: cover; border: 2px solid rgba(255,255,255,0.6); margin-bottom: 0.75rem;">

        <div style="display: flex; flex-direction: column; align-items: center; gap: 1rem; width: 100%; margin: 0 auto;">
          <input
            id="avatarUrl"
            type="url"
            placeholder="Profile image URL (optional)"
            style="padding: 0.75rem; width: 100%; border-radius: 25px; border: none; text-align: center;"
          >
          <input
            id="streamKey"
            type="password"
            placeholder="Stream Key"
            minlength="10"
            maxlength="512"
            required
            style="padding: 0.75rem; width: 100%; border-radius: 25px; border: none; text-align: center;"
          >
          <button
            id="submitBtn"
            style="padding: 0.75rem 2rem; border: 2px solid white; background: transparent; color: white; border-radius: 50px; font-weight: bold; cursor: pointer;"
          >
            Submit
          </button>
          <p id="statusMessage" style="min-height: 1.5em; margin: 0; color: #ddd;"></p>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>

<script src="/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/assets/parallax/jarallax.js"></script>
<script src="/assets/smoothscroll/smooth-scroll.js"></script>
<script src="/assets/ytplayer/index.js"></script>
<script src="/assets/dropdown/js/navbar-dropdown.js"></script>
<script src="/assets/theme/js/script.js"></script>
<script src="/assets/formoid/formoid.min.js"></script>
<script src="/starfield.js"></script>
<?php if ($isAuthorized): ?>
<script>
(function () {
  const avatarUrl = document.getElementById('avatarUrl');
  const avatarPreview = document.getElementById('avatarPreview');
  const streamKey = document.getElementById('streamKey');
  const submitBtn = document.getElementById('submitBtn');
  const statusMessage = document.getElementById('statusMessage');
  const token = new URLSearchParams(window.location.search).get('t') || '';

  avatarUrl.addEventListener('input', function () {
    const value = avatarUrl.value.trim();
    avatarPreview.src = value || '/assets/images/channels4-profile-816x816.jpg';
  });

  submitBtn.addEventListener('click', async function () {
    const value = streamKey.value;

    if (value.length < 10 || value.length > 512) {
      statusMessage.textContent = 'Please enter a valid stream key.';
      return;
    }

    statusMessage.textContent = 'Submitting...';
    submitBtn.disabled = true;

    try {
      const response = await fetch('/api/will/streamkey.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          streamKey: value,
          t: token
        })
      });

      if (response.ok) {
        window.location.href = '/clients/will/confirmed/?t=' + encodeURIComponent(token);
        return;
      }

      if (response.status === 429) {
        statusMessage.textContent = 'Please wait a few seconds and try again.';
      } else if (response.status === 400 || response.status === 403) {
        statusMessage.textContent = 'Unable to submit. Please check your link and key.';
      } else {
        statusMessage.textContent = 'Something went wrong. Please try again later.';
      }
    } catch (error) {
      statusMessage.textContent = 'Something went wrong. Please try again later.';
    } finally {
      submitBtn.disabled = false;
    }
  });
})();
</script>
<?php endif; ?>
</body>
</html>
