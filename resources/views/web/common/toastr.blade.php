<script>
    @if(session()->has('status'))
        toastr.success("{{__(session()->get('status'))}}")
    @endif
    @if (session('err'))
        toastr.error("{{__(session()->get('err'))}}")
    @endif
    @if(session()->has('clearCart'))
    Swal.fire({
        title: '{{session()->get('err')}}',
        showCancelButton: true,
        confirmButtonText: 'Clear',
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href="{{route('web.dashboard.cart.clear')}}"
        } else if (result.isDenied) {
            Swal.fire('Changes are not saved', '', 'info')
        }
    })
    @endif
</script>
