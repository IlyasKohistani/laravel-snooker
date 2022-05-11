{{-- all documentation is in this link https://sweetalert2.github.io/ 
    
         const swalWithBootstrapButtons = Swal.mixin({
       customClass: {
         confirmButton: 'btn btn-info',
         cancelButton: 'btn btn-danger'
       },
       buttonsStyling: false
     }) --}}

<style>
  .btnstyle {
    font-size: 15px !important;
  }
</style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script type="text/javascript">
  $('.delete-confirm').on('click', function (event) {
         event.preventDefault();
         const url = $(this).attr('href');
         const swalWithBootstrapButtons = Swal.mixin({
       customClass: {
         confirmButton: ' btnstyle',
         cancelButton: ' btnstyle'
       },
       buttonsStyling: true
     });
     
     swalWithBootstrapButtons.fire({
       html: '<p style="color: #fafafa !important; font-size:22px;">Are you sure?</p><span style="color: white !important; font-size:15px;">This record and it`s details will be permanantly deleted!</span>',
       padding: '4em',
       width: 450,
       cancelButtonColor: '#d33',
       backdrop: 'rgba(0, 0, 100, 0.2)',
       background: 'rgba(0,0,100, 0.93)',
       cancelButtonText: 'Cancel',
       confirmButtonText: 'Yes, Delete it.',
       icon: 'warning',
       showCancelButton: true
       
     }).then((result) => {
       if (result.value) {
        swalWithBootstrapButtons.fire({
             html: '<p style="color: #fafafa !important; font-size:25px;">Deleted!</p><span style="color: white !important; font-size:16px;">Your file has been deleted.</span>',
             icon: 'success',
             padding: '3em',
             width: 400,
             backdrop: 'rgba(0, 0, 100, 0.2)',
             background: 'rgba(0,0,90, 0.93)',
                     });
             setTimeout(function() {
             $('.delete-form').attr('action', url);
             $('.delete-form').submit();
             },500);
        
             }else if (
             /* Read more about handling dismissals below */
             result.dismiss === Swal.DismissReason.cancel
             ) {
              swalWithBootstrapButtons.fire({
             html: '<p style="color: #fafafa !important; font-size:25px;">Cancelled!</p><span style="color: white !important; font-size:16px;">Your imaginary file is safe :)</span>',
             icon: 'error',
             padding: '3em',
             width: 400,
             backdrop: 'rgba(0, 0, 100, 0.2)',
             background: 'rgba(0,0,90, 0.93)',
                     });
                         }
                         });
                         });
     
     
     
</script>