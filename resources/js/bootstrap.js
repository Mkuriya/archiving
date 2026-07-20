window._ = require('lodash');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });

/*
function showPDF(pdfUrl, title, citation, documentId, page) {
    const pdfContainer = document.getElementById('pdf-container');
    const resultsContainer = document.getElementById('results-container');
    const searchBar = document.getElementById('search-bar');
    const pdfTitle = document.getElementById('pdf-title');
    const pdfCitation = document.getElementById('pdf-citation');

    let currentPage = page; // Save current page for scrolling purposes

    searchBar.classList.add('hidden');
    resultsContainer.classList.add('hidden');
    pdfContainer.classList.remove('hidden');

    pdfTitle.textContent = title;
    pdfCitation.textContent = `Citation: ${citation}`;

    // Clear existing canvases if any
    pdfContainer.querySelectorAll('canvas').forEach(canvas => canvas.remove());

    // Render the entire PDF using pdf.js
    pdfjsLib.getDocument(pdfUrl).promise.then(function(pdf) {
        for (let pageNum = 1; pageNum <= pdf.numPages; pageNum++) {
            const canvas = document.createElement('canvas');
            canvas.id = `pdf-page-${pageNum}`;
            pdfContainer.appendChild(canvas);

            renderPDFPage(pdf, pageNum, canvas);
        }

        // Scroll to the selected page after all pages have been rendered
        setTimeout(() => {
            document.getElementById(`pdf-page-${currentPage}`).scrollIntoView({ behavior: 'smooth' });
        }, 500); // Adjust timeout if necessary depending on rendering speed

        // Re-render pages on window resize
        window.addEventListener('resize', function() {
            for (let pageNum = 1; pageNum <= pdf.numPages; pageNum++) {
                const canvas = document.getElementById(`pdf-page-${pageNum}`);
                renderPDFPage(pdf, pageNum, canvas);
            }
        });
    }).catch(function(error) {
        console.error('Error rendering PDF:', error);
    });
}

function renderPDFPage(pdf, pageNumber, canvas) {
    const pdfContainer = document.getElementById('pdf-container');

    pdf.getPage(pageNumber).then(function(page) {
        const viewport = page.getViewport({ scale: 1 });
        const containerWidth = pdfContainer.clientWidth;

        let scale = containerWidth / viewport.width;
        if (window.innerWidth > 640) { 
            scale = Math.min(1.28, containerWidth / viewport.width);
        }

        const scaledViewport = page.getViewport({ scale: scale });

        const context = canvas.getContext('2d');
        canvas.height = scaledViewport.height;
        canvas.width = scaledViewport.width;

        const renderContext = {
            canvasContext: context,
            viewport: scaledViewport
        };

        page.render(renderContext);
    });
}
*/