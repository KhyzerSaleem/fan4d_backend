<script src="{{ URL::asset('build/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/node-waves/waves.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/feather-icons/feather.min.js') }}"></script>
<script src="{{ URL::asset('build/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
<script src="{{ URL::asset('build/js/plugins.js') }}"></script>

@if(app()->getLocale() == 'ar')
<script src="{{ URL::asset('build/libs/flatpickr/l10n/ar.js') }}"></script>
@endif
<script>
    document.addEventListener("DOMContentLoaded", function() {
        @if(session()->has('success'))
            tostify("{{ session()->get('success') }}", "success")
        @elseif(session()->has('error'))
            tostify("{{ session()->get('error') }}", "warning")
        @else
            @foreach($errors->all() as $error)
                tostify("{{ $error }}", "danger")
            @endforeach
        @endif

    });

    function tostify(text, className){
        Toastify({
            newWindow: true,
            text: text,
            gravity: "top",
            position: "right",
            className: "bg-" + className,
            stopOnFocus: true,
            duration: 5000,
            close: true,
            // style: {
            //     background: "linear-gradient(to right, #0AB39C, #405189)"
            // },
        }).showToast();
    }
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Select the div with class "empty-notification-elem"
        var divElement = document.querySelector('.empty-notification-elem');
        if (divElement) {
            divElement.querySelector('h6').textContent = "@lang('translation.Hey! You have no any notifications')"
        }
    });
</script>

@yield('script')
@yield('script-bottom')
