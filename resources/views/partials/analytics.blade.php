@php
    $ga4Id = \App\Models\Setting::get('seo_google_analytics');
    
    $matomoSelfUrl = rtrim((string) \App\Models\Setting::get('matomo_self_hosted_url', ''), '/');
    $matomoSelfSiteId = \App\Models\Setting::get('matomo_self_hosted_site_id');
    
    $matomoCloudUrl = rtrim((string) \App\Models\Setting::get('matomo_cloud_url', ''), '/');
    $matomoCloudSiteId = \App\Models\Setting::get('matomo_cloud_site_id');
    
    $matomoDisableCookies = \App\Models\Setting::get('matomo_disable_cookies', '0') == '1';

    $hasMatomoSelf = !empty($matomoSelfUrl) && !empty($matomoSelfSiteId);
    $hasMatomoCloud = !empty($matomoCloudUrl) && !empty($matomoCloudSiteId);

    $metaPixelId = \App\Models\Setting::get('seo_meta_pixel_id');
    $tiktokPixelId = \App\Models\Setting::get('seo_tiktok_pixel_id');
    $googleAdsId = \App\Models\Setting::get('seo_google_ads_id');
    $gtmId = \App\Models\Setting::get('seo_gtm_id');
    $customHeadScripts = \App\Models\Setting::get('seo_custom_head_scripts');
@endphp

{{-- Google Tag Manager --}}
@if(!empty($gtmId))
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','{{ $gtmId }}');</script>
<!-- End Google Tag Manager -->
@endif

{{-- Google Analytics 4 (GA4) & Google Ads --}}
@if(!empty($ga4Id) || !empty($googleAdsId))
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id={{ $ga4Id ?? $googleAdsId }}"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  
  @if(!empty($ga4Id))
  gtag('config', '{{ $ga4Id }}');
  @endif
  @if(!empty($googleAdsId))
  gtag('config', '{{ $googleAdsId }}');
  @endif
</script>
@endif

{{-- Meta Pixel (Facebook/Instagram Ads) --}}
@if(!empty($metaPixelId))
<!-- Meta Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '{{ $metaPixelId }}');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id={{ $metaPixelId }}&ev=PageView&noscript=1"
/></noscript>
<!-- End Meta Pixel Code -->
@endif

{{-- TikTok Pixel --}}
@if(!empty($tiktokPixelId))
<!-- TikTok Pixel Code -->
<script>
!function (w, d, t) {
  w.TiktokAnalyticsObject=t;var ttq=w[t]=w[t]||[];ttq.methods=["page","track","identify","instances","debug","on","off","once","ready","alias","group","enableCookie","disableCookie"],ttq.setAndDefer=function(t,e){t[e]=function(){t.push([e].concat(Array.prototype.slice.call(arguments,0)))}};for(var i=0;i<ttq.methods.length;i++)ttq.setAndDefer(ttq,ttq.methods[i]);ttq.instance=function(t){for(var e=ttq._i[t]||[],n=0;n<ttq.methods.length;n++)ttq.setAndDefer(e,ttq.methods[n]);return e},ttq.load=function(e,n){var i="https://analytics.tiktok.com/i18n/pixel/events.js";ttq._i=ttq._i||{},ttq._i[e]=[],ttq._i[e]._u=i,ttq._t=ttq._t||{},ttq._t[e]=+new Date,ttq._o=ttq._o||{},ttq._o[e]=n||{};var o=document.createElement("script");o.type="text/javascript",o.async=!0,o.src=i+"?sdkid="+e+"&lib="+t;var a=document.getElementsByTagName("script")[0];a.parentNode.insertBefore(o,a)};
  ttq.load('{{ $tiktokPixelId }}');
  ttq.page();
}(window, document, 'ttq');
</script>
<!-- End TikTok Pixel Code -->
@endif

{{-- Matomo Analytics (Supports Self-Hosted, Cloud, or Concurrent Dual-Tracking) --}}
@if($hasMatomoSelf || $hasMatomoCloud)
<!-- Matomo Tracking -->
<script>
  var _paq = window._paq = window._paq || [];
  @if($matomoDisableCookies)
  _paq.push(['disableCookies']);
  @endif
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);

  (function() {
    @if($hasMatomoSelf && $hasMatomoCloud)
      // Dual tracking: Matomo Self-Hosted (Primary) + Matomo Cloud (Secondary)
      var primaryUrl = "{{ $matomoSelfUrl }}/";
      _paq.push(['setTrackerUrl', primaryUrl + 'matomo.php']);
      _paq.push(['setSiteId', '{{ $matomoSelfSiteId }}']);

      var secondaryUrl = "{{ $matomoCloudUrl }}/matomo.php";
      _paq.push(['addTracker', secondaryUrl, '{{ $matomoCloudSiteId }}']);

      var d = document, g = d.createElement('script'), s = d.getElementsByTagName('script')[0];
      g.async = true; g.src = primaryUrl + 'matomo.js'; s.parentNode.insertBefore(g, s);
    @elseif($hasMatomoSelf)
      // Single tracking: Matomo Self-Hosted
      var u = "{{ $matomoSelfUrl }}/";
      _paq.push(['setTrackerUrl', u + 'matomo.php']);
      _paq.push(['setSiteId', '{{ $matomoSelfSiteId }}']);
      var d = document, g = d.createElement('script'), s = d.getElementsByTagName('script')[0];
      g.async = true; g.src = u + 'matomo.js'; s.parentNode.insertBefore(g, s);
    @elseif($hasMatomoCloud)
      // Single tracking: Matomo Cloud
      var u = "{{ $matomoCloudUrl }}/";
      _paq.push(['setTrackerUrl', u + 'matomo.php']);
      _paq.push(['setSiteId', '{{ $matomoCloudSiteId }}']);
      var d = document, g = d.createElement('script'), s = d.getElementsByTagName('script')[0];
      g.async = true; g.src = u + 'matomo.js'; s.parentNode.insertBefore(g, s);
    @endif
  })();
