<?php
require_once 'db.php';
$event_id = isset($_GET['event_id']) ? (int)$_GET['event_id'] : (int)($_POST['event_id'] ?? 0);
$stmt = $conn->prepare("SELECT event_name, event_date, venue FROM events WHERE event_id = ?");
$stmt->bind_param("i", $event_id);
$stmt->execute();
$event = $stmt->get_result()->fetch_assoc();
$message = "";
if ($_SERVER["REQUEST_METHOD"] === "POST" && $event) {
    $student_name = trim($_POST['student_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $department = trim($_POST['department'] ?? '');
    if ($student_name !== "" && filter_var($email, FILTER_VALIDATE_EMAIL) && $department !== "") {
        $insert = $conn->prepare("INSERT INTO registrations (student_name, email, department, event_id) VALUES (?, ?, ?, ?)");
        $insert->bind_param("sssi", $student_name, $email, $department, $event_id);
        if ($insert->execute()) {
            $message = "Registration successful! See you at the event.";
        } else {
            $message = "Sorry, registration could not be saved.";
        }
    } else {
        $message = "Please enter a valid name, email, and department.";
    }
}
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Register | CampusConnect</title><link rel="stylesheet" href="style.css"></head>
<body><header class="site-header"><a class="brand" href="index.php">Campus<span>Connect</span></a><nav><a href="index.php">Home</a><a href="events.php">Events</a><a href="admin.php">Admin</a></nav></header>
<main class="form-wrap">
  <p class="eyebrow">SAVE YOUR SPOT</p><h1>Event registration</h1>
  <?php if ($event): ?>
    <div class="selected-event"><strong><?= htmlspecialchars($event['event_name']) ?></strong><span><?= htmlspecialchars(date('d M Y', strtotime($event['event_date']))) ?> · <?= htmlspecialchars($event['venue']) ?></span></div>
    <?php if ($message): ?><p class="notice"><?= htmlspecialchars($message) ?></p><?php endif; ?>
    <form method="POST" action="register.php" class="form-card" id="registrationForm">
      <input type="hidden" name="event_id" value="<?= (int)$event_id ?>">
      <label>Full name<input type="text" name="student_name" required maxlength="100" placeholder="Your name"></label>
      <label>College email<input type="email" name="email" required maxlength="150" placeholder="you@college.edu"></label>
      <label>Department<input type="text" name="department" required maxlength="100" placeholder="e.g. Computer Engineering"></label>
      <button class="button" type="submit">Confirm registration</button>
    </form>
  <?php else: ?><p class="notice">Event not found. Please choose an event from the events page.</p><a class="button" href="events.php">Browse events</a><?php endif; ?>
</main><footer>CampusConnect · Your next campus memory starts here</footer><script src="script.js"></script></body></html>
