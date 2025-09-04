<?php
require __DIR__.'/bootstrap.php';
echo "Connected OK<br>";
foreach ($pdo->query("SELECT id, title, event_date FROM events") as $r) {
  echo "{$r['id']} | {$r['title']} | {$r['event_date']}<br>";
}