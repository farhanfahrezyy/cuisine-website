@extends('layouts.layoutpages')

@section('title', 'Hubungi Kami')

@section('content')
<div class="uk-section uk-section-default">
    <div class="uk-container">
        <div class="uk-grid uk-grid-large" data-uk-grid>
            <!-- Left Side Content -->
            <div class="uk-width-1-2@m">
                <h2 class="uk-heading-medium uk-margin-remove-top">Hubungi Kami</h2>

                <p class="uk-margin-medium-top">
                    Punya pertanyaan atau butuh bantuan? Tim kami siap membantu Anda melalui WhatsApp.
                </p>

                <div class="uk-margin-medium-top">
                    <div class="uk-flex uk-flex-middle uk-margin-small-bottom">
                        <span class="uk-margin-small-right" uk-icon="icon: whatsapp; ratio: 1.2" style="color: #25D366;"></span>
                        <span id="phone-number">+62 812 3456 7890</span>
                    </div>
                    <div class="uk-flex uk-flex-middle">
                        <span class="uk-margin-small-right" uk-icon="icon: clock; ratio: 1.2"></span>
                        <span>Senin-Jumat, 09:00-17:00 WIB</span>
                    </div>
                </div>

                <div class="uk-margin-medium-top">
                    <button onclick="openWhatsApp()" class="uk-button uk-button-primary uk-border-rounded">
                        <span uk-icon="icon: whatsapp"></span> Chat via WhatsApp
                    </button>
                </div>
            </div>

            <!-- Right Side Form -->
            <div class="uk-width-1-2@m">
                <div class="uk-card uk-card-default uk-card-body uk-border-rounded">
                    <h3 class="uk-card-title">Kirim Pesan</h3>
                    <form id="contactForm">
                        <div class="uk-margin">
                            <label class="uk-form-label" for="name">Nama Lengkap</label>
                            <div class="uk-form-controls">
                                <input class="uk-input uk-border-rounded" id="name" type="text" required>
                            </div>
                        </div>

                        <div class="uk-margin">
                            <label class="uk-form-label" for="message">Pesan</label>
                            <div class="uk-form-controls">
                                <textarea class="uk-textarea uk-border-rounded" id="message" rows="4" required></textarea>
                            </div>
                        </div>

                        <div class="uk-margin-top">
                            <button type="button" onclick="sendMessage()" class="uk-button uk-button-primary uk-border-rounded uk-width-1-1">
                                Kirim via WhatsApp
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function openWhatsApp() {
        const phoneNumber = document.getElementById('phone-number').textContent.replace(/\D/g, '');
        window.open(`https://wa.me/${phoneNumber}`, '_blank');
    }

    function sendMessage() {
        const name = document.getElementById('name').value;
        const message = document.getElementById('message').value;
        const phoneNumber = document.getElementById('phone-number').textContent.replace(/\D/g, '');

        if (!name || !message) {
            UIkit.notification({
                message: 'Harap isi nama dan pesan terlebih dahulu',
                status: 'warning',
                pos: 'top-center',
                timeout: 3000
            });
            return;
        }

        const encodedMessage = encodeURIComponent(`Halo, saya ${name}.\n\n${message}`);
        window.open(`https://wa.me/${phoneNumber}?text=${encodedMessage}`, '_blank');

        // Reset form
        document.getElementById('contactForm').reset();

        // Show success notification
        UIkit.notification({
            message: 'Mengarahkan ke WhatsApp...',
            status: 'success',
            pos: 'top-center',
            timeout: 2000
        });
    }
</script>
@endsection
