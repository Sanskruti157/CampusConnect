<?php
require_once 'db.php';
$message = "";
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add_event'])) {
    $event_name = trim($_POST['event_name'] ?? '');
    $category = $_POST['category'] ?? 'technical';
    $event_date = $_POST['event_date'] ?? '';
    $venue = trim($_POST['venue'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $allowed = ['technical', 'cultural', 'sports', 'workshop'];
    if ($event_name && $event_date && $venue && $description && in_array($category, $allowed, true)) {
        $stmt = $conn->prepare("INSERT INTO events (event_name, category, event_date, venue, description) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $event_name, $category, $event_date, $venue, $description);
        $message = $stmt->execute() ? "Event added successfully." : "Could not add event.";
    } else {
        $message = "Please complete all fields.";
    }
}
if (isset($_GET['delete'])) {
    $delete_id = (int)$_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM events WHERE event_id = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    header("Location: admin.php");
    exit;
}
$events = $conn->query("SELECT * FROM events ORDER BY event_date ASC");
$registrations = $conn->query("SELECT r.registration_id, r.student_name, r.email, r.department, e.event_name, r.registered_at FROM registrations r JOIN events e ON r.event_id=e.event_id ORDER BY r.registered_at DESC");
$event_count = $conn->query("SELECT COUNT(*) AS total FROM events")->fetch_assoc()['total'];
$registration_count = $conn->query("SELECT COUNT(*) AS total FROM registrations")->fetch_assoc()['total'];
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Admin | CampusConnect</title><link rel="stylesheet" href="style.css"></head>
<body><header class="site-header"><a class="brand" href="index.php">Campus<span>Connect</span></a><nav><a href="index.php">Home</a><a href="events.php">Events</a><a href="admin.php">Admin</a></nav></header>
<main class="page-wrap"><p class="eyebrow">ADMIN AREA</p><h1>Event dashboard</h1>
<div class="stats"><div class="stat-card"><span>Total events</span><strong><?= (int)$event_count ?></strong></div><div class="stat-card"><span>Total registrations</span><strong><?= (int)$registration_count ?></strong></div></div>
<?php if ($message): ?><p class="notice"><?= htmlspecialchars($message) ?></p><?php endif; ?>
<section class="admin-layout"><div><h2>Add an event</h2><form method="POST" class="form-card"><input type="hidden" name="add_event" value="1">
<label>Event name<input name="event_name" required maxlength="150"></label>
<label>Category<select name="category"><option value="technical">Technical</option><option value="cultural">Cultural</option><option value="sports">Sports</option><option value="workshop">Workshop</option></select></label>
<label>Date<input type="date" name="event_date" required></label><label>Venue<input name="venue" required maxlength="150"></label><label>Description<textarea name="description" required rows="3" maxlength="500"></textarea></label><button class="button" type="submit">Add event</button></form></div>
<div><h2>Events</h2><div class="table-wrap"><table><thead><tr><th>Event</th><th>Date</th><th>Action</th></tr></thead><tbody><?php if ($events): while ($event = $events->fetch_assoc()): ?><tr><td><?= htmlspecialchars($event['event_name']) ?></td><td><?= htmlspecialchars($event['event_date']) ?></td><td><a class="delete-link" href="admin.php?delete=<?= (int)$event['event_id'] ?>" onclick="return confirm('Delete this event and its registrations?')">Delete</a></td></tr><?php endwhile; endif; ?></tbody></table></div></div></section>
<section class="registrations"><h2>Student registrations</h2><div class="table-wrap"><table><thead><tr><th>Student</th><th>Email</th><th>Department</th><th>Event</th></tr></thead><tbody><?php if ($registrations): while ($row = $registrations->fetch_assoc()): ?><tr><td><?= htmlspecialchars($row['student_name']) ?></td><td><?= htmlspecialchars($row['email']) ?></td><td><?= htmlspecialchars($row['department']) ?></td><td><?= htmlspecialchars($row['event_name']) ?></td></tr><?php endwhile; endif; ?></tbody></table></div></section>
</main><footer>CampusConnect · Admin dashboard</footer></body></html>
