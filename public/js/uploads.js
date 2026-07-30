

    document.getElementById('year').value = new Date().getFullYear();
   /* document.getElementById('year').value = 202;*/

    function upperCasee(){
        const x = document.getElementById("adviser");
        x.value = x.value.toUpperCase();
    }
    function upperCase(){
        const x = document.getElementById("title");
        x.value = x.value.toUpperCase();
    }

    function filterInput(input) {
        // Regular expression to exclude unwanted characters
        input.value = input.value.replace(/[\'\";\-!(){}]/g, '');
    }
        // Function to capitalize the first letter of input value
    function capitalizeFirstLetter(input) {
        input.value = input.value.charAt(0).toUpperCase() + input.value.slice(1).toLowerCase();
    }
// Function to add a new author field
function addAuthor() {
    const container = document.getElementById('authors-container');
    const div = document.createElement('div');
    div.className = 'mb-1 flex items-center space-x-2';
    div.innerHTML = `

        <div class="bg-gray-600 w-full flex items-center space-x-1 p-2">

            <div class="w-full">
                <label for="firstname" class="text-white ml-2 mb-2">First Name</label>
                <input type="text" id="firstname" name="firstnames[]"
                    class="block w-full px-4 py-2 border rounded-md bg-gray-800 text-gray-300 border-gray-600 focus:border-white capitalize"
                    placeholder="First Name" oninput="capitalizeFirstLetter(this)">
            </div>

            <div class="w-full">
                <label for="lastname" class="text-white ml-2 mb-2">Last Name</label>
                <input type="text" id="lastname" name="lastnames[]"
                    class="block w-full px-4 py-2 border rounded-md bg-gray-800 text-gray-300 border-gray-600 focus:border-white capitalize"
                    placeholder="Last Name" oninput="capitalizeFirstLetter(this)">
            </div>

            <button type="button" onclick="removeAuthor(this)" class="p-2 text-white rounded-md">
                <svg class="w-6 h-6 text-white hover:text-red-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
                </svg>
            </button>
        </div>

    `;
    container.appendChild(div);
    updateCitation();  // Update the citation after adding a new author
}

// Function to remove an author field
function removeAuthor(button) {
    const authorField = button.parentElement;
    authorField.remove();
    updateCitation();  // Update the citation after removing an author
}

// Function to update the APA citation
function updateCitation() {
    const form = document.forms['citation-form'];
    const firstnames = Array.from(form.querySelectorAll('input[name="firstnames[]"]')).map(input => input.value.trim());
    const lastnames = Array.from(form.querySelectorAll('input[name="lastnames[]"]')).map(input => input.value.trim());
    const title = form['title'].value;
    const year = form['year'].value;

    let citation = '';
    if (firstnames.length && lastnames.length) {
        const authors = firstnames.map((firstname, i) => `${lastnames[i]}, ${firstname.charAt(0).toUpperCase()}.`);
        citation = `${authors.join(', ')} (${year}). ${title}. Published research.`;
    }
    document.getElementById('citation-preview').value = citation;

    let members = firstnames.map((firstname, i) => `${firstname} ${lastnames[i]}`).join(', ');

    // Update the members-preview textarea
    document.getElementById('members-preview').value = members;
}

document.getElementById('citation-form').addEventListener('input', updateCitation);


// Auto-close error modal after 3 seconds
const errorModal = document.getElementById('errorModalOverlay');
if (errorModal) {
    setTimeout(() => {
        errorModal.style.display = 'none';
    }, 3000);
}

// Manual close button for the modal
document.getElementById('closeErrorModal').addEventListener('click', () => {
    errorModal.style.display = 'none';
});
