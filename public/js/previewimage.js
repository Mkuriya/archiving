
    function previewImage(event) {
        const input = event.target;
        const reader = new FileReader();
        
        reader.onload = function() {
            const dataURL = reader.result;
            const imagePreview = document.getElementById('imagePreview');
            imagePreview.src = dataURL;
        };
        
        reader.readAsDataURL(input.files[0]);
    }

    document.getElementById('studentnumber').addEventListener('input', function (event) {
        if (this.value.length > 10) {
            this.value = this.value.slice(0, 10);
        }
    });
    document.getElementById('studentnumber').addEventListener('input', function() {
        var studentNumber = this.value;
        var email = studentNumber + '@dhvsu.edu.ph';
        document.getElementById('email').value = email;
    });
    document.getElementById('studentnumber').addEventListener('input', function (event) {
        if (this.value.length > 10) {
            this.value = this.value.slice(0, 10);
        }
    });
    document.getElementById('studentnumber').addEventListener('input', function() {
        var studentNumber = this.value;
        var email = studentNumber + '@dhvsu.edu.ph';
        document.getElementById('email').value = email;
    });