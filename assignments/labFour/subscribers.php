<?php

require "includes/connect.php";


$sql = "SELECT * FROM subscribers ORDER BY subscribed_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$subscribers = $stmt->fetchAll();
?>

<main class="container mt-4">
  <h1>Subscribers</h1>

  <?php if (count($subscribers) === 0): ?>
    <p>No subscribers yet.</p>
  <?php else: ?>
    <table class="table table-bordered mt-3">
      <thead>
        <tr>
          <th>ID</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Email</th>
          <th>Subscribed</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($subscribers as $subscriber): ?>
          <tr>
            <td><?php echo $subscriber['id']; ?></td>
            <td><?php echo htmlspecialchars($subscriber['first_name']); ?></td>
            <td><?php echo htmlspecialchars($subscriber['last_name']); ?></td>
            <td><?php echo htmlspecialchars($subscriber['email']); ?></td>
            <td><?php echo $subscriber['subscribed_at']; ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>

  <p class="mt-3">
    <a href="index.php">Back to Subscribe Form</a>
  </p>
</main>

