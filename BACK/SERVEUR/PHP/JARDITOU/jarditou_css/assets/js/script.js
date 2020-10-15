/*------------BOUTONS SUPPRIMER------------------*/
/*
const element = document.querySelector('#Btn_supp_multi');
element.addEventListener('submit', event => {
  event.preventDefault();
  Swal.fire({
    title: '&Ecirc;tes-vous s&ucirc;r(e) ?',
    text: "Il sera impossible de récupérer les données supprimées!",
    icon: 'warning',
    showConfirmButton: true,
    showCancelButton: true,
    confirmButtonColor:'#3085d6',
    denyButtonColor: '#d33',
    confirmButtonText: 'Oui, supprimer!',
    denyButtonText: `Annuler`,
  }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire('Supprim&eacute;!','Votre sélection de produits a été supprim&eacute;e.','success');
      } else {
        if (result.isCancel) {
          Swal.fire('Annul&eacute;!','Suppression annul&eacute;e','error');
        }
      }
    }
    )
  });
*/
  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton: 'btn btn-success',
      cancelButton: 'btn btn-danger'
    },
    buttonsStyling: false
  })
  
  swalWithBootstrapButtons.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, delete it!',
    cancelButtonText: 'No, cancel!',
    reverseButtons: true
  }).then((result) => {
    if (result.isConfirmed) {
      swalWithBootstrapButtons.fire(
        'Deleted!',
        'Your file has been deleted.',
        'success'
      )
    } else if (
      /* Read more about handling dismissals below */
      result.dismiss === Swal.DismissReason.cancel
    ) {
      swalWithBootstrapButtons.fire(
        'Cancelled',
        'Your imaginary file is safe :)',
        'error'
      )
    }
  })