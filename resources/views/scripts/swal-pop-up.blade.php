@if(Session::has('error'))
    <script>
        $(document).ready(function() {
            var errorMessage = "{{ Session::get('error') }}";
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: errorMessage,
                confirmButtonColor: '#e74c3c' // Warna tombol untuk pesan error
            });
        });
    </script>
@endif

@if(Session::has('success'))
    <script>
        $(document).ready(function() {
            var successMessage = "{{ Session::get('success') }}";
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: successMessage,
                confirmButtonColor: '#28a745' // Warna tombol untuk pesan sukses
            });
        });
    </script>
@endif

<script>
    function confirmDelete(event, itemId) {
        event.preventDefault(); // Menghentikan submit form secara default

        Swal.fire({
            title: "Anda yakin?",
            text: "Data yang dihapus tidak dapat dipulihkan kembali!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#de968d",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, hapus!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika pengguna mengonfirmasi, lanjutkan dengan submit form
                document.getElementById("deleteForm" + itemId).submit();
            } else {
                // Jika pengguna membatalkan, tidak melakukan apa pun
                Swal.fire({
                    icon: 'info',
                    text: 'Data Anda aman tidak terhapus!',
                    confirmButtonColor: '#de968d'

                });
            }
        });
    }


</script>
