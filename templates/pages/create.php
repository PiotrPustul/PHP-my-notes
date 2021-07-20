<div>
   <h3> New Note </h3>
   <div>
      <?php dump($params); ?>
      <form class="note-form" action="/?action=create" method="post">
         <ul>
            <li>
               <label>Title <span class="required">*</span></label>
               <input type="text" name="title" class="field-long">
            </li>
            <li>
               <label>Description <span class="required">*</span></label>
               <textarea name="description" id="field5" class="field-long field-textarea"></textarea>
            </li>
            <li>
               <input type="submit" value="Submit">
            </li>
         </ul>
      </form>
   </div>
</div>