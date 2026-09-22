@php
    $ga4Id = \App\Models\Setting::get('seo_google_analytics');
    
    $matomoSelfUrl = rtrim(\App\Models\Setting::get('matomo_self_hosted_url', ''), '/');
    $matomoSelfSiteId = \App\Models\Setting::get('matomo_self_hosted_site_id');
    
    $matomoCloudUrl = rtrim(\App\Models\Setting::get('matomo_cloud_url', ''), '/');
    $matomoCloudSiteId = \App\Models\Setting::get('matomo_cloud_site_id');
    
    $matomoDisableCookies = \App\Models\Setting::get('matomo_disable_cookies', '0') == '1';

    $hasMatomoSelf = !empty($matomoSelfUrl) && !empty($matomoSelfSiteId);
    $hasMatomoCloud = !empty($matomoCloudUrl) && !empty($matomoCloudSiteId);
@endphp

{{-- Google Analytics 4 (GA4) --}}
@if(!empty($ga4Id))
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id={{ $ga4Id }}"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', '{{ $ga4Id }}');
</script>
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
