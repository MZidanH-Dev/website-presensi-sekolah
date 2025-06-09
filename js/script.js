document.addEventListener('DOMContentLoaded', function() {
    let hamburger = null;
    const nav = document.querySelector('nav');

    function createHamburger() {
        // Hapus hamburger yang ada jika sudah ada
        removeHamburger();

        // Buat hamburger baru
        hamburger = document.createElement('button');
        hamburger.className = 'hamburger';
        hamburger.innerHTML = '<i class="fas fa-bars"></i>';
        document.querySelector('header').appendChild(hamburger);

        // Tambahkan overlay
        const overlay = document.createElement('div');
        overlay.className = 'overlay';
        document.body.appendChild(overlay);

        // Setup event listeners
        setupEventListeners();
    }

    function removeHamburger() {
        const existingHamburger = document.querySelector('.hamburger');
        const overlay = document.querySelector('.overlay');
        
        if (existingHamburger) {
            existingHamburger.remove();
        }
        if (overlay) {
            overlay.remove();
        }
        
        nav.classList.remove('active');
        document.body.classList.remove('menu-open');
    }

    function setupEventListeners() {
        if (!hamburger) return;

        // Hamburger click event
        hamburger.addEventListener('click', function(e) {
            e.stopPropagation();
            nav.classList.toggle('active');
            const icon = this.querySelector('i');
            icon.classList.toggle('fa-bars');
            icon.classList.toggle('fa-times');
            document.body.classList.toggle('menu-open');
        });

        // Document click event untuk menutup menu
        document.addEventListener('click', function(e) {
            if (nav.classList.contains('active') && 
                !nav.contains(e.target) && 
                !hamburger.contains(e.target)) {
                nav.classList.remove('active');
                const icon = hamburger.querySelector('i');
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            }
        });

        // Nav links click events
        const navLinks = nav.querySelectorAll('a');
        navLinks.forEach(link => {
            link.addEventListener('click', () => {
                nav.classList.remove('active');
                const icon = hamburger.querySelector('i');
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            });
        });

        // Setup event listeners untuk overlay
        const overlay = document.querySelector('.overlay');
        overlay.addEventListener('click', () => {
            nav.classList.remove('active');
            const icon = hamburger.querySelector('i');
            icon.classList.remove('fa-times');
            icon.classList.add('fa-bars');
            document.body.classList.remove('menu-open');
        });
    }

    // Initial setup
    function init() {
        if (window.innerWidth <= 768) {
            createHamburger();
        } else {
            removeHamburger();
        }
    }

    // Initial call
    init();

    // Resize handler dengan debounce
    let resizeTimeout;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(init, 100);
    });

    // Cek URL parameters untuk alert browser
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');
    const action = urlParams.get('action');
    const message = urlParams.get('message');
    
    // Tampilkan alert browser sesuai dengan aksi
    if (status === 'success') {
        let alertMessage = '';
        switch(action) {
            case 'tambah':
                alertMessage = 'Data berhasil ditambahkan!';
                break;
            case 'edit':
                alertMessage = 'Data berhasil diubah!';
                break;
            case 'hapus':
                alertMessage = 'Data berhasil dihapus!';
                break;
        }
        if (alertMessage) {
            alert(alertMessage);
        }
    } else if (status === 'error' && message) {
        alert(message);
    }
    
    // Bersihkan URL setelah alert
    if (status) {
        const url = new URL(window.location.href);
        url.searchParams.delete('status');
        url.searchParams.delete('action');
        url.searchParams.delete('message');
        window.history.replaceState({}, '', url);
    }

    // Konfirmasi hapus data
    const deleteButtons = document.querySelectorAll('.delete-button');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            if (!confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                e.preventDefault();
            }
        });
    });
});