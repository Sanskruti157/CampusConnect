<?php
require_once 'db.php';
$events = $conn->query("SELECT * FROM events ORDER BY event_date ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CampusConnect | College Events</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<header class="site-header">
  <a class="brand" href="index.php">Campus<span>Connect</span></a>
  <nav><a href="index.php">Home</a><a href="events.php">Events</a><a href="admin.php">Admin</a></nav>
</header>
<main>
  <section class="hero">
    <div>
      <p class="eyebrow">YOUR CAMPUS, YOUR COMMUNITY</p>
      <h1>Make memories.<br><span>Find your next event.</span></h1>
      <p>Discover workshops, cultural fests, competitions, and more happening on campus.</p>
      <a class="button" href="events.php">Explore events</a>
    </div>
    <div class="hero-art" aria-hidden="true"><div class="big-emoji">🎉</div><div class="floating f1">🎨</div><div class="floating f2">🎤</div><div class="floating f3">💡</div></div>
  </section>
  <section class="section-heading"><div><p class="eyebrow">DON'T MISS OUT</p><h2>Upcoming events</h2></div><a href="events.php">View all →</a></section>
  <section class="event-grid">
    <?php if ($events && $events->num_rows > 0): ?>
      <?php while ($event = $events->fetch_assoc()): ?>
        <article class="event-card">
          <div class="event-banner <?= htmlspecialchars($event['category']) ?>"><span><?= htmlspecialchars(ucfirst($event['category'])) ?></span><strong>✨</strong></div>
          <div class="event-content">
            <p class="event-date"><?= htmlspecialchars(date('d M Y', strtotime($event['event_date']))) ?></p>
            <h3><?= htmlspecialchars($event['event_name']) ?></h3>
            <p><?= htmlspecialchars($event['description']) ?></p>
            <p class="event-meta">📍 <?= htmlspecialchars($event['venue']) ?></p>
            <a class="text-link" href="register.php?event_id=<?= (int)$event['event_id'] ?>">Register →</a>
          </div>
        </article>
      <?php endwhile; ?>
    <?php else: ?>
      <p>No events yet. Admin can add events from the admin page.</p>
    <?php endif; ?>
  </section>
</main>
<footer>Made for campus life 💜 · CampusConnect</footer>
</body>
</html>
