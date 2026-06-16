<footer class="footer">
    <div class="container">
        <div class="cols">
            <div>
                <div class="brand" style="color:#fff; margin-bottom:12px">
                    <span class="leaf">✚</span> Fura<span style="color:#93C5FD">so</span>
                </div>
                <p>Vos médicaments, simplement et en toute sécurité. La pharmacie en ligne pensée pour le Mali.</p>
            </div>
            <div>
                <h4>Navigation</h4>
                <a href="{{ route('home') }}">Accueil</a>
                <a href="{{ route('catalogue.index') }}">Catalogue</a>
                <a href="{{ route('services') }}">Services</a>
                <a href="{{ route('pharmacies') }}">Pharmacies</a>
            </div>
            <div>
                <h4>Aide</h4>
                <a href="{{ route('about') }}">À propos</a>
                <a href="{{ route('faq') }}">FAQ</a>
                <a href="{{ route('contact') }}">Contact</a>
                <a href="{{ route('blog') }}">Blog santé</a>
            </div>
            <div>
                <h4>Contact</h4>
                <a href="tel:+22300000000">📞 +223 00 00 00 00</a>
                <a href="mailto:contact@furaso.ml">✉️ contact@furaso.ml</a>
                <a href="#">💬 WhatsApp</a>
                <a href="#">📍 Bamako, Mali</a>
            </div>
        </div>
        <div class="bottom">© {{ date('Y') }} Furaso — Tous droits réservés. Plateforme de pharmacie en ligne au Mali.</div>
    </div>
</footer>
