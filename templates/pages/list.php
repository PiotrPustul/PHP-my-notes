<div>
   <section>
      <div class="message">
         <?php
         if (!empty($params['before'])) {
            switch ($params['before']) {
               case 'created':
                  echo "The note has been created !!!";
                  break;
            }
         }
         ?>
      </div>
      <div class="tbl-header">
         <table cellpadding="0" cellspacing="0" border="0">
            <thead>
               <tr>
                  <th>ID</th>
                  <th>Title</th>
                  <th>Date</th>
                  <th>Options</th>
               </tr>
            </thead>
         </table>
      </div>
      <div class="tbl-content">
         <table cellpadding="0" cellspacing="0" border="0">
            <tbody>
               <?php foreach ($params['notes'] ?? [] as $note) : ?>
                  <tr>
                     <td><?php echo (int) $note['id'] ?></td>
                     <td><?php echo htmlentities($note['title']) ?></td>
                     <td><?php echo htmlentities($note['created']) ?></td>
                     <td>
                        <a href="/?action=show&id=<?php echo (int) $note['id'] ?>">Show</a>
                     </td>
                  </tr>
               <?php endforeach; ?>
            </tbody>
         </table>
      </div>
   </section>
</div>