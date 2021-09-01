<input type="hidden" id="sStatus" value="{{ $message }}">
<script type="text/javascript">
  document.addEventListener('DOMContentLoaded', function () {
      // Your jquery code
      swal.fire({
        text: document.getElementById('sStatus').value,
        confirmButtonColor:'#62A4C0',
        confirmButtonText:'Aceptar',
        icon:'error',
      });
  });
</script>