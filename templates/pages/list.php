<div>
   <section>
      <div class="message">
         <?php
         if (!empty($params['error'])) {
            switch ($params['error']) {
               case 'missingNoteId':
                  echo "the note Id is not correct";
                  break;
               case 'noteNotFound':
                  echo "The note could not be found !!!";
                  break;
            }
         }
         ?>
      </div>
      <div class="message">
         <?php
         if (!empty($params['before'])) {
            switch ($params['before']) {
               case 'created':
                  echo "The note has been created !!!";
                  break;
               case 'deleted':
                  echo "The note has been deleted";
                  break;
               case 'edited':
                  echo "The note has been updated";
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
                     <td><?php echo $note['id'] ?></td>
                     <td><?php echo $note['title'] ?></td>
                     <td><?php echo $note['created'] ?></td>
                     <td>
                        <a href="/?action=show&id=<?php echo $note['id'] ?>">
                           <button>Details</button>
                        </a>
                        <a href="/?action=delete&id=<?php echo $note['id'] ?>">
                           <button>Delete</button>
                        </a>
                     </td>
                  </tr>
               <?php endforeach; ?>
            </tbody>
         </table>
      </div>
   </section>
</div>