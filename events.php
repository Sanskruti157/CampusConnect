<?php
require_once 'db.php';
$events = $conn->query("SELECT * FROM events ORDER BY event_date ASC");
?>
<!DOCTYPE html>
<html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Events | CampusConnect</title><link rel="stylesheet" href="style.css"></head>
<body>
<header class="site-header"><a class="brand" href="index.php">Campus<span>Connect</span></a><nav><a href="index.php">Home</a><a href="events.php">Events</a><a href="admin.php">Admin</a></nav></header>
<main class="page-wrap">
  <p class="eyebrow">FIND YOUR PEOPLE</p><h1>All campus events</h1>
  <div class="toolbar"><input id="searchInput" type="search" placeholder="Search events..." aria-label="Search events"><select id="categoryFilter" aria-label="Filter category"><option value="">All categories</option><option value="technical">Technical</option><option value="cultural">Cultural</option><option value="sports">Sports</option><option value="workshop">Workshop</option></select></div>
  <section class="event-grid" id="eventGrid">
    <?php if ($events && $events->num_rows > 0): while ($event = $events->fetch_assoc()): ?>
      <article class="event-card" data-name="<?= htmlspecialchars(strtolower($event['event_name'])) ?>" data-category="<?= htmlspecialchars($event['category']) ?>">
        <div class="event-banner <?= htmlspecialchars($event['category']) ?>"><span><?= htmlspecialchars(ucfirst($event['category'])) ?></span><strong>🎓</strong></div>
        <div class="event-content"><p class="event-date"><?= htmlspecialchars(date('d M Y', strtotime($event['event_date']))) ?></p><h3><?= htmlspecialchars($event['event_name']) ?></h3><p><?= htmlspecialchars($event['description']) ?></p><p class="event-meta">📍 <?= htmlspecialchars($event['venue']) ?></p><a class="text-link" href="register.php?event_id=<?= (int)$event['event_id'] ?>">Register →</a></div>
      </article>
    <?php endwhile; else: ?><p>No events available yet.</p><?php endif; ?>
  </section>
  <p id="noResults" class="notice" hidden>No matching events found.</p>
</main><footer>CampusConnect · Discover something new</footer><script src="script.js"></script></body></html>
