<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script src="/js/previewimage.js"></script>
<script>
    var openmodal = document.querySelectorAll('.modal-open')
    for (var i = 0; i < openmodal.length; i++) {
    openmodal[i].addEventListener('click', function(event){
        event.preventDefault()
        toggleModal()
    })
    }

    const overlay = document.querySelector('.modal-overlay')
    overlay.addEventListener('click', toggleModal)

        var closemodal = document.querySelectorAll('.modal-close')
        for (var i = 0; i < closemodal.length; i++) {
        closemodal[i].addEventListener('click', toggleModal)
    }
        function toggleModal () {
        const body = document.querySelector('body')
        const modal = document.querySelector('.modal')
        modal.classList.toggle('opacity-0')
        modal.classList.toggle('pointer-events-none')
        body.classList.toggle('modal-active')
    }

    function printBook() {
        const iframe = document.createElement('iframe');
        iframe.style.display = 'none';
        iframe.src = "{{ route('book.print_book') }}";

        document.body.appendChild(iframe);

        iframe.onload = function () {
            iframe.contentWindow.print();

            iframe.contentWindow.onafterprint = function () {
                iframe.remove();
            };
        };
    }

    function printArchive() {
        const iframe = document.createElement('iframe');
        iframe.style.display = 'none';
        iframe.src = "{{ route('archive.print') }}";

        document.body.appendChild(iframe);

        iframe.onload = function () {
            iframe.contentWindow.print();

            iframe.contentWindow.onafterprint = function () {
                iframe.remove();
            };
        };
    }

</script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
