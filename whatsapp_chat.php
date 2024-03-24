<?php
  
  include_once 'includes/header.inc.php';
  
  $data = new Chat();

?>



<?php
  
  include_once 'includes/footer.inc.php';

?>
<script>
  function toggleContacts()
  {
    $('.contacts').toggleClass('active');
  }
</script>