</script>
@if($hasMatomoSelf)
<noscript>
  <p><img referrerpolicy="no-referrer-when-downgrade" src="{{ $matomoSelfUrl }}/matomo.php?idsite={{ $matomoSelfSiteId }}&amp;rec=1" style="border:0;" alt="" /></p>
</noscript>
@elseif($hasMatomoCloud)
<noscript>
  <p><img referrerpolicy="no-referrer-when-downgrade" src="{{ $matomoCloudUrl }}/matomo.php?idsite={{ $matomoCloudSiteId }}&amp;rec=1" style="border:0;" alt="" /></p>
</noscript>
@endif
<!-- End Matomo Tracking -->
@endif

{{-- Custom Head Scripts --}}
@if(!empty($customHeadScripts))
{!! $customHeadScripts !!}
@endif

{{-- Auto PPDB & Conversion Event Tracker (Universal for GA4, Matomo, Meta Pixel, TikTok) --}}
<script>
(function() {
    function trackLeadEvent(eventName, category, label, metadata) {
        metadata = metadata || {};
        
        // 1. Google Analytics 4 (GA4) & Google Ads
        if (typeof window.gtag === 'function') {
            window.gtag('event', eventName, Object.assign({
                'event_category': category,
                'event_label': label,
                'value': 1
            }, metadata));

            // Standard Google Ads Conversion Event
            if (eventName === 'click_wa_ppdb' || eventName === 'click_spmb_portal') {
                window.gtag('event', 'generate_lead', {
                    'currency': 'IDR',
                    'value': 1,
                    'event_category': category,
                    'event_label': label
                });
            } else if (eventName === 'download_brosur') {
                window.gtag('event', 'file_download', {
                    'file_name': label,
                    'event_category': 'Brochure'
                });
            }
        }

        // 2. Matomo Analytics
        if (window._paq) {
            window._paq.push(['trackEvent', category, eventName, label]);
        }

        // 3. Meta Pixel (Facebook/Instagram Ads)
        if (typeof window.fbq === 'function') {
            window.fbq('trackCustom', eventName, { content_name: label, category: category });
            if (eventName === 'click_wa_ppdb') {
                window.fbq('track', 'Lead', { content_name: label, content_category: 'PPDB_WhatsApp' });
                window.fbq('track', 'Contact', { content_name: label });
            } else if (eventName === 'click_spmb_portal') {
                window.fbq('track', 'Lead', { content_name: label, content_category: 'Portal_SPMB' });
                window.fbq('track', 'InitiateCheckout', { content_name: label });
            } else if (eventName === 'download_brosur') {
                window.fbq('track', 'ViewContent', { content_name: label, content_type: 'brochure' });
            }
        }

        // 4. TikTok Pixel
        if (typeof window.ttq === 'object' && typeof window.ttq.track === 'function') {
            window.ttq.track('ClickButton', { content_name: label });
            if (eventName === 'click_wa_ppdb') {
                window.ttq.track('Contact', { content_name: label });
            } else if (eventName === 'click_spmb_portal') {
                window.ttq.track('CompleteRegistration', { content_name: label });
            } else if (eventName === 'download_brosur') {
                window.ttq.track('Download', { content_name: label });
            }
        }

        // 5. Internal CMS Lead Logging
        try {
            const trackUrl = '{{ url("/api/analytics/track-event") }}';
            const payload = JSON.stringify({
                event: eventName,
                category: category,
                label: label,
                path: window.location.pathname + window.location.search
            });
            if (navigator.sendBeacon) {
                const blob = new Blob([payload], { type: 'application/json' });
                navigator.sendBeacon(trackUrl, blob);
            } else {
                fetch(trackUrl, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                    body: payload,
                    keepalive: true
                }).catch(function() {});
            }
        } catch (err) {}
    }

    document.addEventListener('click', function(e) {
        const target = e.target.closest('a, button');
        if (!target) return;

        const href = target.getAttribute('href') || '';
        const text = (target.innerText || '').trim();

        // A. WhatsApp PPDB / General Chat Click
        if (href.includes('wa.me') || href.includes('whatsapp.com') || target.classList.contains('mobile-fab-whatsapp') || target.classList.contains('btn-track-ppdb-wa')) {
            const isPpdb = href.toLowerCase().includes('ppdb') || 
                           href.toLowerCase().includes('santri') || 
                           href.toLowerCase().includes('daftar') || 
                           text.toLowerCase().includes('ppdb') || 
                           text.toLowerCase().includes('spmb') || 
                           target.classList.contains('btn-track-ppdb-wa');
            const eventName = isPpdb ? 'click_wa_ppdb' : 'click_whatsapp_general';
            trackLeadEvent(eventName, 'Contact', text || 'WhatsApp Chat', { destination: href, location: window.location.pathname });
        }
        
        // B. SPMB Portal Click
        else if (href.includes('spmb') || target.classList.contains('nav-spmb') || target.classList.contains('btn-track-ppdb-spmb')) {
            trackLeadEvent('click_spmb_portal', 'PPDB', text || 'Portal SPMB Online', { destination: href, location: window.location.pathname });
        }

        // C. Download Brosur / Dokumen PDF
        else if (href.match(/\.pdf($|\?)/i) || text.toLowerCase().includes('brosur') || text.toLowerCase().includes('unduh')) {
            trackLeadEvent('download_brosur', 'Brochure', text || 'Download Dokumen PPDB', { file_url: href, location: window.location.pathname });
        }
    }, true);
})();
</script>

