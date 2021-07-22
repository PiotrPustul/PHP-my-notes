<div>
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
   <h4>Notes List</h4>
   <b><?php echo $params['resultList'] ?? "" ?></b>
</div>