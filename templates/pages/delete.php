<div class="show">
   <?php $note = $params['note'] ?? null; ?>
   <?php if ($note) : ?>
      <ul>
         <li>ID: <?php echo $note['id'] ?></li>
         <li>Title: <?php echo $note['title'] ?></li>
         <li><?php echo $note['description'] ?></li>
         <li>Created: <?php echo $note['created'] ?></li>
      </ul>
      <form method="POST" action="/?action=delete">
         <input type="hidden" name="id" value="<?php echo $note['id'] ?>">
         <input type="submit" value="Delete">
      </form>
   <?php else : ?>
      <div>
         There is no note to show!
      </div>
   <?php endif; ?>
   <a href="/">
      <button>Go back to the Notes List</button>
   </a>
</div>