    <div class="card-store" 
         style="
            position: relative;
            height: 100%;
            display: flex;
            flex-direction: column;
            background: rgba(0,0,0,0.35);
            border-radius: 12px;
            backdrop-filter: blur(8px);
            box-shadow: 0 0 25px rgba(255, 215, 0, 0.08);
            padding: 0;
         ">

         {{--  BADGE --}}
        @if($package->badge_text)
            <div style="
                position: absolute; top: 12px;
                left: 12px;
                background: #ff3b3b;
                padding: 8px 18px;
                color: white; font-weight: bold;
                transform: rotate(-12deg);
                z-index: 20;
                box-shadow: 0 6px 15px rgba(255,0,0,0.5);
                border-radius: 4px;
            ">
                {{ strtoupper($package->badge_text) }}
            </div>
        @endif

         {{--  RIBBON --}}
        @if($package->ribbon_text)
            <div style="
                position: absolute; top: 12px; right: 12px;
                background: #00e0c6;
                color: white; font-weight: bold;
                padding: 6px 16px;
                border-radius: 30px;
                z-index: 20;
                box-shadow: 0 4px 15px rgba(0,255,220,0.35);
            ">
                {{ strtoupper($package->ribbon_text) }}
            </div>
        @endif



         {{--  FULL-WIDTH IMAGE --}}
        <div style="margin:0; padding:0;">
            <img src="{{ asset('uploads/packages/cover/' . $package->package_image_path) }}"
                 alt="{{ $package->package_name }}"
                 style="
                    width: 100%;
                    height: 240px;
                    object-fit: cover;
                    display: block;
                    border-radius: 12px 12px 0 0;
                    margin: 0;
                    padding: 0;
                 ">
        </div>

         {{--  CONTENT --}}
        <div style="flex-grow: 1; text-align: center; padding: 20px;">

             {{--  ITEM NAME (GOLD GLOW) --}}
            <h3 style="
                font-size: 1.4rem;
                font-weight: 900;
                color: #f7d776;
                text-shadow: 0 0 10px rgba(255, 215, 0, 0.6);
                margin-bottom: 8px;
            ">
                {{ strtoupper($package->package_name) }}
            </h3>

             {{--  SHORT DESC --}}
            <p style="
                color: #ffffff;
                margin-bottom: 16px;
                font-size: 1rem;
            ">
                {{ $package->package_desc }}
            </p>

             {{--  FEATURES BOX --}}
          {{--  FEATURES – MODERN, SCROLLABLE, PREMIUM LOOK --}}
@if($package->package_features)
    <div class="mb-4">
        <div class="p-4 rounded-2xl border border-gray-700/50 
                    bg-gray-900/60 backdrop-blur-md shadow-inner
                    max-h-32 overflow-y-auto custom-scrollbar">
            @php
                $features = preg_split('/\r\n|\r|\n/', $package->package_features);
            @endphp
            @foreach($features as $feature)
                @if(trim($feature))
                    <div class="d-flex align-items-center gap-3 mb-3 text-gray-200">
                        <i class="fas fa-check-circle text-emerald-400 flex-shrink-0"></i>
                        <span class="text-sm leading-relaxed">{{ trim($feature) }}</span>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endif
<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: rgba(255,255,255,0.05);
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: linear-gradient(to bottom, #00d4ff, #ff00ff);
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0,212,255,0.5);
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(to bottom, #00ffff, #ff33ff);
    }
</style>
             {{--  PRICE --}}
            <div style="margin-top: 18px;">
                @if($package->package_discount_price)
                    <p style="text-decoration: line-through; color: #888; margin: 0;">
                {{ currency_symbol() }}{{ number_format(currency_convert($package->package_price), 2) }}

                    </p>

                    <p style="
                        font-size: 2rem;
                        font-weight: 900;
                        color: #ff5555;
                        text-shadow: 0 0 12px rgba(255, 0, 0, 0.35);
                        margin-top: 2px;
                    ">
                     {{ currency_symbol() }}{{ number_format(currency_convert($package->package_discount_price), 2) }}

                    </p>
                @else
                    <p style="
                        font-size: 2rem;
                        font-weight: 900;
                        color: #5cff9d;
                        text-shadow: 0 0 12px rgba(0,255,100,0.35);
                        margin: 0;
                    ">
                      {{ currency_symbol() }}{{ number_format(currency_convert($package->package_price), 2) }}

                    </p>
                @endif
            </div>

             {{--  BUY BUTTON (GLOW) --}}
            <a href="/store/checkout/{{ $package->package_id }}"
               class="btn w-100 rounded-pill"
               style="
                    margin-top: 12px;
                    background: linear-gradient(90deg, #1da1f2, #4a8bff);
                    color: #fff;
                    font-weight: bold;
                    padding: 14px;
                    font-size: 1.15rem;
                    border: none;
                    box-shadow: 0 4px 15px rgba(0, 140, 255, 0.5);
                    transition: 0.25s ease-in-out;
               "
               onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 0 25px rgba(0,140,255,0.8)';"
               onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 4px 15px rgba(0,140,255,0.5)';"
            >
                <i class="fas fa-cart-plus"></i> &nbsp; BUY NOW
            </a>

        </div>
    </div>