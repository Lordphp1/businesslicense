<footer class="site-footer">
    <div class="container container-mia">
        <div class="row g-5">
            <div class="col-lg-4">
                <x-brand light />
                <p class="footer-about mt-4">
                    A private investment and business development agency supporting local and
                    international investors through every stage of establishment and growth.
                </p>
            </div>
            <div class="col-6 col-lg-2">
                <h3>Invest</h3>
                <ul class="footer-links">
                    <li><a href="{{ route('opportunities.index') }}">Opportunities</a></li>
                    <li><a href="{{ route('sectors.index') }}">Priority Sectors</a></li>
                    <li><a href="{{ route('services') }}">Investor Services</a></li>
                    <li><a href="{{ route('news.index') }}">News &amp; Reports</a></li>
                </ul>
            </div>
            <div class="col-6 col-lg-2">
                <h3>Business Setup</h3>
                <ul class="footer-links">
                    <li><a href="{{ route('start-business') }}">Start a Business</a></li>
                    <li><a href="{{ route('registration') }}">Registration Assistance</a></li>
                    <li><a href="{{ route('licensing') }}">Licensing Services</a></li>
                    @auth
                        @if (auth()->user()->isAdmin())
                            <li><a href="{{ route('admin.dashboard') }}">Admin Console</a></li>
                        @else
                            <li><a href="{{ route('dashboard') }}">Investor Dashboard</a></li>
                        @endif
                    @else
                        <li><a href="{{ route('login') }}">Investor Login</a></li>
                    @endauth
                </ul>
            </div>
            <div class="col-lg-4">
                <h3>Contact</h3>
                <ul class="footer-contact">
                    <li><x-icon name="map-pin" /><span>Sheikh Zayed Road, Trade Centre 2, Dubai, United Arab Emirates</span></li>
                    <li><x-icon name="mail" /><a href="mailto:info@economicdevelopmentagencyuae.com">info@economicdevelopmentagencyuae.com</a></li>
                    <li><x-icon name="phone" /><a href="tel:+97143120000">+971 4 312 0000</a></li>
                    <li><x-icon name="clock" /><span>Office hours: Monday to Friday, 08:30–17:30 GST</span></li>
                </ul>
            </div>
        </div>

        <div class="footer-disclaimer">
            <strong class="d-block text-white mb-1">Legal notice.</strong>
            {{ config('app.name') }} is a privately operated agency. It is not a government authority and does
            not issue statutory approvals. Government-issued incorporation certificates and licenses are granted
            only by the responsible public authorities. Registration and licensing timelines, fees and
            requirements shown on this website are provisional and must be confirmed with the applicable
            authorities before acting on them.
        </div>

        <div class="footer-bottom d-flex flex-wrap justify-content-between gap-3">
            <span>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</span>
            <span class="d-flex gap-4">
                <a href="{{ route('about') }}">About</a>
                <a href="{{ route('contact') }}">Contact</a>
                <a href="{{ route('contact') }}">Privacy</a>
            </span>
        </div>
    </div>
</footer>
