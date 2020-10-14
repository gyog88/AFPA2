document.querySelector("#btnsuppmulti").onclick= Swal.fire({
        title: '&Ecirc;tes-vous s&ucirc;r(e) ?',
        text: "Il sera impossible de récupérer les données supprimées!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Oui, effacer!'
      }).then((result) => {
        if (result.isConfirmed) {
          Swal.fire(
            'Deleted!',
            'Votre sélection de produits a été effacée.',
            'success'
          )
        }
      })