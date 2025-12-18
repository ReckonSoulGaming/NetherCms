@php
    $settings = \App\GeneralSettings::first();
@endphp

<footer class="py-5 mt-auto w-100"
        style="background: linear-gradient(135deg, rgba(20, 25, 55, 0.98), rgba(10, 12, 30, 0.98));
               border-top: 1px solid rgba(108,92,231,0.4);
               backdrop-filter: blur(12px);
 
               box-shadow: 0 -10px 40px rgba(0,0,0,0.7);">
    <div class="container px-4 py-3 text-center">
        <div class="mb-4">
           
            <p class="text-gray-300 text-sm mb-0" style="font-size:0.92rem; line-height:1.7;">
                {{ $settings->website_name }} is a powerful minecraft webshop.<br class="d-none d-sm-inline">
              
            </p>
        </div>

        <div class="my-4">
            <div class="text-gray-400" style="font-size:0.85rem; line-height:2;">
                <a href="#" class="text-gray-400 hover:text-primary mx-2 transition">Privacy Policy</a> |
                <a href="#" class="text-gray-400 hover:text-primary mx-2 transition">Community Guidelines</a> |
                <a href="#" class="text-gray-400 hover:text-primary mx-2 transition">Legal Disclaimer</a> |
                <a href="#" class="text-gray-400 hover:text-primary mx-2 transition">Cookie Policy</a> |
                <a href="#" class="text-gray-400 hover:text-primary mx-2 transition">UGC Policy</a>
            </div>
        </div>

        <hr style="border-color: rgba(255,255,255,0.08); margin: 1rem auto; width: 70%;">

        <div class="text-gray-500" style="font-size:0.8rem;">
            © {{ date('Y') }} <span style="color:var(--primary); font-weight:600;">{{ $settings->website_name }}</span> • All Rights Reserved
            <p>Not affiliated with Mojang Studios or Microsoft.</p>
        </div>
    </div>
</footer>