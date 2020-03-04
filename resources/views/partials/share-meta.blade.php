<div class="col-12 mb-5 p-0 d-print-none list-buttons">
  <p>{{ _e('share', 'axflow') }}</p>
  <!-- Sharingbutton Facebook -->
  <a class="sharing-buttons" href="https://facebook.com/sharer/sharer.php?u={{ get_the_permalink() }}" target="_blank" aria-label="Facebook">
    <div class="sharing-button sharing-button--facebook sharing-button--medium">
      <i class="fa fa-facebook"></i> 
    </div>
  </a>

  <!-- Sharingbutton Twitter -->
  <a class="sharing-buttons" href="https://twitter.com/intent/tweet/?text={{ get_the_title() }}.&amp;url={{ get_the_permalink() }}" target="_blank" aria-label="Twitter">
    <div class="sharing-button sharing-button--twitter sharing-button--medium">
      <i class="fa fa-twitter"></i> 
    </div>
  </a>

  <!-- Sharingbutton E-Mail -->
  <a class="sharing-buttons" href="mailto:?subject={{ get_the_title() }}.&amp;body={{ get_the_permalink() }}" target="_self" aria-label="E-Mail">
    <div class="sharing-button sharing-button--mail sharing-button--medium">
      <i class="fa fa-envelope"></i> 
    </div>
  </a>

  <!-- Sharingbutton LinkedIn -->
  <a class="sharing-buttons" href="https://www.linkedin.com/shareArticle?mini=true&amp;url={{ get_the_permalink() }}&amp;title={{ get_the_title() }}.&amp;summary={{ get_the_title() }}.&amp;source={{ get_the_permalink() }}" target="_blank" aria-label="LinkedIn">
    <div class="sharing-button sharing-button--linkedin sharing-button--medium">
      <i class="fa fa-linkedin"></i> 
    </div>
  </a>

  <!-- Sharingbutton WhatsApp -->
  <a class="sharing-buttons" href="whatsapp://send?text={{ get_the_title() }}.%20{{ get_the_permalink() }}" target="_blank" aria-label="WhatsApp">
    <div class="sharing-button sharing-button--whatsapp sharing-button--medium">
      <i class="fa fa-whatsapp"></i> 
    </div>
  </a>
</div>
