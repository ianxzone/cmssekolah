@php
    $gtmId = \App\Models\Setting::get('seo_gtm_id');
    $customFooterScripts = \App\Models\Setting::get('seo_custom_footer_scripts');
@endphp

@if(!empty($gtmId))
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $gtmId }}"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
@endif

@if(!empty($customFooterScripts))
{!! $customFooterScripts !!}
@endif

<!-- Conversion Events Tracking Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Track Form Submissions
        document.addEventListener('submit', function(e) {
            if (e.target.tagName === 'FORM') {
                var formName = e.target.getAttribute('name') || e.target.getAttribute('id') || 'Form';
                var formAction = e.target.getAttribute('action') || '';
                var leadType = formAction.includes('spmb') ? 'Pendaftaran' : (formAction.includes('guestbook') ? 'BukuTamu' : 'Lead');
                
                // Track to Meta Pixel
                if (typeof fbq !== 'undefined') fbq('track', 'Lead', {content_name: formName, lead_type: leadType});
                // Track to Google Ads / GA4
                if (typeof gtag !== 'undefined') gtag('event', 'generate_lead', {form_name: formName, lead_type: leadType});
                // Track to TikTok
                if (typeof ttq !== 'undefined') ttq.track('SubmitForm', {content_name: formName, lead_type: leadType});
            }
        });

        // Track WhatsApp Clicks
        document.addEventListener('click', function(e) {
            var el = e.target.closest('a');
            if (el && el.href && (el.href.includes('wa.me') || el.href.includes('api.whatsapp.com'))) {
                // Track to Meta Pixel
                if (typeof fbq !== 'undefined') fbq('track', 'Contact');
                // Track to Google Ads / GA4
                if (typeof gtag !== 'undefined') gtag('event', 'generate_lead', {method: 'WhatsApp'});
                // Track to TikTok
                if (typeof ttq !== 'undefined') ttq.track('Contact');
            }
        });
    });
</script>
