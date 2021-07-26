<div class="show">
   <?php $note = $params['note'] ?? null; ?>
   <?php if ($note) : ?>
      <ul>
         <li>ID: <?php echo $note['id'] ?></li>
         <li>Title: <?php echo $note['title'] ?></li>
         <li><?php echo $note['description'] ?></li>
         <li>Created: <?php echo $note['created'] ?></li>
      </ul>
      <a href="/?action=edit&id=<?php echo $note['id'] ?>">
         <button>Edit</button>
      </a>
   <?php else : ?>
      <div>
         There is no note to show!
      </div>
   <?php endif; ?>
   <a href="/">
      <button>Go back to the Notes List</button>
   </a>
</div>