
<div class="fixed bottom-4 right-4 z-50 w-96">
    @if(session('success'))
        <div class="bg-green-600 text-white p-4 rounded-lg shadow-lg relative alert" role="alert">
            {{ session('success') }}

            <button type="button"
                class="absolute top-0 right-0 mt-2 mr-4 text-lg hover:text-gray-300"
                onclick="this.parentElement.remove();">
                &times;
            </button>
        </div>

    @elseif(session('error'))
        <div class="bg-red-600 text-white p-4 rounded-lg shadow-lg relative alert" role="alert">
            {{ session('error') }}

            <button type="button"
                class="absolute top-0 right-0 mt-2 mr-4 text-lg hover:text-gray-300"
                onclick="this.parentElement.remove();">
                &times;
            </button>
        </div>
    @endif
</div>

<script>
     setTimeout(function () {
        const alert = document.querySelector('.alert');

        if (alert) {
            alert.style.transition = "opacity 0.5s";
            alert.style.opacity = "0";

            setTimeout(() => {
                alert.remove();
            }, 500);
        }
    }, 3000); // 3 seconds

    new TomSelect("#instructorSelect", {
        create: false,
        sortField: {
            field: "text",
            direction: "asc"
        }
    });

    new TomSelect("#bookSelect", {
        create: false
    });
</script>
